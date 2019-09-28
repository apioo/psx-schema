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
 * Java
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Java implements GeneratorInterface, TypeAwareInterface
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
            return 'String';
        } elseif ($type == PropertyType::TYPE_INTEGER) {
            return 'int';
        } elseif ($type == PropertyType::TYPE_NUMBER) {
            return 'float';
        } elseif ($type == PropertyType::TYPE_BOOLEAN) {
            return 'boolean';
        } elseif ($type == PropertyType::TYPE_ARRAY) {
            $items = $property->getItems();
            if ($items instanceof PropertyInterface) {
                return $this->getType($items) . '[]';
            } else {
                throw new \RuntimeException('Array items must be a schema');
            }
        } elseif ($type == PropertyType::TYPE_OBJECT) {
            return $this->getIdentifierForProperty($property);
        } elseif (!empty($oneOf)) {
            // @TODO implement one of
        } elseif (!empty($allOf)) {
            // @TODO implement all of
        }

        return 'Object';
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

        $extends = '';
        if ($additional === true) {
            $extends = 'extends HashMap<String, Object> ';
        } elseif ($additional instanceof PropertyInterface) {
            $extends = 'extends HashMap<String, ' . $this->getType($additional) . '> ';
        }

        $result.= 'public static class ' . $name . ' ' . $extends . '{' . "\n";

        if (!empty($properties)) {
            $required = $type->getRequired() ?: [];

            foreach ($properties as $name => $property) {
                /** @var PropertyInterface $property */
                $type = $this->getType($property);
                $name = $this->normalizeName($name);

                $result.= $indent . 'private ' . $type . ' ' . $name . ';' . "\n";

                $this->objects = array_merge($this->objects, $this->getSubSchemas($property));
            }

            foreach ($properties as $name => $property) {
                /** @var PropertyInterface $property */
                $type = $this->getType($property);
                $name = $this->normalizeName($name);

                $result.= $indent . 'public void set' . ucfirst($name) . '(' . $type . ' ' . $name . ') {' . "\n";
                $result.= $indent . '    this.' . $name . ' = ' . $name . ';' . "\n";
                $result.= $indent . '}' . "\n";

                $result.= $indent . 'public ' . $type . ' get' . ucfirst($name) . '() {' . "\n";
                $result.= $indent . '    return this.' . $name . ';' . "\n";
                $result.= $indent . '}' . "\n";
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
        $name = str_replace(['-', '_'], ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);

        return preg_replace('/[^A-Za-z0-9]/', '', lcfirst($name));
    }
}
