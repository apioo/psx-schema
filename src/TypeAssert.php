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
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\UnionType;

/**
 * TypeAssert
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class TypeAssert
{
    /**
     * @param TypeInterface $type
     * @see https://typeschema.org/specification#Properties
     */
    public static function assertProperty(TypeInterface $type)
    {
        if (!($type instanceof BooleanType
            || $type instanceof NumberType
            || $type instanceof StringType
            || $type instanceof ArrayType
            || $type instanceof IntersectionType
            || $type instanceof UnionType
            || $type instanceof ReferenceType
            || $type instanceof GenericType)) {
            throw new \InvalidArgumentException('Property must be of type boolean, number, string, array, intersection, union, reference or generic type, got ' . get_class($type));
        }
    }

    /**
     * @param TypeInterface $type
     * @see https://typeschema.org/specification#ArrayProperties
     */
    public static function assertItem(TypeInterface $type)
    {
        if (!($type instanceof BooleanType
            || $type instanceof NumberType
            || $type instanceof StringType
            || $type instanceof IntersectionType
            || $type instanceof UnionType
            || $type instanceof ReferenceType
            || $type instanceof GenericType)) {
            throw new \InvalidArgumentException('Item must be of type boolean, number, string, intersection, union, reference or generic type, got ' . get_class($type));
        }
    }

    /**
     * @param array $items
     * @see https://typeschema.org/specification#AllOfProperties
     */
    public static function assertIntersection(array $items)
    {
        foreach ($items as $index => $item) {
            if (!($item instanceof ReferenceType)) {
                throw new \InvalidArgumentException('All of item must be of type reference, at index ' . $index . ' we got ' . get_class($item));
            }
        }
    }

    /**
     * @param array $items
     * @see https://typeschema.org/specification#OneOfProperties
     */
    public static function assertUnion(array $items)
    {
        foreach ($items as $index => $item) {
            if (!($item instanceof NumberType
                || $item instanceof StringType
                || $item instanceof BooleanType
                || $item instanceof ReferenceType)) {
                throw new \InvalidArgumentException('One of item must be of type string, number, boolean or reference, at index ' . $index . ' we got ' . get_class($item));
            }
        }
    }
}
