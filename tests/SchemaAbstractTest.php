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
use PSX\Schema\Schema;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManager;
use PSX\Schema\Tests\Schema\SchemaA;
use PSX\Schema\Tests\Schema\SchemaB;
use PSX\Schema\Tests\Schema\SchemaCommon;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StructType;

/**
 * SchemaAbstractTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class SchemaAbstractTest extends TestCase
{
    protected SchemaManager $schemaManager;

    protected function setUp(): void
    {
        $this->schemaManager = new SchemaManager();
    }

    /**
     * Tests whether we get a copy of a schema and not a reference
     */
    public function testGetSchema()
    {
        $schemaC = $this->schemaManager->getSchema(SchemaCommon::class);
        $schemaA = $this->schemaManager->getSchema(SchemaA::class);
        $schemaB = $this->schemaManager->getSchema(SchemaB::class);

        $this->assertInstanceOf(ReferenceType::class, $schemaC->getType());
        $type = $schemaC->getDefinitions()->getType($schemaC->getType()->getRef());
        $this->assertInstanceOf(StructType::class, $type);
        $this->assertNull($type->getProperty('lat')->getTitle());
        $this->assertNull($type->getProperty('long')->getTitle());

        $this->assertInstanceOf(ReferenceType::class, $schemaA->getType());
        $type = $schemaA->getDefinitions()->getType($schemaA->getType()->getRef());
        $this->assertInstanceOf(StructType::class, $type);
        $this->assertEquals('foo', $type->getProperty('lat')->getTitle());
        $this->assertEquals(null, $type->getProperty('long')->getTitle());

        $this->assertInstanceOf(ReferenceType::class, $schemaB->getType());
        $type = $schemaB->getDefinitions()->getType($schemaB->getType()->getRef());
        $this->assertInstanceOf(StructType::class, $type);
        $this->assertEquals(null, $type->getProperty('lat')->getTitle());
        $this->assertEquals('bar', $type->getProperty('long')->getTitle());
    }
    
    public function testSerialize()
    {
        $schema = $this->schemaManager->getSchema(SchemaCommon::class);

        $data = serialize($schema);

        /** @var SchemaInterface $schema */
        $schema = unserialize($data);

        $this->assertInstanceOf(Schema::class, $schema);
        $this->assertInstanceOf(StructType::class, $schema->getDefinitions()->getType('Entry'));
        $this->assertInstanceOf(StructType::class, $schema->getDefinitions()->getType('Author'));
        $this->assertInstanceOf(StructType::class, $schema->getDefinitions()->getType('Location'));
        $this->assertInstanceOf(ReferenceType::class, $schema->getType());
    }
}
