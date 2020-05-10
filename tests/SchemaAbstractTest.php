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

namespace PSX\Schema\Tests;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;
use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Schema;
use PSX\Schema\SchemaAbstract;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManager;
use PSX\Schema\Type\StructType;
use PSX\Schema\TypeFactory;
use PSX\Schema\TypeInterface;

/**
 * SchemaAbstractTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaAbstractTest extends TestCase
{
    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    protected $reader;

    /**
     * @var \PSX\Schema\SchemaManager
     */
    protected $schemaManager;

    protected function setUp(): void
    {
        $this->reader        = new AnnotationReader();
        $this->schemaManager = new SchemaManager($this->reader);
    }

    /**
     * Tests whether we get a copy of a schema and not a reference
     */
    public function testGetSchema()
    {
        $schemaC = $this->schemaManager->getSchema(SchemaCommon::class)->getType();
        $schemaA = $this->schemaManager->getSchema(SchemaA::class)->getType();
        $schemaB = $this->schemaManager->getSchema(SchemaB::class)->getType();

        $this->assertNull($schemaC->getProperty('lat')->getTitle());
        $this->assertNull($schemaC->getProperty('long')->getTitle());

        $this->assertEquals('foo', $schemaA->getProperty('lat')->getTitle());
        $this->assertEquals(null, $schemaA->getProperty('long')->getTitle());

        $this->assertEquals(null, $schemaB->getProperty('lat')->getTitle());
        $this->assertEquals('bar', $schemaB->getProperty('long')->getTitle());
    }
    
    public function testSerialize()
    {
        $schema = $this->schemaManager->getSchema(SchemaCommon::class);

        $data = serialize($schema);

        /** @var SchemaInterface $schema */
        $schema = unserialize($data);

        $this->assertInstanceOf(Schema::class, $schema);
        $this->assertInstanceOf(StructType::class, $schema->getDefinitions()->getType('Author'));
        $this->assertInstanceOf(StructType::class, $schema->getType());
    }
}

class SchemaCommon extends SchemaAbstract
{
    public function build(DefinitionsInterface $definitions): TypeInterface
    {
        $entry = TypeFactory::getStruct();
        $entry->addProperty('title', TypeFactory::getInteger());
        $definitions->addType('Entry', $entry);

        $author = TypeFactory::getStruct();
        $author->addProperty('name', TypeFactory::getInteger());
        $definitions->addType('Author', $author);

        $location = TypeFactory::getStruct();
        $location->setDescription('Location of the person');
        $location->addProperty('lat', TypeFactory::getInteger());
        $location->addProperty('long', TypeFactory::getInteger());
        $location->addProperty('entry', TypeFactory::getArray()->setItems(TypeFactory::getReference('Entry')));
        $location->addProperty('author', TypeFactory::getReference('Author'));

        return $location;
    }
}

class SchemaA extends SchemaAbstract
{
    public function build(DefinitionsInterface $definitions): TypeInterface
    {
        $property = clone $this->getSchema(SchemaCommon::class)->getType();
        $property->getProperty('lat')->setTitle('foo');

        return $property;
    }
}

class SchemaB extends SchemaAbstract
{
    public function build(DefinitionsInterface $definitions): TypeInterface
    {
        $property = clone $this->getSchema(SchemaCommon::class)->getType();
        $property->getProperty('long')->setTitle('bar');

        return $property;
    }
}
