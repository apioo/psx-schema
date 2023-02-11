<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use PSX\Schema\Type\AnyType;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\UnionType;
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

    public function generateByType(TypeInterface $type): string
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
        if ($type instanceof StructType) {
            yield 'struct';
            foreach ($type->getProperties() as $name => $value) {
                yield $name;
                yield from $this->getValuesByType($value);
            }
        } elseif ($type instanceof MapType) {
            yield 'map';
            $additionalProperties = $type->getAdditionalProperties();
            if ($additionalProperties instanceof TypeInterface) {
                yield from $this->getValuesByType($additionalProperties);
            } elseif (is_bool($additionalProperties)) {
                yield $additionalProperties ? '1' : '0';
            }
        } elseif ($type instanceof ArrayType) {
            yield 'array';
            $items = $type->getItems();
            if ($items instanceof TypeInterface) {
                yield from $this->getValuesByType($items);
            }
        } elseif ($type instanceof UnionType) {
            yield 'union';
            $items = $type->getOneOf() ?? [];
            foreach ($items as $item) {
                yield from $this->getValuesByType($item);
            }
        } elseif ($type instanceof IntersectionType) {
            yield 'intersection';
            $items = $type->getAllOf() ?? [];
            foreach ($items as $item) {
                yield from $this->getValuesByType($item);
            }
        } elseif ($type instanceof ReferenceType) {
            yield 'reference';
            yield $type->getRef();
        } elseif ($type instanceof StringType) {
            yield 'string';
        } elseif ($type instanceof IntegerType) {
            yield 'integer';
        } elseif ($type instanceof NumberType) {
            yield 'number';
        } elseif ($type instanceof BooleanType) {
            yield 'boolean';
        } elseif ($type instanceof AnyType) {
            yield 'any';
        }
    }
}
