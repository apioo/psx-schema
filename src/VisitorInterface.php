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
     *
     * @param \stdClass $data
     * @param \PSX\Schema\Type\StructType $type
     * @param string $path
     * @return mixed
     */
    public function visitStruct(\stdClass $data, StructType $type, $path);

    /**
     * Visits a map value
     *
     * @param \stdClass $data
     * @param \PSX\Schema\Type\MapType $type
     * @param string $path
     * @return mixed
     */
    public function visitMap(\stdClass $data, MapType $type, $path);

    /**
     * Visits an array value
     *
     * @param array $data
     * @param \PSX\Schema\Type\ArrayType $type
     * @param string $path
     * @return mixed
     */
    public function visitArray(array $data, ArrayType $type, $path);

    /**
     * Visits a binary value
     *
     * @param string $data
     * @param \PSX\Schema\Type\StringType $type
     * @param string $path
     * @return mixed
     */
    public function visitBinary($data, StringType $type, $path);

    /**
     * Visits a boolean value
     *
     * @param string $data
     * @param \PSX\Schema\Type\BooleanType $type
     * @param string $path
     * @return mixed
     */
    public function visitBoolean($data, BooleanType $type, $path);

    /**
     * Visits a date time value
     *
     * @param string $data
     * @param \PSX\Schema\Type\StringType $type
     * @param string $path
     * @return mixed
     */
    public function visitDateTime($data, StringType $type, $path);

    /**
     * Visits a date value
     *
     * @param string $data
     * @param \PSX\Schema\Type\StringType $type
     * @param string $path
     * @return mixed
     */
    public function visitDate($data, StringType $type, $path);

    /**
     * Visits a duration value
     *
     * @param string $data
     * @param \PSX\Schema\Type\StringType $type
     * @param string $path
     * @return mixed
     */
    public function visitDuration($data, StringType $type, $path);

    /**
     * Visits a float value
     *
     * @param string $data
     * @param \PSX\Schema\Type\NumberType $type
     * @param string $path
     * @return mixed
     */
    public function visitNumber($data, NumberType $type, $path);

    /**
     * Visits an integer value
     *
     * @param string $data
     * @param \PSX\Schema\Type\IntegerType $type
     * @param string $path
     * @return mixed
     */
    public function visitInteger($data, IntegerType $type, $path);

    /**
     * Visits a string value
     *
     * @param string $data
     * @param \PSX\Schema\Type\StringType $type
     * @param string $path
     * @return mixed
     */
    public function visitString($data, StringType $type, $path);

    /**
     * Visits a time value
     *
     * @param string $data
     * @param \PSX\Schema\Type\StringType $type
     * @param string $path
     * @return mixed
     */
    public function visitTime($data, StringType $type, $path);

    /**
     * Visits a uri value
     *
     * @param string $data
     * @param \PSX\Schema\Type\StringType $type
     * @param string $path
     * @return mixed
     */
    public function visitUri($data, StringType $type, $path);
}
