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

namespace PSX\Schema\Parser\Popo\Resolver;

use PSX\Schema\Parser\Popo\ResolverInterface;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\PropertyTypeAbstract;

/**
 * Composite
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Composite implements ResolverInterface
{
    /**
     * @var ResolverInterface[]
     */
    private array $resolver;

    public function __construct(ResolverInterface ...$resolver)
    {
        $this->resolver = $resolver;
    }

    public function resolveClass(\ReflectionClass $reflection): ?DefinitionTypeAbstract
    {
        foreach ($this->resolver as $resolver) {
            $property = $resolver->resolveClass($reflection);
            if ($property instanceof DefinitionTypeAbstract) {
                return $property;
            }
        }

        return null;
    }

    public function resolveProperty(\ReflectionProperty $reflection): ?PropertyTypeAbstract
    {
        foreach ($this->resolver as $resolver) {
            $property = $resolver->resolveProperty($reflection);
            if ($property instanceof PropertyTypeAbstract) {
                return $property;
            }
        }

        return null;
    }
}
