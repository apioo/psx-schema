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

use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;

/**
 * VisitorInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
interface VisitorInterface
{
    /**
     * Visits a struct value
     */
    public function visitStruct(\stdClass $data, StructType $type, string $path);

    /**
     * Visits a map value
     */
    public function visitMap(\stdClass $data, MapType $type, string $path);

    /**
     * Visits an array value
     */
    public function visitArray(array $data, ArrayType $type, string $path);

    /**
     * Visits a binary value
     */
    public function visitBinary($data, StringType $type, string $path);

    /**
     * Visits a boolean value
     */
    public function visitBoolean($data, BooleanType $type, string $path);

    /**
     * Visits a date time value
     */
    public function visitDateTime($data, StringType $type, string $path);

    /**
     * Visits a date value
     */
    public function visitDate($data, StringType $type, string $path);

    /**
     * Visits a duration value
     */
    public function visitDuration($data, StringType $type, string $path);

    /**
     * Visits a float value
     */
    public function visitNumber($data, NumberType $type, string $path);

    /**
     * Visits an integer value
     */
    public function visitInteger($data, IntegerType $type, string $path);

    /**
     * Visits a string value
     */
    public function visitString($data, StringType $type, string $path);

    /**
     * Visits a time value
     */
    public function visitTime($data, StringType $type, string $path);

    /**
     * Visits a uri value
     */
    public function visitUri($data, StringType $type, string $path);
}
