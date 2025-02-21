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

namespace PSX\Schema;

use PSX\Schema\Exception\TypeNotFoundException;
use PSX\Schema\Type\DefinitionTypeAbstract;

/**
 * DefinitionsInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
interface DefinitionsInterface
{
    public const SELF_NAMESPACE = 'self';

    /**
     * Adds a specific type to the definition. If the name contains a colon
     * it is used as namespace i.e. acme:my_type adds the type "my_type" to
     * the namespace "acme". If not namespace is used the type is added to
     * the "self" namespace
     */
    public function addType(string $name, DefinitionTypeAbstract $type): void;

    public function hasType(string $name): bool;

    /**
     * Returns a specific type by the provided name. If a name contains a colon
     * it is used as namespace i.e. acme:my_type tries to resolve the type
     * "my_type" from the namespace "acme". If no colon is provided the self
     * namespace is used
     *
     * @throws TypeNotFoundException
     */
    public function getType(string $name): DefinitionTypeAbstract;

    /**
     * Returns all available types for a specific namespace. The key contains
     * the name of the type
     *
     * @return array<DefinitionTypeAbstract>
     */
    public function getTypes(string $namespace = self::SELF_NAMESPACE): array;

    /**
     * Returns all types registered at this container
     *
     * @return array<DefinitionTypeAbstract>
     */
    public function getAllTypes(): array;

    /**
     * Removes a type from the definition
     */
    public function removeType(string $name): void;

    /**
     * Returns all registered namespaces on this definition
     *
     * @return array<string>
     */
    public function getNamespaces(): iterable;

    /**
     * Returns whether at least one type is registered for a specific namespace
     */
    public function isEmpty(string $namespace = self::SELF_NAMESPACE): bool;

    /**
     * Merges the provided type definitions
     */
    public function merge(DefinitionsInterface $definitions): void;

    /**
     * Adds a schema to the definition. It merges all definitions into the
     * current definition and also adds the root type in case it is not already
     * available
     */
    public function addSchema(string $name, SchemaInterface $schema): void;
}
