<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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
        $generator = new Php();

        $actual = (string) $generator->generate($this->getSchema());

        $expect = file_get_contents(__DIR__ . '/resource/php.php');
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateComplex()
    {
        $generator = new Php();

        $actual = (string) $generator->generate($this->getComplexSchema());

        $expect = file_get_contents(__DIR__ . '/resource/php_complex.php');
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateOOP()
    {
        $generator = new Php();

        $actual = (string) $generator->generate($this->getOOPSchema());

        $expect = file_get_contents(__DIR__ . '/resource/php_oop.php');
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateUnion()
    {
        $generator = new Php();

        $actual = (string) $generator->generate($this->getUnionSchema());

        $expect = file_get_contents(__DIR__ . '/resource/php_union.php');
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testExecute()
    {
        $source    = $this->getSchema();
        $generator = new Php();
        $result    = $generator->generate($source);
        $file      = __DIR__ . '/generated_schema.php';

        file_put_contents($file, '<?php' . "\n" . 'namespace ' . __NAMESPACE__ . ';' . "\n" . $result);

        include_once $file;

        $reader = new SimpleAnnotationReader();
        $reader->addNamespace('PSX\\Schema\\Annotation');

        $schemaManager = new SchemaManager($reader);
        $schema        = $schemaManager->getSchema(__NAMESPACE__ . '\\News');

        $this->assertSchema($schema, $source);
    }

    public function testExecuteOOP()
    {
        $source    = $this->getOOPSchema();
        $generator = new Php();
        $result    = $generator->generate($source);
        $file      = __DIR__ . '/generated_schema_oop.php';

        file_put_contents($file, '<?php' . "\n" . 'namespace ' . __NAMESPACE__ . ';' . "\n" . $result);

        include_once $file;

        $reader = new SimpleAnnotationReader();
        $reader->addNamespace('PSX\\Schema\\Annotation');

        $schemaManager = new SchemaManager($reader);
        $schema        = $schemaManager->getSchema(__NAMESPACE__ . '\\RootSchema');

        $this->assertSchema($schema, $source);
    }
}
