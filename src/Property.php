<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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
     * @return \PSX\Schema\PropertyInterface
     */
    public static function get()
    {
        return new PropertyType();
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getArray()
    {
        return self::get()
            ->setType(PropertyType::TYPE_ARRAY);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getBinary()
    {
        return self::get()
            ->setType(PropertyType::TYPE_STRING)
            ->setFormat(PropertyType::FORMAT_BINARY);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getBoolean()
    {
        return self::get()
            ->setType(PropertyType::TYPE_BOOLEAN);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getDateTime()
    {
        return self::get()
            ->setType(PropertyType::TYPE_STRING)
            ->setFormat(PropertyType::FORMAT_DATETIME);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getDate()
    {
        return self::get()
            ->setType(PropertyType::TYPE_STRING)
            ->setFormat(PropertyType::FORMAT_DATE);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getDuration()
    {
        return self::get()
            ->setType(PropertyType::TYPE_STRING)
            ->setFormat(PropertyType::FORMAT_DURATION);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getInteger()
    {
        return self::get()
            ->setType(PropertyType::TYPE_INTEGER);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getNull()
    {
        return self::get()
            ->setType(PropertyType::TYPE_NULL);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getNumber()
    {
        return self::get()
            ->setType(PropertyType::TYPE_NUMBER);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getObject()
    {
        return self::get()
            ->setType(PropertyType::TYPE_OBJECT);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getString()
    {
        return self::get()
            ->setType(PropertyType::TYPE_STRING);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getTime()
    {
        return self::get()
            ->setType(PropertyType::TYPE_STRING)
            ->setFormat(PropertyType::FORMAT_TIME);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public static function getUri()
    {
        return self::get()
            ->setType(PropertyType::TYPE_STRING)
            ->setFormat(PropertyType::FORMAT_URI);
    }
}
