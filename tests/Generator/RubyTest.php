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
use PSX\Schema\Generator\Ruby;

/**
 * RubyTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class RubyTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $generator = new Ruby();

        $chunks = $generator->generate($this->getSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/ruby/default');

        $this->assertFileExists(__DIR__ . '/resource/ruby/default/news.rb');
    }

    public function testGenerateComplex()
    {
        $generator = new Ruby();

        $chunks = $generator->generate($this->getComplexSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/ruby/complex');

        $this->assertFileExists(__DIR__ . '/resource/ruby/complex/specification.rb');
    }

    public function testGenerateOOP()
    {
        $generator = new Ruby();

        $chunks = $generator->generate($this->getOOPSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/ruby/oop');

        $this->assertFileExists(__DIR__ . '/resource/ruby/oop/root_schema.rb');
    }

    public function testGenerateImport()
    {
        $generator = new Ruby();

        $chunks = $generator->generate($this->getImportSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/ruby/import');

        $this->assertFileExists(__DIR__ . '/resource/ruby/import/import.rb');
    }

    public function testGenerateImportNamespace()
    {
        $generator = new Ruby(Config::of('FooBar', ['my_import' => 'My::Import']));

        $chunks = $generator->generate($this->getImportSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/ruby/namespace');

        $this->assertFileExists(__DIR__ . '/resource/ruby/namespace/import.rb');
    }
}
