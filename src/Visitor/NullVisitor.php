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

namespace PSX\Schema\Visitor;

use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\ArrayTypeInterface;
use PSX\Schema\Type\BooleanPropertyType;
use PSX\Schema\Type\IntegerPropertyType;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\MapTypeInterface;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\VisitorInterface;

/**
 * NullVisitor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class NullVisitor implements VisitorInterface
{
    public function visitStruct(\stdClass $data, StructDefinitionType $type, string $path): object
    {
        return $data;
    }

    public function visitMap(\stdClass $data, MapTypeInterface $type, string $path): object
    {
        return $data;
    }

    public function visitArray(array $data, ArrayTypeInterface $type, string $path): array
    {
        return $data;
    }

    public function visitBoolean(bool $data, BooleanPropertyType $type, string $path): bool
    {
        return $data;
    }

    public function visitNumber(float|int $data, NumberPropertyType $type, string $path): float|int
    {
        return $data;
    }

    public function visitInteger(int $data, IntegerPropertyType $type, string $path): int
    {
        return $data;
    }

    public function visitString(string $data, StringPropertyType $type, string $path): string
    {
        return $data;
    }

    public function visitDate(string $data, StringPropertyType $type, string $path): string
    {
        return $data;
    }

    public function visitDateTime(string $data, StringPropertyType $type, string $path): string
    {
        return $data;
    }

    public function visitTime(string $data, StringPropertyType $type, string $path): string
    {
        return $data;
    }
}
