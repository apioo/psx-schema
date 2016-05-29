<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2016 Christoph Kappestein <k42b3.x@gmail.com>
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
 * Factory class to access different property types. These methods should be
 * used instead of creating a new object
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
final class Property
{
    /**
     * @return \PSX\Schema\Property\AnyType
     * @deprecated
     */
    public static function getAny($name = null)
    {
        return new Property\AnyType($name);
    }

    /**
     * @return \PSX\Schema\Property\ArrayType
     */
    public static function getArray($name = null)
    {
        return new Property\ArrayType($name);
    }

    /**
     * @return \PSX\Schema\Property\BinaryType
     */
    public static function getBinary($name = null)
    {
        return new Property\BinaryType($name);
    }

    /**
     * @return \PSX\Schema\Property\BooleanType
     */
    public static function getBoolean($name = null)
    {
        return new Property\BooleanType($name);
    }

    /**
     * @return \PSX\Schema\Property\ChoiceType
     */
    public static function getChoice($name = null)
    {
        return new Property\ChoiceType($name);
    }

    /**
     * @return \PSX\Schema\Property\ComplexType
     */
    public static function getComplex($name = null)
    {
        return new Property\ComplexType($name);
    }

    /**
     * @return \PSX\Schema\Property\DateTimeType
     */
    public static function getDateTime($name = null)
    {
        return new Property\DateTimeType($name);
    }

    /**
     * @return \PSX\Schema\Property\DateType
     */
    public static function getDate($name = null)
    {
        return new Property\DateType($name);
    }

    /**
     * @return \PSX\Schema\Property\DurationType
     */
    public static function getDuration($name = null)
    {
        return new Property\DurationType($name);
    }

    /**
     * @return \PSX\Schema\Property\FloatType
     */
    public static function getFloat($name = null)
    {
        return new Property\FloatType($name);
    }

    /**
     * @return \PSX\Schema\Property\IntegerType
     */
    public static function getInteger($name = null)
    {
        return new Property\IntegerType($name);
    }

    /**
     * @return \PSX\Schema\Property\StringType
     */
    public static function getString($name = null)
    {
        return new Property\StringType($name);
    }

    /**
     * @return \PSX\Schema\Property\TimeType
     */
    public static function getTime($name = null)
    {
        return new Property\TimeType($name);
    }

    /**
     * @return \PSX\Schema\Property\UriType
     */
    public static function getUri($name = null)
    {
        return new Property\UriType($name);
    }
}
