<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Inspector;

use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Type\AnyPropertyType;
use PSX\Schema\Type\ArrayTypeInterface;
use PSX\Schema\Type\BooleanPropertyType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\IntegerPropertyType;
use PSX\Schema\Type\MapTypeInterface;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\TypeInterface;

/**
 * Generates a unique string of this schema definition. The hash only considers relevant properties i.e. a description
 * does not change the hash of a schema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Hash
{
    public function generate(DefinitionsInterface $definition): string
    {
        $values = iterator_to_array($this->getValues($definition), false);

        return hash('sha256', implode('', $values));
    }

    public function generateByType(DefinitionTypeAbstract $type): string
    {
        $values = iterator_to_array($this->getValuesByType($type), false);

        return hash('sha256', implode('', $values));
    }

    private function getValues(DefinitionsInterface $definition): \Generator
    {
        $types = $definition->getTypes(DefinitionsInterface::SELF_NAMESPACE);
        foreach ($types as $name => $type) {
            yield $name;
            yield from $this->getValuesByType($type);
        }
    }

    private function getValuesByType(TypeInterface $type): \Generator
    {
        if ($type instanceof StructDefinitionType) {
            yield 'struct';
            foreach ($type->getProperties() as $name => $value) {
                yield $name;
                yield from $this->getValuesByType($value);
            }
        } elseif ($type instanceof MapTypeInterface) {
            yield 'map';
            $schema = $type->getSchema();
            if ($schema instanceof PropertyTypeAbstract) {
                yield from $this->getValuesByType($schema);
            }
        } elseif ($type instanceof ArrayTypeInterface) {
            yield 'array';
            $schema = $type->getSchema();
            if ($schema instanceof PropertyTypeAbstract) {
                yield from $this->getValuesByType($schema);
            }
        } elseif ($type instanceof ReferencePropertyType) {
            yield 'reference';
            yield $type->getTarget();
        } elseif ($type instanceof StringPropertyType) {
            yield 'string';
        } elseif ($type instanceof IntegerPropertyType) {
            yield 'integer';
        } elseif ($type instanceof NumberPropertyType) {
            yield 'number';
        } elseif ($type instanceof BooleanPropertyType) {
            yield 'boolean';
        } elseif ($type instanceof AnyPropertyType) {
            yield 'any';
        }
    }
}
