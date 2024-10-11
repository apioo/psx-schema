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

use PSX\Json\Parser;
use PSX\Schema\Exception\InvalidSchemaException;
use PSX\Schema\Exception\MappingException;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\Exception\TraverserException;
use PSX\Schema\Parser\Popo\Dumper;
use PSX\Schema\Visitor\TypeVisitor;

/**
 * ObjectMapper
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ObjectMapper
{
    private SchemaManager $schemaManager;
    private SchemaTraverser $schemaTraverser;
    private Dumper $dumper;

    public function __construct(SchemaManager $schemaManager, bool $ignoreUnknownProperties = true)
    {
        $this->schemaManager = $schemaManager;
        $this->schemaTraverser = new SchemaTraverser(ignoreUnknown: $ignoreUnknownProperties);
        $this->dumper = new Dumper();
    }

    /**
     * @throws MappingException
     */
    public function readJson(string $json, SchemaSource $source): mixed
    {
        try {
            return $this->read(Parser::decode($json), $source);
        } catch (\JsonException $e) {
            throw new MappingException($e->getMessage(), previous: $e);
        }
    }

    /**
     * @throws MappingException
     */
    public function read(mixed $data, SchemaSource $source): mixed
    {
        try {
            $schema = $this->schemaManager->getSchema($source);

            return $this->schemaTraverser->traverse($data, $schema, new TypeVisitor());
        } catch (InvalidSchemaException|TraverserException $e) {
            throw new MappingException($e->getMessage(), previous: $e);
        }
    }

    /**
     * @throws MappingException
     */
    public function writeJson(mixed $model): string
    {
        try {
            return Parser::encode($this->write($model));
        } catch (\JsonException $e) {
            throw new MappingException($e->getMessage(), previous: $e);
        }
    }

    /**
     * @throws MappingException
     */
    public function write(mixed $model): mixed
    {
        try {
            return $this->dumper->dump($model);
        } catch (ParserException|\ReflectionException $e) {
            throw new MappingException($e->getMessage(), previous: $e);
        }
    }
}
