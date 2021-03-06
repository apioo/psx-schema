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
use PSX\Schema\Generator\Code\Chunks;
use PSX\Schema\Generator\Php;
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

        if (PHP_MAJOR_VERSION >= 8) {
            $expect = file_get_contents(__DIR__ . '/resource/php8.php');
        } else {
            $expect = file_get_contents(__DIR__ . '/resource/php.php');
        }
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateComplex()
    {
        $generator = new Php();

        $actual = (string) $generator->generate($this->getComplexSchema());

        if (PHP_MAJOR_VERSION >= 8) {
            $expect = file_get_contents(__DIR__ . '/resource/php_complex8.php');
        } else {
            $expect = file_get_contents(__DIR__ . '/resource/php_complex.php');
        }
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateOOP()
    {
        $generator = new Php();

        $actual = (string) $generator->generate($this->getOOPSchema());

        if (PHP_MAJOR_VERSION >= 8) {
            $expect = file_get_contents(__DIR__ . '/resource/php_oop8.php');
        } else {
            $expect = file_get_contents(__DIR__ . '/resource/php_oop.php');
        }
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateUnion()
    {
        $generator = new Php();

        $actual = (string) $generator->generate($this->getUnionSchema());

        if (PHP_MAJOR_VERSION >= 8) {
            $expect = file_get_contents(__DIR__ . '/resource/php_union8.php');
        } else {
            $expect = file_get_contents(__DIR__ . '/resource/php_union.php');
        }
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateImport()
    {
        $generator = new Php();

        $actual = (string) $generator->generate($this->getImportSchema());

        if (PHP_MAJOR_VERSION >= 8) {
            $expect = file_get_contents(__DIR__ . '/resource/php_import8.php');
        } else {
            $expect = file_get_contents(__DIR__ . '/resource/php_import.php');
        }
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateImportNamespace()
    {
        $generator = new Php('Foo\\Bar', ['my_import' => 'My\\Import']);

        $actual = (string) $generator->generate($this->getImportSchema());

        if (PHP_MAJOR_VERSION >= 8) {
            $expect = file_get_contents(__DIR__ . '/resource/php_import_ns8.php');
        } else {
            $expect = file_get_contents(__DIR__ . '/resource/php_import_ns.php');
        }
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testExecute()
    {
        $source    = $this->getSchema();
        $generator = new Php(__NAMESPACE__ . '\\Result');
        $result    = $generator->generate($source);
        $className = __NAMESPACE__ . '\\Result\\News';

        $this->dumpResult($result);

        $reader = new SimpleAnnotationReader();
        $reader->addNamespace('PSX\\Schema\\Annotation');

        $schemaManager = new SchemaManager($reader);
        $schema        = $schemaManager->getSchema($className);

        $this->assertSchema($schema, $source);

        /** @var News $news */
        $news = new $className();
        $news->setContent('foobar');

        $expect = <<<JSON
{
    "content": "foobar",
    "version": "http://foo.bar"
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, json_encode($news));
    }

    public function testExecuteOOP()
    {
        $source    = $this->getOOPSchema();
        $generator = new Php(__NAMESPACE__ . '\\Result');
        $result    = $generator->generate($source);

        $this->dumpResult($result);

        $reader = new SimpleAnnotationReader();
        $reader->addNamespace('PSX\\Schema\\Annotation');

        $schemaManager = new SchemaManager($reader);
        $schema        = $schemaManager->getSchema(__NAMESPACE__ . '\\Result\\RootSchema');

        $this->assertSchema($schema, $source);
    }

    private function dumpResult(Chunks $chunks)
    {
        foreach ($chunks->getChunks() as $file => $code) {
            file_put_contents(__DIR__ . '/Result/' . $file . '.php', '<?php' . "\n" . $code);
        }
    }
}
