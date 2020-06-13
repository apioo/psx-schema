<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\VisitorInterface;

/**
 * NullVisitor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class NullVisitor implements VisitorInterface
{
    public function visitStruct(\stdClass $data, StructType $property, $path)
    {
        return $data;
    }

    public function visitMap(\stdClass $data, MapType $property, $path)
    {
        return $data;
    }

    public function visitArray(array $data, ArrayType $property, $path)
    {
        return $data;
    }

    public function visitBinary($data, StringType $property, $path)
    {
        return $data;
    }

    public function visitBoolean($data, BooleanType $property, $path)
    {
        return $data;
    }

    public function visitDateTime($data, StringType $property, $path)
    {
        return $data;
    }

    public function visitDate($data, StringType $property, $path)
    {
        return $data;
    }

    public function visitDuration($data, StringType $property, $path)
    {
        return $data;
    }

    public function visitNumber($data, NumberType $property, $path)
    {
        return $data;
    }

    public function visitInteger($data, IntegerType $property, $path)
    {
        return $data;
    }

    public function visitString($data, StringType $property, $path)
    {
        return $data;
    }

    public function visitTime($data, StringType $property, $path)
    {
        return $data;
    }

    public function visitUri($data, StringType $property, $path)
    {
        return $data;
    }
}
