<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeInterface;

/**
 * Swift
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Swift extends CodeGeneratorAbstract
{
    /**
     * @inheritDoc
     */
    protected function newTypeGenerator(): GeneratorInterface
    {
        return new Type\Swift();
    }

    /**
     * @inheritDoc
     */
    protected function writeStruct(string $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = '';

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= '// ' . $comment . "\n";
        }

        $code.= 'class ' . $name . ': ';

        if (!empty($extends)) {
            $code.= $extends . ' ';
        } else {
            $code.= 'Codable ';
        }

        $code.= '{' . "\n";

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . 'var ' . $name . ': ' . $property->getType() . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(string $name, string $type, MapType $origin): string
    {
        return 'typealias ' . $name . ' = ' . $type . ';' . "\n";
    }

    protected function writeArray(string $name, string $type, ArrayType $origin): string
    {
        return 'typealias ' . $name . ' = ' . $type . ';' . "\n";
    }

    protected function writeUnion(string $name, string $type, UnionType $origin): string
    {
        return 'typealias ' . $name . ' = ' . $type . ';' . "\n";
    }

    protected function writeIntersection(string $name, string $type, IntersectionType $origin): string
    {
        return 'typealias ' . $name . ' = ' . $type . ';' . "\n";
    }

    protected function writeReference(string $name, string $type, ReferenceType $origin): string
    {
        return 'typealias ' . $name . ' = ' . $type . ';' . "\n";
    }

    protected function normalizeName(string $name)
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $name)));
    }
}
