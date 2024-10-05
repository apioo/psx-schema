<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

        $actual = $generator->generate($this->getSchema());

        $expect = file_get_contents(__DIR__ . '/resource/rust/rust.rs');
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateComplex()
    {
        $generator = new Rust();

        $actual = (string) $generator->generate($this->getComplexSchema());

        $expect = file_get_contents(__DIR__ . '/resource/rust/rust_complex.rs');
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateOOP()
    {
        $generator = new Rust();

        $actual = (string) $generator->generate($this->getOOPSchema());

        $expect = file_get_contents(__DIR__ . '/resource/rust/rust_oop.rs');
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateImport()
    {
        $generator = new Rust();

        $actual = (string) $generator->generate($this->getImportSchema());

        $expect = file_get_contents(__DIR__ . '/resource/rust/rust_import.rs');
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testGenerateImportNamespace()
    {
        $generator = new Rust(Config::of('FooBar', ['my_import' => 'My::Import']));

        $actual = (string) $generator->generate($this->getImportSchema());

        $expect = file_get_contents(__DIR__ . '/resource/rust/rust_import_ns.rs');
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }
}
