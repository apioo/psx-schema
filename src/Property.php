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

namespace PSX\Schema;

use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\GenericType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\UnionType;

/**
 * Factory class to access different property types
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
final class Property
{
    /**
     * @return \PSX\Schema\Type\ArrayType
     */
    public static function getArray()
    {
        return new ArrayType();
    }

    /**
     * @return \PSX\Schema\Type\StringType
     */
    public static function getBinary()
    {
        return self::getString()
            ->setFormat(PropertyType::FORMAT_BINARY);
    }

    /**
     * @return \PSX\Schema\Type\BooleanType
     */
    public static function getBoolean()
    {
        return new BooleanType();
    }

    /**
     * @return \PSX\Schema\Type\StringType
     */
    public static function getDateTime()
    {
        return self::getString()
            ->setFormat(PropertyType::FORMAT_DATETIME);
    }

    /**
     * @return \PSX\Schema\Type\StringType
     */
    public static function getDate()
    {
        return self::getString()
            ->setFormat(PropertyType::FORMAT_DATE);
    }

    /**
     * @return \PSX\Schema\Type\StringType
     */
    public static function getDuration()
    {
        return self::getString()
            ->setFormat(PropertyType::FORMAT_DURATION);
    }

    /**
     * @return \PSX\Schema\Type\IntegerType
     */
    public static function getInteger()
    {
        return new IntegerType();
    }

    /**
     * @return \PSX\Schema\Type\NumberType
     */
    public static function getNumber()
    {
        return new NumberType();
    }

    /**
     * @return \PSX\Schema\Type\StructType
     */
    public static function getStruct()
    {
        return new StructType();
    }

    /**
     * @return \PSX\Schema\Type\MapType
     */
    public static function getMap()
    {
        return new MapType();
    }

    /**
     * @return \PSX\Schema\Type\StringType
     */
    public static function getString()
    {
        return new StringType();
    }

    /**
     * @return \PSX\Schema\Type\StringType
     */
    public static function getTime()
    {
        return self::getString()
            ->setFormat(PropertyType::FORMAT_TIME);
    }

    /**
     * @return \PSX\Schema\Type\StringType
     */
    public static function getUri()
    {
        return self::getString()
            ->setFormat(PropertyType::FORMAT_URI);
    }

    /**
     * @return \PSX\Schema\Type\IntersectionType
     */
    public static function getIntersection()
    {
        return new IntersectionType();
    }

    /**
     * @return \PSX\Schema\Type\UnionType
     */
    public static function getUnion()
    {
        return new UnionType();
    }

    /**
     * @return \PSX\Schema\Type\ReferenceType
     */
    public static function getReference()
    {
        return new ReferenceType();
    }

    /**
     * @return \PSX\Schema\Type\GenericType
     */
    public static function getGeneric()
    {
        return new GenericType();
    }
}
