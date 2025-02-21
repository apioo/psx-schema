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
 * Definitions
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Definitions implements DefinitionsInterface, \JsonSerializable
{
    private array $container;

    public function __construct()
    {
        $this->container = [];
    }

    public function addType(string $name, DefinitionTypeAbstract $type): void
    {
        [$ns, $alias] = TypeUtil::split($name);

        if (!isset($this->container[$ns])) {
            $this->container[$ns] = [];
        }

        if (isset($this->container[$ns][$alias])) {
            throw new \RuntimeException('Type "' . $name . '" already registered');
        }

        $this->container[$ns][$alias] = $type;
    }

    public function hasType(string $name): bool
    {
        [$ns, $alias] = TypeUtil::split($name);

        return isset($this->container[$ns][$alias]);
    }

    public function getType(string $name): DefinitionTypeAbstract
    {
        [$ns, $alias] = TypeUtil::split($name);

        if (!isset($this->container[$ns])) {
            throw new TypeNotFoundException('Type namespace "' . $ns . '" not found, the following namespaces are available: ' . implode(', ', array_keys($this->container)), $ns, $alias);
        }

        if (!isset($this->container[$ns][$alias])) {
            throw new TypeNotFoundException('Type "' . $alias . '" not found, the following types are available: ' . implode(', ', array_keys($this->container[$ns])), $ns, $alias);
        }

        return $this->container[$ns][$alias];
    }

    public function removeType(string $name): void
    {
        [$ns, $alias] = TypeUtil::split($name);

        if (isset($this->container[$ns][$alias])) {
            unset($this->container[$ns][$alias]);
        }
    }

    public function getTypes(string $namespace = self::SELF_NAMESPACE): array
    {
        return $this->container[$namespace] ?? [];
    }

    public function getAllTypes(): array
    {
        $result = [];
        foreach ($this->container as $namespace => $types) {
            foreach ($types as $name => $type) {
                $result[$namespace . ':' . $name] = $type;
            }
        }

        return $result;
    }

    public function getNamespaces(): iterable
    {
        return array_keys($this->container);
    }

    public function isEmpty(string $namespace = self::SELF_NAMESPACE): bool
    {
        return count($this->container[$namespace] ?? []) === 0;
    }

    public function merge(DefinitionsInterface $definitions): void
    {
        $namespaces = $definitions->getNamespaces();
        foreach ($namespaces as $namespace) {
            $types = $definitions->getTypes($namespace);
            foreach ($types as $name => $type) {
                $fqn = $namespace . ':' . $name;
                if ($this->hasType($fqn)) {
                    continue;
                }

                $this->addType($fqn, $type);
            }
        }
    }

    public function addSchema(string $name, SchemaInterface $schema): void
    {
        $this->merge($schema->getDefinitions());
    }

    public function jsonSerialize(): iterable
    {
        return $this->getAllTypes();
    }
}
