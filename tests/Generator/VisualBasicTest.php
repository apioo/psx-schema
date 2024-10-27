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
use PSX\Schema\Generator\VisualBasic;

/**
 * VisualBasicTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class VisualBasicTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $generator = new VisualBasic();

        $chunks = $generator->generate($this->getSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/visualbasic/default');

        $this->assertFileExists(__DIR__ . '/resource/visualbasic/default/News.vb');
    }

    public function testGenerateComplex()
    {
        $generator = new VisualBasic();

        $chunks = $generator->generate($this->getComplexSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/visualbasic/complex');

        $this->assertFileExists(__DIR__ . '/resource/visualbasic/complex/TypeSchema.vb');
    }

    public function testGenerateOOP()
    {
        $generator = new VisualBasic();

        $chunks = $generator->generate($this->getOOPSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/visualbasic/oop');

        $this->assertFileExists(__DIR__ . '/resource/visualbasic/oop/RootSchema.vb');
    }

    public function testGenerateImport()
    {
        $generator = new VisualBasic();

        $chunks = $generator->generate($this->getImportSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/visualbasic/import');

        $this->assertFileExists(__DIR__ . '/resource/visualbasic/import/Import.vb');
    }

    public function testGenerateImportNamespace()
    {
        $generator = new VisualBasic(Config::of('Foo.Bar', ['my_import' => 'My.Import']));

        $chunks = $generator->generate($this->getImportSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/visualbasic/namespace');

        $this->assertFileExists(__DIR__ . '/resource/visualbasic/namespace/Import.vb');
    }
}
