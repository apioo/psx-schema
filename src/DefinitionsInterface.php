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

/**
 * DefinitionsInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
interface DefinitionsInterface
{
    public const SELF_NAMESPACE = 'self';

    /**
     * @param string $name
     * @param TypeInterface $type
     * @return mixed
     */
    public function addType(string $name, TypeInterface $type): void;

    /**
     * @param string $name
     * @return bool
     */
    public function hasType(string $name): bool;

    /**
     * Returns a specific type by the provided ref. If a ref contains a colon
     * it is used as namespace i.e. acme:my_type tries to resolve the type
     * "my_type" from the namespace "acme". If no colon is provided the self
     * namespace is used
     * 
     * @param string $name
     * @return TypeInterface
     */
    public function getType(string $name): TypeInterface;

    /**
     * Returns all available types for a specific namespace. The key contains
     * the name of the type
     * 
     * @param string $namespace
     * @return TypeInterface[]
     */
    public function getTypes(string $namespace): iterable;

    /**
     * Returns all registered namespaces on this definition
     * 
     * @return string[]
     */
    public function getNamespaces(): iterable;
}
