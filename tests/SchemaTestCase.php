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
use PSX\Schema\Property\ArrayType;
use PSX\Schema\Property\ComplexType;
use PSX\Schema\Property\CompositeTypeAbstract;
use PSX\Schema\PropertyAbstract;
use PSX\Schema\PropertyInterface;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManager;

/**
 * SchemaTestCase
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
abstract class SchemaTestCase extends \PHPUnit_Framework_TestCase
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

    protected function getSchema()
    {
        return $this->schemaManager->getSchema(TestSchema::class);
    }

    protected function assertSchema($leftSchema, $rightSchema)
    {
        $this->assertInstanceOf(SchemaInterface::class, $leftSchema);
        $this->assertInstanceOf(SchemaInterface::class, $rightSchema);

        $leftProperty  = $leftSchema->getDefinition();
        $rightProperty = $rightSchema->getDefinition();

        $this->assertInstanceOf(PropertyInterface::class, $leftProperty);
        $this->assertInstanceOf(PropertyInterface::class, $rightProperty);

        $expect = json_encode($leftProperty, JSON_PRETTY_PRINT);
        $actual = json_encode($rightProperty, JSON_PRETTY_PRINT);

        $this->assertJsonStringEqualsJsonString($expect, $actual);
    }
}
