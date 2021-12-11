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

namespace PSX\Schema\Parser\Popo;

use Doctrine\Common\Annotations\Reader;
use PSX\Schema\Annotation;
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
     * @param Reader $reader
     * @param \ReflectionClass $class
     * @return \ReflectionProperty[]
     */
    public static function getProperties(Reader $reader, ReflectionClass $class)
    {
        $props  = $class->getProperties();
        $result = [];

        foreach ($props as $property) {
            // skip statics
            if ($property->isStatic()) {
                continue;
            }

            if (PHP_VERSION_ID > 80000) {
                $annotations = [];
                foreach ($property->getAttributes() as $attribute) {
                    $annotations[] = $attribute->newInstance();
                }
            } else {
                $annotations = $reader->getPropertyAnnotations($property);
            }

            // check whether we have an exclude annotation
            if (self::hasExcludeAnnotation($annotations)) {
                continue;
            }

            // get the property name
            $key  = self::getAnnotationKey($annotations);
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

    private static function hasExcludeAnnotation(array $annotations): bool
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Exclude) {
                return true;
            } elseif ($annotation instanceof Attribute\Exclude) {
                return true;
            }
        }

        return false;
    }

    private static function getAnnotationKey(array $annotations): ?string
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Key) {
                return $annotation->getKey();
            } elseif ($annotation instanceof Attribute\Key) {
                return $annotation->key;
            }
        }

        return null;
    }
}
