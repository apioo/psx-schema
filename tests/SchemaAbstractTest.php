<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use PSX\Schema\SchemaAbstract;
use PSX\Schema\SchemaManager;

/**
 * SchemaAbstractTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaAbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    protected $reader;

    /**
     * @var \PSX\Schema\SchemaManager
     */
    protected $schemaManager;

    protected function setUp()
    {
        $this->reader        = new AnnotationReader();
        $this->schemaManager = new SchemaManager($this->reader);
    }

    /**
     * Tests whether we get a copy of a schema and not a reference
     */
    public function testGetSchema()
    {
        $schemaC = $this->schemaManager->getSchema('PSX\Schema\Tests\SchemaCommon')->getDefinition();
        $schemaA = $this->schemaManager->getSchema('PSX\Schema\Tests\SchemaA')->getDefinition();
        $schemaB = $this->schemaManager->getSchema('PSX\Schema\Tests\SchemaB')->getDefinition();

        $this->assertNull($schemaC->getProperty('lat')->getTitle());
        $this->assertNull($schemaC->getProperty('long')->getTitle());
        $this->assertNull($schemaC->getProperty('entry')->getItems()->getProperty('title')->getTitle());
        $this->assertNull($schemaC->getProperty('author')->getProperty('name')->getTitle());

        $this->assertEquals('foo', $schemaA->getProperty('lat')->getTitle());
        $this->assertEquals(null, $schemaA->getProperty('long')->getTitle());
        $this->assertEquals('foo', $schemaA->getProperty('entry')->getItems()->getProperty('title')->getTitle());
        $this->assertEquals(null, $schemaA->getProperty('author')->getProperty('name')->getTitle());

        $this->assertEquals(null, $schemaB->getProperty('lat')->getTitle());
        $this->assertEquals('bar', $schemaB->getProperty('long')->getTitle());
        $this->assertEquals(null, $schemaB->getProperty('entry')->getItems()->getProperty('title')->getTitle());
        $this->assertEquals('bar', $schemaB->getProperty('author')->getProperty('name')->getTitle());
    }
}

class SchemaCommon extends SchemaAbstract
{
    public function getDefinition()
    {
        $sb = $this->getSchemaBuilder('entry');
        $sb->integer('title');
        $entry = $sb->getProperty();

        $sb = $this->getSchemaBuilder('author');
        $sb->integer('name');
        $author = $sb->getProperty();

        $sb = $this->getSchemaBuilder('location')
            ->setDescription('Location of the person');
        $sb->integer('lat');
        $sb->integer('long');
        $sb->arrayType('entry')->setItems($entry);
        $sb->objectType('author', $author);

        return $sb->getProperty();
    }
}

class SchemaA extends SchemaAbstract
{
    public function getDefinition()
    {
        $property = $this->getSchema('PSX\Schema\Tests\SchemaCommon');
        $property->getProperty('lat')->setTitle('foo');
        $property->getProperty('entry')->getItems()->getProperty('title')->setTitle('foo');
        
        return $property;
    }
}

class SchemaB extends SchemaAbstract
{
    public function getDefinition()
    {
        $property = $this->getSchema('PSX\Schema\Tests\SchemaCommon');
        $property->getProperty('long')->setTitle('bar');
        $property->getProperty('author')->getProperty('name')->setTitle('bar');

        return $property;
    }
}
