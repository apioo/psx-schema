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

namespace PSX\Schema\Parser;

use PSX\Schema\Exception\ParserException;
use PSX\Schema\ParserInterface;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManagerInterface;

/**
 * SchemaClass
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class SchemaClass implements ParserInterface
{
    private SchemaManagerInterface $schemaManager;

    public function __construct(SchemaManagerInterface $schemaManager)
    {
        $this->schemaManager = $schemaManager;
    }

    public function parse(string $schema, ?ContextInterface $context = null): SchemaInterface
    {
        $className = str_replace('.', '\\', $schema);

        $schema = new $className($this->schemaManager);
        if (!$schema instanceof SchemaInterface) {
            throw new ParserException('Class ' . $className . ' must implement the interface ' . SchemaInterface::class);
        }

        return $schema;
    }
}
