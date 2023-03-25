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

namespace PSX\Schema\Parser\Popo;

use PSX\Schema\Attribute;
use ReflectionClass;

/**
 * ObjectReader
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ObjectReader
{
    /**
     * Returns all available properties of an object
     *
     * @return \ReflectionProperty[]
     */
    public static function getProperties(ReflectionClass $class): array
    {
        $props  = $class->getProperties();
        $result = [];

        foreach ($props as $property) {
            // skip statics
            if ($property->isStatic()) {
                continue;
            }

            $attributes = [];
            foreach ($property->getAttributes() as $attribute) {
                $attributes[] = $attribute->newInstance();
            }

            // check whether we have an exclude annotation
            if (self::hasExcludeAttribute($attributes)) {
                continue;
            }

            // get the property name
            $key  = self::getAttributeKey($attributes);
            $name = null;

            if ($key !== null) {
                $name = $key;
            }

            if (empty($name)) {
                $name = $property->getName();
            }

            $result[$name] = $property;
        }

        return $result;
    }

    private static function hasExcludeAttribute(array $attributes): bool
    {
        foreach ($attributes as $attribute) {
            if ($attribute instanceof Attribute\Exclude) {
                return true;
            }
        }

        return false;
    }

    private static function getAttributeKey(array $attributes): ?string
    {
        foreach ($attributes as $attribute) {
            if ($attribute instanceof Attribute\Key) {
                return $attribute->key;
            }
        }

        return null;
    }
}
