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
 * Go
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Go implements GeneratorInterface, TypeAwareInterface
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

    public function getType(PropertyInterface $property): string
    {
        $type  = $this->getRealType($property);
        $oneOf = $property->getOneOf();
        $allOf = $property->getAllOf();

        if ($type == PropertyType::TYPE_STRING) {
            if ($property->getFormat() == PropertyType::FORMAT_DATETIME) {
                return 'time.Time';
            } elseif ($property->getFormat() == PropertyType::FORMAT_DATE) {
                return 'time.Time';
            } elseif ($property->getFormat() == PropertyType::FORMAT_DURATION) {
                return 'time.Duration';
            } elseif ($property->getFormat() == PropertyType::FORMAT_TIME) {
                return 'time.Time';
            } else {
                return 'string';
            }
        } elseif ($type == PropertyType::TYPE_INTEGER) {
            if ($property->getFormat() == PropertyType::FORMAT_INT32) {
                return 'int32';
            } elseif ($property->getFormat() == PropertyType::FORMAT_INT64) {
                return 'int64';
            } else {
                return 'int';
            }
        } elseif ($type == PropertyType::TYPE_NUMBER) {
            return 'float64';
        } elseif ($type == PropertyType::TYPE_BOOLEAN) {
            return 'bool';
        } elseif ($type == PropertyType::TYPE_ARRAY) {
            $items = $property->getItems();
            if ($items instanceof PropertyInterface) {
                return '[]' . $this->getType($items);
            } else {
                throw new \RuntimeException('Array items must be a schema');
            }
        } elseif ($type == PropertyType::TYPE_OBJECT) {
            $additional = $property->getAdditionalProperties();
            if ($additional === true) {
                return 'map[string]interface{}';
            } elseif ($additional instanceof PropertyInterface) {
                /** @var PropertyInterface $property */
                $type = $this->getType($additional);
                if ($type !== null) {
                    return 'map[string]' . $type;
                } else {
                    return 'map[string]interface{}';
                }
            }

            $this->objects[] = $property;
            return $this->getIdentifierForProperty($property);
        } elseif (!empty($oneOf)) {
            // @TODO handle one of
        } elseif (!empty($allOf)) {
            // @TODO handle all of
        }

        return 'interface{}';
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

        $result.= '// ' . $name;

        $description = $type->getDescription();
        if (!empty($description)) {
            $result.= ' ' . $description;
        }

        $result.= "\n";
        $result.= 'type ' . $name . ' struct {' . "\n";

        if (!empty($properties)) {
            foreach ($properties as $name => $property) {
                /** @var PropertyInterface $property */
                $type = $this->getType($property);
                $key  = $this->normalizeName($name);

                $result.= $indent . $key . ' ' . $type . ' `json:"' . $name . '"`' . "\n";

                $this->objects = array_merge($this->objects, $this->getSubSchemas($property));
            }
        }

        $result.= '}' . "\n";

        foreach ($this->objects as $property) {
            $result.= $this->generateObject($property);
        }

        return $result;
    }

    private function normalizeName(string $name)
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $name)));
    }
}
