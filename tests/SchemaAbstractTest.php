<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

use Doctrine\Common\Annotations\SimpleAnnotationReader;
use PSX\Cache\Pool;
use PSX\Schema\SchemaAbstract;
use PSX\Schema\SchemaManager;

/**
 * SchemaAbstractTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
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
        $this->reader = new SimpleAnnotationReader();
        $this->reader->addNamespace('PSX\\Schema\\Parser\\Popo\\Annotation');

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

        $this->assertNull($schemaC->get('long')->isRequired());
        $this->assertNull($schemaC->get('long')->isRequired());
        $this->assertNull($schemaC->get('entry')->getPrototype()->get('title')->isRequired());
        $this->assertNull($schemaC->get('author')->get('name')->isRequired());

        $this->assertTrue($schemaA->get('lat')->isRequired());
        $this->assertNull($schemaA->get('long')->isRequired());
        $this->assertTrue($schemaA->get('entry')->getPrototype()->get('title')->isRequired());
        $this->assertNull($schemaA->get('author')->get('name')->isRequired());

        $this->assertNull($schemaB->get('lat')->isRequired());
        $this->assertTrue($schemaB->get('long')->isRequired());
        $this->assertNull($schemaB->get('entry')->getPrototype()->get('title')->isRequired());
        $this->assertTrue($schemaB->get('author')->get('name')->isRequired());
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
        $sb->arrayType('entry')->setPrototype($entry);
        $sb->complexType($author);

        return $sb->getProperty();
    }
}

class SchemaA extends SchemaAbstract
{
    public function getDefinition()
    {
        $property = $this->getSchema('PSX\Schema\Tests\SchemaCommon');
        $property->get('lat')->setRequired(true);
        $property->get('entry')->getPrototype()->get('title')->setRequired(true);
        
        return $property;
    }
}

class SchemaB extends SchemaAbstract
{
    public function getDefinition()
    {
        $property = $this->getSchema('PSX\Schema\Tests\SchemaCommon');
        $property->get('long')->setRequired(true);
        $property->get('author')->get('name')->setRequired(true);

        return $property;
    }
}
