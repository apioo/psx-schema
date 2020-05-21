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
 * SchemaAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
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

    public function __construct(SchemaManagerInterface $schemaManager)
    {
        $this->schemaManager = $schemaManager;
        $this->definitions   = new Definitions();

        $type = $this->build($this->definitions);
        if (!$this->definitions->hasType($type)) {
            throw new InvalidSchemaException('The build method of ' . get_class($this) . ' has not returned a correct type name, have you added the type ' . $type . ' to the definitions?');
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

    protected function newType(string $name): Builder
    {
        $builder = new Builder();
        $this->definitions->addType($name, $builder->getType());

        return $builder;
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
        $type = clone $this->definitions->getType($existingName);
        $this->definitions->addType($newName, $type);

        return $type;
    }

    /**
     * Builds the schema and returns the type which you want to use as root.
     * Note the type which you return must be available at the definitions
     * 
     * @param DefinitionsInterface $definitions
     * @return string
     */
    abstract protected function build(DefinitionsInterface $definitions): string;
}
