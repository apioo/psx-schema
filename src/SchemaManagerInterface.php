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

use PSX\Schema\Exception\InvalidSchemaException;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\Parser\ContextInterface;

/**
 * SchemaManagerInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
interface SchemaManagerInterface
{
    /**
     * Registers a new parser for the provided scheme
     */
    public function register(string $scheme, ParserInterface $parser): void;

    /**
     * The schema manager knows how to create a schema instance from the given source, it returns a schema interface
     * or throws an exception.
     *
     * The source must be an uri format where you can specify a fitting parser i.e.
     * - php://My.Acme.Dto
     *   Resolves the schema as PHP DTO class by looking at the properties and attributes through reflection
     * - php+doc://array<string>
     *   Resolves the schema as PHP doc type
     * - php+schema://My.Acme.Schema
     *   Resolves the schema as schema class, this means the class must be an instance of SchemaInterface
     * - file:///path/to/a/file.json
     *   Resolves the schema by parsing a JSON file
     * - http://www.acme.com/schema.json
     * - https://www.acme.com/schema.json
     *   Resolves the schema by requesting a remote source through http or https
     * - typehub://apioo:software@0.1.2
     *   Resolves the schema directly from TypeHub, this would i.e. resolve the schema https://typehub.cloud/d/apioo/software
     *
     * If the source is a simple string the manager tries to guess the fitting schema uri format otherwise
     * it is also possible to provide a concrete {@see SchemaSource} object
     *
     * @throws InvalidSchemaException
     * @throws ParserException
     */
    public function getSchema(string|SchemaSource $source, ?ContextInterface $context = null): SchemaInterface;

    /**
     * Clears the cache for a specific schema
     */
    public function clear(string|SchemaSource $source): void;
}
