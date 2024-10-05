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

namespace PSX\Schema;

use PSX\Schema\Exception\InvalidSchemaException;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\PropertyTypeAbstract;

/**
 * SchemaAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class SchemaAbstract implements SchemaInterface
{
    private SchemaManagerInterface $schemaManager;
    private DefinitionsInterface $definitions;
    private ?string $rootName;

    public function __construct(SchemaManagerInterface $schemaManager)
    {
        $this->schemaManager = $schemaManager;
        $this->definitions = new Definitions();

        $this->build();
        $type = $this->rootName;

        if (!$this->definitions->hasType($type)) {
            throw new InvalidSchemaException('Root schema does not exist at ' . get_class($this) . ', have you added a type via the newType method?');
        }
    }

    public function getRoot(): ?string
    {
        return $this->rootName;
    }

    public function getDefinitions(): DefinitionsInterface
    {
        return $this->definitions;
    }

    protected function add(string $name, DefinitionTypeAbstract $type): void
    {
        $this->definitions->addType($name, $type);
    }

    protected function has(string $name): bool
    {
        return $this->definitions->hasType($name);
    }

    /**
     * Main method to add a new type to the definitions of this schema
     */
    protected function newStruct(string $name): Builder
    {
        $builder = new Builder();
        $this->definitions->addType($name, $builder->getType());

        $this->rootName = $name;

        return $builder;
    }

    protected function newMap(string $name, PropertyTypeAbstract $schema): MapDefinitionType
    {
        $map = DefinitionTypeFactory::getMap($schema);
        $this->definitions->addType($name, $map);

        return $map;
    }

    protected function newArray(string $name, PropertyTypeAbstract $schema): ArrayDefinitionType
    {
        $array = DefinitionTypeFactory::getArray($schema);
        $this->definitions->addType($name, $array);

        return $array;
    }

    /**
     * Loads a remote schema and returns a reference to the root type
     *
     * @throws Exception\InvalidSchemaException
     * @throws Exception\TypeNotFoundException
     */
    protected function get(string $name): DefinitionTypeAbstract
    {
        $schema = $this->schemaManager->getSchema($name);

        $this->definitions->merge($schema->getDefinitions());

        $root = $schema->getRoot();
        if (empty($root)) {
            throw new Exception\InvalidSchemaException('Loaded schema ' . $name . ' contains not a reference');
        }

        return clone $this->definitions->getType($root);
    }

    /**
     * Loads all definitions from another schema into this schema, so you can
     * use all definitions from the schema
     *
     * @throws Exception\InvalidSchemaException
     */
    protected function load(string $name): void
    {
        $schema = $this->schemaManager->getSchema($name);
        $this->definitions->merge($schema->getDefinitions());
    }

    /**
     * Clones an existing type under a new name so you that you can modify
     * specific properties
     *
     * @throws Exception\InvalidSchemaException
     * @throws Exception\TypeNotFoundException
     */
    protected function modify(string $existingName, string $newName): TypeInterface
    {
        $existing = $this->get($existingName);

        $type = clone $existing;
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
