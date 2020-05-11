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
 * Definitions
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Definitions implements DefinitionsInterface, \JsonSerializable
{
    private $container;

    public function __construct()
    {
        $this->container = [];
    }

    public function addType(string $fqn, TypeInterface $type): void
    {
        [$ns, $name] = $this->split($fqn);

        if (!isset($this->container[$ns])) {
            $this->container[$ns] = [];
        }

        if (isset($this->container[$ns][$name])) {
            throw new \RuntimeException('Type already registered');
        }

        $this->container[$ns][$name] = $type;
    }

    public function hasType(string $fqn): bool
    {
        [$ns, $name] = $this->split($fqn);

        return isset($this->container[$ns][$name]);
    }

    public function getType(string $fqn): TypeInterface
    {
        [$ns, $name] = $this->split($fqn);

        if (isset($this->container[$ns][$name])) {
            return $this->container[$ns][$name];
        } else {
            throw new \RuntimeException('Type not found');
        }
    }

    public function getTypes(string $namespace): iterable
    {
        if (isset($this->container[$namespace])) {
            return $this->container[$namespace];
        } else {
            return [];
        }
    }

    public function getAllTypes(): iterable
    {
        $result = [];
        foreach ($this->container as $namespace => $types) {
            foreach ($types as $name => $type) {
                if ($name === self::SELF_NAMESPACE) {
                    $result[$name] = $type;
                } else {
                    $result[$namespace . ':' . $name] = $type;
                }
            }
        }

        return $result;
    }

    public function getNamespaces(): iterable
    {
        return array_keys($this->container);
    }

    public function merge(DefinitionsInterface $definitions): void
    {
        $namespaces = $definitions->getNamespaces();
        foreach ($namespaces as $namespace) {
            $types = $definitions->getTypes($namespace);
            foreach ($types as $name => $type) {
                $this->addType($namespace . ':' . $name, $type);
            }
        }
    }

    public function jsonSerialize()
    {
        return $this->getAllTypes();
    }

    private function split(string $ref): array
    {
        if (strpos($ref, ':') !== false) {
            $parts = explode(':', $ref, 2);
            $ns    = $parts[0] ?? '';
            $name  = $parts[1] ?? '';
        } else {
            $ns    = self::SELF_NAMESPACE;
            $name  = $ref;
        }

        return [$ns, $name];
    }
}
