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

use PSX\Schema\Type\AnyPropertyType;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\BooleanPropertyType;
use PSX\Schema\Type\GenericPropertyType;
use PSX\Schema\Type\IntegerPropertyType;
use PSX\Schema\Type\MapPropertyType;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StringPropertyType;

/**
 * Factory class to access different property types
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class PropertyTypeFactory
{
    public static function getAny(): AnyPropertyType
    {
        return new AnyPropertyType();
    }

    public static function getArray(?PropertyTypeAbstract $schema = null): ArrayPropertyType
    {
        $array = new ArrayPropertyType();
        if ($schema !== null) {
            $array->setSchema($schema);
        }
        return $array;
    }

    public static function getBoolean(): BooleanPropertyType
    {
        return new BooleanPropertyType();
    }

    public static function getGeneric(?string $name = null): GenericPropertyType
    {
        $generic = new GenericPropertyType();
        if ($name !== null) {
            $generic->setName($name);
        }
        return $generic;
    }

    public static function getInteger(): IntegerPropertyType
    {
        return new IntegerPropertyType();
    }

    public static function getMap(?PropertyTypeAbstract $schema = null): MapPropertyType
    {
        $map = new MapPropertyType();
        if ($schema !== null) {
            $map->setSchema($schema);
        }
        return $map;
    }

    public static function getNumber(): NumberPropertyType
    {
        return new NumberPropertyType();
    }

    public static function getReference(?string $target = null): ReferencePropertyType
    {
        $reference = new ReferencePropertyType();
        if ($target !== null) {
            $reference->setTarget($target);
        }
        return $reference;
    }

    public static function getString(): StringPropertyType
    {
        return new StringPropertyType();
    }

    public static function getBinary(): StringPropertyType
    {
        return self::getString()
            ->setFormat(Format::BINARY);
    }

    public static function getDateTime(): StringPropertyType
    {
        return self::getString()
            ->setFormat(Format::DATETIME);
    }

    public static function getDate(): StringPropertyType
    {
        return self::getString()
            ->setFormat(Format::DATE);
    }

    public static function getPeriod(): StringPropertyType
    {
        return self::getString()
            ->setFormat(Format::PERIOD);
    }

    public static function getDuration(): StringPropertyType
    {
        return self::getString()
            ->setFormat(Format::DURATION);
    }

    public static function getTime(): StringPropertyType
    {
        return self::getString()
            ->setFormat(Format::TIME);
    }

    public static function getUri(): StringPropertyType
    {
        return self::getString()
            ->setFormat(Format::URI);
    }
}
