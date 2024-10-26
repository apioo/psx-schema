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
use PSX\Schema\Generator\Rust;

/**
 * RustTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class RustTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $generator = new Rust();

        $chunks = $generator->generate($this->getSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/rust/default');

        $this->assertFileExists(__DIR__ . '/resource/rust/default/news.rs');
    }

    public function testGenerateComplex()
    {
        $generator = new Rust();

        $chunks = $generator->generate($this->getComplexSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/rust/complex');

        $this->assertFileExists(__DIR__ . '/resource/rust/complex/specification.rs');
    }

    public function testGenerateOOP()
    {
        $generator = new Rust();

        $chunks = $generator->generate($this->getOOPSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/rust/oop');

        $this->assertFileExists(__DIR__ . '/resource/rust/oop/root_schema.rs');
    }

    public function testGenerateImport()
    {
        $generator = new Rust();

        $chunks = $generator->generate($this->getImportSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/rust/import');

        $this->assertFileExists(__DIR__ . '/resource/rust/import/import.rs');
    }

    public function testGenerateImportNamespace()
    {
        $generator = new Rust(Config::of('FooBar', ['my_import' => 'My::Import']));

        $chunks = $generator->generate($this->getImportSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/rust/namespace');

        $this->assertFileExists(__DIR__ . '/resource/rust/namespace/import.rs');
    }
}
