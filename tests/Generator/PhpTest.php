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

namespace PSX\Schema\Tests\Generator;

use PSX\Schema\Generator\Config;
use PSX\Schema\Generator\Php;

/**
 * PhpTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class PhpTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $generator = new Php();

        $chunks = $generator->generate($this->getSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/php/default');

        $this->assertFileExists(__DIR__ . '/resource/php/default/News.php');
    }

    public function testGenerateComplex()
    {
        $generator = new Php(Config::of('TypeAPI\\Model'));

        $chunks = $generator->generate($this->getComplexSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/php/complex');

        $this->assertFileExists(__DIR__ . '/resource/php/complex/TypeSchema.php');
    }

    public function testGenerateOOP()
    {
        $generator = new Php();

        $chunks = $generator->generate($this->getOOPSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/php/oop');

        $this->assertFileExists(__DIR__ . '/resource/php/oop/RootSchema.php');
    }

    public function testGenerateImport()
    {
        $generator = new Php();

        $chunks = $generator->generate($this->getImportSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/php/import');

        $this->assertFileExists(__DIR__ . '/resource/php/import/Import.php');
    }

    public function testGenerateImportNamespace()
    {
        $generator = new Php(Config::of('Foo\\Bar', ['my_import' => 'My\\Import']));

        $chunks = $generator->generate($this->getImportSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/php/namespace');

        $this->assertFileExists(__DIR__ . '/resource/php/namespace/Import.php');
    }
}
