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
use PSX\Schema\Generator\CSharp;

/**
 * CSharpTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class CSharpTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $generator = new CSharp();

        $chunks = $generator->generate($this->getSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/csharp/default');

        $this->assertFileExists(__DIR__ . '/resource/csharp/default/News.cs');
    }

    public function testGenerateComplex()
    {
        $generator = new CSharp();

        $chunks = $generator->generate($this->getComplexSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/csharp/complex');

        $this->assertFileExists(__DIR__ . '/resource/csharp/complex/Specification.cs');
    }

    public function testGenerateOOP()
    {
        $generator = new CSharp();

        $chunks = $generator->generate($this->getOOPSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/csharp/oop');

        $this->assertFileExists(__DIR__ . '/resource/csharp/oop/RootSchema.cs');
    }

    public function testGenerateImport()
    {
        $generator = new CSharp();

        $chunks = $generator->generate($this->getImportSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/csharp/import');

        $this->assertFileExists(__DIR__ . '/resource/csharp/import/Import.cs');
    }

    public function testGenerateImportNamespace()
    {
        $generator = new CSharp(Config::of('Foo.Bar', ['my_import' => 'My.Import']));

        $chunks = $generator->generate($this->getImportSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/csharp/namespace');

        $this->assertFileExists(__DIR__ . '/resource/csharp/namespace/Import.cs');
    }
}
