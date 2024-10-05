<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

use Psr\Cache\CacheItemPoolInterface;
use PSX\Schema\Attribute;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\PropertyTypeAbstract;
use ReflectionClass;

/**
 * ReflectionReader
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ReflectionReader
{
    private ResolverInterface $resolver;

    public function __construct()
    {
        $this->resolver = new Resolver\Composite(
            new Resolver\Native(),
            new Resolver\Documentor()
        );
    }

    public function buildDefinition(\ReflectionClass $reflection): ?DefinitionTypeAbstract
    {
        return $this->resolver->resolveClass($reflection);
    }

    public function buildProperty(\ReflectionProperty $reflection): ?PropertyTypeAbstract
    {
        return $this->resolver->resolveProperty($reflection);
    }

    /**
     * Returns an array where the key is name of the property and the value is the reflection property
     *
     * @return array<string, \ReflectionProperty>
     */
    public function getProperties(\ReflectionClass $reflection): array
    {
        $result = [];
        foreach ($reflection->getProperties() as $property) {
            // skip statics
            if ($property->isStatic()) {
                continue;
            }

            $attributes = [];
            foreach ($property->getAttributes() as $attribute) {
                $attributes[] = $attribute->newInstance();
            }

            // check whether we have an exclude annotation
            if ($this->hasExcludeAttribute($attributes)) {
                continue;
            }

            // get the property name
            $key = $this->getAttributeKey($attributes);
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

    public function findGetter(\ReflectionProperty $reflection): ?\ReflectionMethod
    {
        $getters = [
            'get' . ucfirst($reflection->getName()),
            'is' . ucfirst($reflection->getName())
        ];

        $class = $reflection->getDeclaringClass();
        foreach ($getters as $getter) {
            if ($class->hasMethod($getter)) {
                return $class->getMethod($getter);
            }
        }

        return null;
    }

    private function hasExcludeAttribute(array $attributes): bool
    {
        foreach ($attributes as $attribute) {
            if ($attribute instanceof Attribute\Exclude) {
                return true;
            }
        }

        return false;
    }

    private function getAttributeKey(array $attributes): ?string
    {
        foreach ($attributes as $attribute) {
            if ($attribute instanceof Attribute\Key) {
                return $attribute->key;
            }
        }

        return null;
    }
}
