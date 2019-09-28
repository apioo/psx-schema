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
 * Typescript
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Typescript implements GeneratorInterface
{
    use GeneratorTrait;

    private $generated;
    private $objects;
    
    public function generate(SchemaInterface $schema)
    {
        $this->generated = [];
        $this->objects   = [];

        return $this->generateObject($schema->getDefinition());
    }

    protected function generateObject(PropertyInterface $type)
    {
        $result = '';
        $name   = $this->getIdentifierForProperty($type);

        if (in_array($name, $this->generated)) {
            return '';
        }

        $this->generated[] = $name;

        $indent     = str_repeat(' ', 4);
        $properties = $type->getProperties();
        $additional = $type->getAdditionalProperties();

        $result.= 'interface ' . $name . ' {' . "\n";

        if (!empty($properties)) {
            $required = $type->getRequired() ?: [];

            foreach ($properties as $name => $property) {
                /** @var PropertyInterface $property */
                $type = $this->getTypeOfProperty($property);
                if ($type !== null) {
                    if (strpos($name, '-') !== false) {
                        $name = '"' . $name . '"';
                    }

                    $result.= $indent . $name . (in_array($name, $required) ? '' : '?') . ': ' . $type . "\n";
                }
            }
        }

        if ($additional === true) {
            // in this case we have simply an object which allows other
            // properties
            $result.= $indent . '[index: string]: any;' . "\n";
        } elseif ($additional instanceof PropertyInterface) {
            /** @var PropertyInterface $property */
            $type = $this->getTypeOfProperty($additional);
            if ($type !== null) {
                $result.= $indent . '[index: string]: ' . $type . "\n";
            } else {
                $result.= $indent . '[index: string]: any;' . "\n";
            }
        }

        $result.= '}' . "\n";

        foreach ($this->objects as $property) {
            $result.= $this->generateObject($property, $depth + 1);
        }

        return $result;
    }

    protected function getTypeOfProperty(PropertyInterface $property)
    {
        $type  = $this->getRealType($property);
        $proto = $this->getTypeForProperty($type, $property);
        $oneOf = $property->getOneOf();
        $allOf = $property->getAllOf();

        if ($proto !== null) {
            return $proto;
        } elseif ($type == PropertyType::TYPE_ARRAY) {
            $items = $property->getItems();
            if ($items instanceof PropertyInterface) {
                return 'Array<' . $this->getTypeOfProperty($items) . '>';
            } else {
                throw new \RuntimeException('Array items must be a schema');
            }
        } elseif ($type == PropertyType::TYPE_OBJECT) {
            $this->objects[] = $property;
            return $this->getIdentifierForProperty($property);
        } elseif (!empty($oneOf)) {
            $parts = [];
            foreach ($oneOf as $prop) {
                $parts[] = $this->getTypeOfProperty($prop);
            }
            return implode(' | ', $parts);
        } elseif (!empty($allOf)) {
            $parts = [];
            foreach ($allOf as $prop) {
                $parts[] = $this->getTypeOfProperty($prop);
            }
            return implode(' & ', $parts);
        }

        return 'any';
    }

    protected function getTypeForProperty($type, PropertyInterface $property)
    {
        if ($type == PropertyType::TYPE_STRING) {
            return 'string';
        } elseif ($type == PropertyType::TYPE_INTEGER) {
            return 'number';
        } elseif ($type == PropertyType::TYPE_NUMBER) {
            return 'number';
        } elseif ($type == PropertyType::TYPE_BOOLEAN) {
            return 'boolean';
        }

        return null;
    }
}
