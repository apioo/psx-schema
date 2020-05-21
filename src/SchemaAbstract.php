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
    protected $schemaManager;

    /**
     * @var TypeInterface
     */
    protected $type;

    /**
     * @var DefinitionsInterface
     */
    protected $definitions;

    public function __construct(SchemaManagerInterface $schemaManager)
    {
        $this->schemaManager = $schemaManager;
        $this->definitions   = new Definitions();
        $this->type          = $this->build($this->definitions);
    }

    public function getType(): TypeInterface
    {
        return $this->type;
    }

    public function getDefinitions(): DefinitionsInterface
    {
        return $this->definitions;
    }

    protected function newBuilder(string $name): Builder
    {
        return new Builder($name);
    }

    /**
     * Loads a different schema and returns the root type. It creates a clone of
     * the schema so you can safely modify the schema. It also merges all
     * definitions to the current schema
     * 
     * @param string $name
     * @return TypeInterface
     */
    protected function load($name): TypeInterface
    {
        $schema = $this->schemaManager->getSchema($name);
        if ($schema instanceof SchemaInterface) {
            $this->definitions->merge($schema->getDefinitions());
            return clone $schema->getType();
        } else {
            throw new \InvalidArgumentException('Could not load schema ' . $name);
        }
    }

    /**
     * Builds the schema
     * 
     * @param DefinitionsInterface $definitions
     * @return TypeInterface
     */
    abstract protected function build(DefinitionsInterface $definitions): TypeInterface;
}
