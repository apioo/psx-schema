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

namespace PSX\Schema;

use PSX\Schema\Exception\InvalidSchemaException;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ReferenceType;

/**
 * SchemaAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class SchemaAbstract implements SchemaInterface
{
    /**
     * @var SchemaManagerInterface
     */
    private $schemaManager;

    /**
     * @var TypeInterface
     */
    private $type;

    /**
     * @var DefinitionsInterface
     */
    private $definitions;

    /**
     * @var string
     */
    private $rootName;

    public function __construct(SchemaManagerInterface $schemaManager)
    {
        $this->schemaManager = $schemaManager;
        $this->definitions   = new Definitions();

        $this->build();
        $type = $this->rootName;

        if (!$this->definitions->hasType($type)) {
            throw new InvalidSchemaException('Root schema does not exist at ' . get_class($this) . ', have you added a type via the newType method?');
        }

        $this->type = TypeFactory::getReference($type);
    }

    public function getType(): TypeInterface
    {
        return $this->type;
    }

    public function getDefinitions(): DefinitionsInterface
    {
        return $this->definitions;
    }

    /**
     * @param string $name
     * @param TypeInterface $type
     */
    protected function add(string $name, TypeInterface $type): void
    {
        $this->definitions->addType($name, $type);
    }

    /**
     * @param string $name
     * @return bool
     */
    protected function has(string $name): bool
    {
        return $this->definitions->hasType($name);
    }

    /**
     * Main method to add a new type to the definitions of this schema
     * 
     * @param string $name
     * @return Builder
     */
    protected function newStruct(string $name): Builder
    {
        $builder = new Builder();
        $this->definitions->addType($name, $builder->getType());

        $this->rootName = $name;

        return $builder;
    }

    /**
     * @param string $name
     * @return MapType
     */
    protected function newMap(string $name): MapType
    {
        $map = TypeFactory::getMap();
        $this->definitions->addType($name, $map);

        return $map;
    }

    /**
     * Loads a remote schema and returns a reference to the root type
     * 
     * @param string $name
     * @return ReferenceType
     */
    protected function get(string $name): ReferenceType
    {
        $schema = $this->schemaManager->getSchema($name);
        if (!$schema instanceof SchemaInterface) {
            throw new \InvalidArgumentException('Could not load schema ' . $name);
        }

        $this->definitions->merge($schema->getDefinitions());

        $type = $schema->getType();
        if (!$type instanceof ReferenceType) {
            throw new \InvalidArgumentException('Loaded schema ' . $name . ' contains not a reference');
        }

        return clone $type;
    }

    /**
     * Loads all definitions from another schema into this schema, so you can
     * use all definitions from the schema
     * 
     * @param string $name
     */
    protected function load(string $name): void
    {
        $schema = $this->schemaManager->getSchema($name);
        if ($schema instanceof SchemaInterface) {
            $this->definitions->merge($schema->getDefinitions());
        } else {
            throw new \InvalidArgumentException('Could not load schema ' . $name);
        }
    }

    /**
     * Clones an existing type under a new name so you that you can modify
     * specific properties
     * 
     * @param string $existingName
     * @param string $newName
     * @return TypeInterface
     */
    protected function modify(string $existingName, string $newName): TypeInterface
    {
        $type = clone $this->definitions->getType($this->get($existingName)->getRef());
        $this->definitions->addType($newName, $type);

        $this->rootName = $newName;

        return $type;
    }

    /**
     * Defines the root schema of this schema. By defualt the is the last schema
     * you have added via the newType method
     * 
     * @param string $name
     */
    protected function setRoot(string $name): void
    {
        $this->rootName = $name;
    }

    /**
     * Builds the schema, through the add method you can add a new type to the
     * schema and through the get method you can load an existing type
     */
    abstract protected function build(): void;
}
