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

use PSX\Schema\Type\AnyType;
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
 * Factory class to access different types
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TypeFactory
{
    public static function getAny(): AnyType
    {
        return new AnyType();
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public static function getArray(?TypeInterface $type = null): ArrayType
    {
        $array = new ArrayType();
        if ($type !== null) {
            $array->setItems($type);
        }
        return $array;
    }

    public static function getBoolean(): BooleanType
    {
        return new BooleanType();
    }

    public static function getGeneric(?string $type = null): GenericType
    {
        $generic = new GenericType();
        if ($type !== null) {
            $generic->setGeneric($type);
        }
        return $generic;
    }

    public static function getInteger(): IntegerType
    {
        return new IntegerType();
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public static function getIntersection(?array $types = null): IntersectionType
    {
        $intersection = new IntersectionType();
        if ($types !== null) {
            $intersection->setAllOf($types);
        }
        return $intersection;
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public static function getMap(?TypeInterface $type = null): MapType
    {
        $map = new MapType();
        if ($type !== null) {
            $map->setAdditionalProperties($type);
        }
        return $map;
    }

    public static function getNumber(): NumberType
    {
        return new NumberType();
    }

    public static function getReference(?string $ref = null): ReferenceType
    {
        $reference = new ReferenceType();
        if ($ref !== null) {
            $reference->setRef($ref);
        }
        return $reference;
    }

    public static function getString(): StringType
    {
        return new StringType();
    }

    public static function getStruct(): StructType
    {
        return new StructType();
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public static function getUnion(?array $types = null): UnionType
    {
        $union = new UnionType();
        if ($types !== null) {
            $union->setOneOf($types);
        }
        return $union;
    }

    public static function getBinary(): StringType
    {
        return self::getString()
            ->setFormat(Format::BINARY);
    }

    public static function getDateTime(): StringType
    {
        return self::getString()
            ->setFormat(Format::DATETIME);
    }

    public static function getDate(): StringType
    {
        return self::getString()
            ->setFormat(Format::DATE);
    }

    public static function getPeriod(): StringType
    {
        return self::getString()
            ->setFormat(Format::PERIOD);
    }

    public static function getDuration(): StringType
    {
        return self::getString()
            ->setFormat(Format::DURATION);
    }

    public static function getTime(): StringType
    {
        return self::getString()
            ->setFormat(Format::TIME);
    }

    public static function getUri(): StringType
    {
        return self::getString()
            ->setFormat(Format::URI);
    }
}
