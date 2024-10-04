<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PSX\Schema;

use PSX\Schema\Type\AnyPropertyType;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\BooleanPropertyType;
use PSX\Schema\Type\CollectionPropertyType;
use PSX\Schema\Type\GenericPropertyType;
use PSX\Schema\Type\IntegerPropertyType;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\ScalarPropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\Type\PropertyTypeAbstract;

/**
 * TypeUtil
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TypeUtil
{
    /**
     * Walks through every nested element of the type and calls the visitor 
     * callback for each type
     * 
     * @param TypeInterface $type
     * @param \Closure $visitor
     */
    public static function walk(TypeInterface $type, \Closure $visitor): void
    {
        $visitor($type);

        if ($type instanceof StructDefinitionType) {
            $properties = $type->getProperties();
            if (is_iterable($properties)) {
                foreach ($properties as $property) {
                    self::walk($property, $visitor);
                }
            }
        } elseif ($type instanceof MapDefinitionType) {
            $schema = $type->getSchema();
            if ($schema instanceof PropertyTypeAbstract) {
                self::walk($schema, $visitor);
            }
        } elseif ($type instanceof CollectionPropertyType) {
            $schema = $type->getSchema();
            if ($schema instanceof PropertyTypeAbstract) {
                self::walk($schema, $visitor);
            }
        }
    }

    /**
     * Checks whether the type contains a specific type
     */
    public static function contains(TypeInterface $type, string $class, ?Format $format = null): bool
    {
        $found = false;
        self::walk($type, function(TypeInterface $type) use ($class, $format, &$found) {
            if ($found === true) {
                return;
            }

            if (!$type instanceof $class) {
                return;
            }

            if ($format !== null && $type instanceof ScalarPropertyType) {
                $found = $type->getFormat() === $format;
            } else {
                $found = true;
            }
        });

        return $found;
    }

    /**
     * Normalizes all reference types and removes the self namespace
     */
    public static function normalize(TypeInterface $type): void
    {
        self::refs($type, function(string $ns, string $name){
            if ($ns === DefinitionsInterface::SELF_NAMESPACE) {
                return $name;
            } else {
                return $ns . ':' . $name;
            }
        });
    }

    /**
     * Goes through all refs and replaces the ref using a specific callback
     */
    public static function refs(TypeInterface $type, \Closure $callback): void
    {
        self::walk($type, function(TypeInterface $type) use ($callback){
            if ($type instanceof ReferencePropertyType) {
                [$ns, $name] = self::split($type->getRef());
                $type->setRef($callback($ns, $name));

                $template = $type->getTemplate();
                if (!empty($template)) {
                    $result = [];
                    foreach ($template as $key => $ref) {
                        [$ns, $name] = self::split($ref);
                        $result[$key] = $callback($ns, $name);
                    }
                    $type->setTemplate($result);
                }
            } elseif ($type instanceof StructDefinitionType) {
                $extends = $type->getParent();
                if (!empty($extends)) {
                    [$ns, $name] = self::split($extends);
                    $type->setParent($callback($ns, $name));
                }
            }
        });
    }

    /**
     * Splits a type name into the namespace and name
     * 
     * @param string $ref
     * @return array
     */
    public static function split(string $ref): array
    {
        if (str_contains($ref, ':')) {
            $parts = explode(':', $ref, 2);
            $ns    = $parts[0] ?? '';
            $name  = $parts[1] ?? '';
        } else {
            $ns    = DefinitionsInterface::SELF_NAMESPACE;
            $name  = $ref;
        }

        return [$ns, $name];
    }

    /**
     * @param string $ref
     * @return string
     */
    public static function getFullyQualifiedName(string $ref): string
    {
        [$ns, $name] = self::split($ref);
        return $ns . ':' . $name;
    }

    public static function getTypeName(TypeInterface $type): string
    {
        if ($type instanceof AnyPropertyType) {
            return 'any';
        } elseif ($type instanceof ArrayPropertyType) {
            return 'array';
        } elseif ($type instanceof BooleanPropertyType) {
            return 'boolean';
        } elseif ($type instanceof GenericPropertyType) {
            return 'generic';
        } elseif ($type instanceof IntegerPropertyType) {
            return 'integer';
        } elseif ($type instanceof MapDefinitionType) {
            return 'map';
        } elseif ($type instanceof NumberPropertyType) {
            return 'number';
        } elseif ($type instanceof ReferencePropertyType) {
            return 'reference';
        } elseif ($type instanceof StringPropertyType) {
            return 'string';
        } elseif ($type instanceof StructDefinitionType) {
            return 'struct';
        } else {
            return 'unknown';
        }
    }
}
