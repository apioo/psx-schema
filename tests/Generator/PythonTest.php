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
use PSX\Schema\Generator\Python;

/**
 * PythonTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class PythonTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $generator = new Python();

        $chunks = $generator->generate($this->getSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/python/default');

        $this->assertFileExists(__DIR__ . '/resource/python/default/news.py');
    }

    public function testGenerateComplex()
    {
        $generator = new Python();

        $chunks = $generator->generate($this->getComplexSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/python/complex');

        $this->assertFileExists(__DIR__ . '/resource/python/complex/type_schema.py');
    }

    public function testGenerateOOP()
    {
        $generator = new Python();

        $chunks = $generator->generate($this->getOOPSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/python/oop');

        $this->assertFileExists(__DIR__ . '/resource/python/oop/root_schema.py');
    }

    public function testGenerateImport()
    {
        $generator = new Python(Config::of('app', ['my_import' => 'my.import']));

        $chunks = $generator->generate($this->getImportSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/python/import');

        $this->assertFileExists(__DIR__ . '/resource/python/import/import.py');
    }

    public function testGenerateImportNamespace()
    {
        $generator = new Python(Config::of('app', ['my_import' => 'my.import']));

        $chunks = $generator->generate($this->getImportSchema());
        $this->write($generator, $chunks, __DIR__ . '/resource/python/namespace');

        $this->assertFileExists(__DIR__ . '/resource/python/namespace/import.py');
    }
}
