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

use PSX\Schema\Type\AnyType;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\GenericType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\UnionType;

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
    public static function walk(TypeInterface $type, \Closure $visitor)
    {
        $visitor($type);

        if ($type instanceof StructType) {
            $properties = $type->getProperties();
            if (is_iterable($properties)) {
                foreach ($properties as $property) {
                    self::walk($property, $visitor);
                }
            }
        } elseif ($type instanceof MapType) {
            $additionalProperties = $type->getAdditionalProperties();
            if ($additionalProperties instanceof TypeInterface) {
                self::walk($additionalProperties, $visitor);
            }
        } elseif ($type instanceof ArrayType) {
            $items = $type->getItems();
            if ($items instanceof TypeInterface) {
                self::walk($items, $visitor);
            }
        } elseif ($type instanceof UnionType) {
            $oneOf = $type->getOneOf();
            if (is_iterable($oneOf)) {
                foreach ($oneOf as $property) {
                    self::walk($property, $visitor);
                }
            }
        } elseif ($type instanceof IntersectionType) {
            $allOf = $type->getAllOf();
            if (is_iterable($allOf)) {
                foreach ($allOf as $property) {
                    self::walk($property, $visitor);
                }
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

            if ($format !== null && $type instanceof ScalarType) {
                $found = $type->getFormat() === $format;
            } else {
                $found = true;
            }
        });

        return $found;
    }

    /**
     * Normalizes all reference types and removes the self namespace
     * 
     * @param TypeInterface $type
     */
    public static function normalize(TypeInterface $type): void
    {
        self::walk($type, function(TypeInterface $type){
            if (!$type instanceof ReferenceType) {
                return;
            }

            [$ns, $name] = self::split($type->getRef());

            if ($ns === DefinitionsInterface::SELF_NAMESPACE) {
                $type->setRef($name);
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
        if ($type instanceof AnyType) {
            return 'any';
        } elseif ($type instanceof ArrayType) {
            return 'array';
        } elseif ($type instanceof BooleanType) {
            return 'boolean';
        } elseif ($type instanceof GenericType) {
            return 'generic';
        } elseif ($type instanceof IntegerType) {
            return 'integer';
        } elseif ($type instanceof IntersectionType) {
            return 'intersection';
        } elseif ($type instanceof MapType) {
            return 'map';
        } elseif ($type instanceof NumberType) {
            return 'number';
        } elseif ($type instanceof ReferenceType) {
            return 'reference';
        } elseif ($type instanceof StringType) {
            return 'string';
        } elseif ($type instanceof StructType) {
            return 'struct';
        } elseif ($type instanceof UnionType) {
            return 'union';
        } else {
            return 'unknown';
        }
    }
}
