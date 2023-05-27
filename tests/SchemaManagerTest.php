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

namespace PSX\Schema\Tests;

use PHPUnit\Framework\TestCase;
use PSX\Schema\Exception\InvalidSchemaException;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManager;
use PSX\Schema\Tests\Parser\Popo\Attribute\News;

/**
 * SchemaManagerTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class SchemaManagerTest extends TestCase
{
    protected SchemaManager $schemaManager;

    protected function setUp(): void
    {
        $this->schemaManager = new SchemaManager();
    }

    public function testGetSchemaClass()
    {
        $schema = $this->schemaManager->getSchema(TestSchema::class);

        $this->assertInstanceOf(SchemaInterface::class, $schema);
    }

    public function testGetSchemaPopo()
    {
        $schema = $this->schemaManager->getSchema(News::class);

        $this->assertInstanceOf(SchemaInterface::class, $schema);
    }

    public function testGetSchemaFile()
    {
        $schema = $this->schemaManager->getSchema(__DIR__ . '/Parser/TypeSchema/test_schema.json');

        $this->assertInstanceOf(SchemaInterface::class, $schema);
    }

    public function testGetSchemaHttps()
    {
        $schema = $this->schemaManager->getSchema('https://api.typehub.cloud/export/apioo-developer-1.0.1-typeschema');

        $this->assertInstanceOf(SchemaInterface::class, $schema);
    }

    public function testGetSchemaTypeHub()
    {
        $schema = $this->schemaManager->getSchema('apioo/developer:1.0.1');

        $this->assertInstanceOf(SchemaInterface::class, $schema);
    }

    public function testGetSchemaNotExisting()
    {
        $this->expectException(InvalidSchemaException::class);

        $schemaManager = new SchemaManager();
        $schemaManager->getSchema('foo');
    }
}
