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

namespace PSX\Schema\Tests\Generator;

use Doctrine\Common\Annotations\SimpleAnnotationReader;
use PhpParser\Node\Stmt\Namespace_;
use PSX\Schema\Generator\Php;
use PSX\Schema\Parser;
use PSX\Schema\SchemaManager;

/**
 * PhpTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class PhpTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $generator = new Php(__NAMESPACE__);

        $actual = $generator->generate($this->getSchema());

        $expect = file_get_contents(__DIR__ . '/resource/php.php');
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateRecursive()
    {
        $schema    = Parser\JsonSchema::fromFile(__DIR__ . '/../Parser/JsonSchema/schema.json');
        $generator = new Php();

        $actual = $generator->generate($schema);
        $actual = preg_replace('/Object([0-9A-Fa-f]{8})/', 'ObjectId', $actual);

        $expect = $expect = file_get_contents(__DIR__ . '/resource/php_recursive.php');
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testExecute()
    {
        $source    = $this->getSchema();
        $generator = new Php(__NAMESPACE__);
        $result    = $generator->generate($source);
        $file      = __DIR__ . '/generated_schema.php';

        file_put_contents($file, $result);

        include_once $file;

        $schemaManager = new SchemaManager(new SimpleAnnotationReader());
        $schema        = $schemaManager->getSchema(__NAMESPACE__ . '\\News');

        $this->assertSchema($schema, $source);
    }

    public function testGetNode()
    {
        $generator = new Php(__NAMESPACE__);

        $this->assertNull($generator->getNode());

        $generator->generate($this->getSchema());

        $this->assertInstanceOf(Namespace_::class, $generator->getNode());
    }
}
