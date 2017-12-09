<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Generator;

use PSX\Schema\GeneratorInterface;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
use PSX\Schema\SchemaInterface;

/**
 * Protobuf
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Protobuf implements GeneratorInterface
{
    use GeneratorTrait;

    private $generated;
    private $objects;
    
    public function generate(SchemaInterface $schema)
    {
        $this->generated = [];
        $this->objects   = [];

        $result = '';
        $result.= 'syntax = "proto3";' . "\n";
        $result.= $this->generateObject($schema->getDefinition());

        return $result;
    }

    protected function generateObject(PropertyInterface $type)
    {
        $result = '';
        $name   = $this->getIdentifierForProperty($type);

        if (in_array($name, $this->generated)) {
            return '';
        }

        $this->generated[] = $name;

        $properties = $type->getProperties();
        if (!empty($properties)) {
            $index  = 1;
            $result.= 'message ' . $name . ' {' . "\n";

            foreach ($properties as $name => $property) {
                /** @var PropertyInterface $property */
                $type = $this->getTypeOfProperty($property, $name, $index, 2);

                if ($type !== null) {
                    $result.= $type . "\n";
                    $index++;
                }
            }

            $result.= '}' . "\n";
        }

        foreach ($this->objects as $property) {
            $result.= $this->generateObject($property);
        }

        return $result;
    }

    protected function getTypeOfProperty(PropertyInterface $property, $name, &$index, $indent)
    {
        $type  = $this->getRealType($property);
        $proto = $this->getTypeForProperty($type, $property);
        $oneOf = $property->getOneOf();

        if ($proto !== null) {
            return str_repeat(' ', $indent) . $proto . ' ' . $name . ($index !== null ? ' = ' . $index . ';' : '');
        } elseif ($type == PropertyType::TYPE_ARRAY) {
            $items = $property->getItems();
            if ($items instanceof PropertyInterface) {
                return str_repeat(' ', $indent) . 'repeated ' . $this->getTypeOfProperty($items, $name, $index, 0);
            } else {
                throw new \RuntimeException('Array items must be a schema');
            }
        } elseif ($type == PropertyType::TYPE_OBJECT) {
            $additionalProperties = $property->getAdditionalProperties();
            if ($additionalProperties instanceof PropertyInterface) {
                $subType  = $this->getRealType($additionalProperties);
                $subProto = $this->getTypeForProperty($subType, $additionalProperties);

                if ($subProto !== null) {
                    return str_repeat(' ', $indent) . 'map<string, ' . $subProto . '> ' . $name . ($index !== null ? ' = ' . $index . ';' : '');
                } elseif ($subType == PropertyType::TYPE_OBJECT) {
                    $this->objects[] = $additionalProperties;
                    return str_repeat(' ', $indent) . 'map<string, ' . $this->getIdentifierForProperty($property) . '> ' . $name . ($index !== null ? ' = ' . $index . ';' : '');
                } else {
                    throw new \RuntimeException('Object additional items must be a scalar or object schema');
                }
            } else {
                $this->objects[] = $property;
                return str_repeat(' ', $indent) . $this->getIdentifierForProperty($property) . ' ' . $name . ($index !== null ? ' = ' . $index . ';' : '');
            }
        } elseif (!empty($oneOf)) {
            $name   = $this->getNameForProperty($property);
            $result = str_repeat(' ', $indent) . 'oneof ' . $name . ' {';
            foreach ($oneOf as $key => $prop) {
                $name = $this->getNameForProperty($prop);
                if ($key > 0) {
                    $index++;
                }
                $result.= ' ' . $this->getTypeOfProperty($prop, $name, $index, 0);
            }
            $result.= ' }';
            return $result;
        }

        return null;
    }

    protected function getNameForProperty(PropertyInterface $property)
    {
        return strtolower($this->getIdentifierForProperty($property));
    }

    protected function getTypeForProperty($type, PropertyInterface $property)
    {
        if ($type == PropertyType::TYPE_STRING) {
            if ($property->getFormat() == PropertyType::FORMAT_BINARY) {
                return 'bytes';
            } else {
                return 'string';
            }
        } elseif ($type == PropertyType::TYPE_INTEGER) {
            if ($property->getFormat() == PropertyType::FORMAT_INT64) {
                return 'int64';
            } else {
                return 'int32';
            }
        } elseif ($type == PropertyType::TYPE_NUMBER) {
            return 'float';
        } elseif ($type == PropertyType::TYPE_BOOLEAN) {
            return 'bool';
        }

        return null;
    }
}
