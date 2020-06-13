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

use PSX\Schema\Generator\JsonSchema;

/**
 * JsonSchemaTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class JsonSchemaTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $generator = new JsonSchema();

        $actual = $generator->generate($this->getSchema());
        $expect = file_get_contents(__DIR__ . '/resource/jsonschema.json');

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testGenerateComplex()
    {
        $generator = new JsonSchema();

        $actual = (string) $generator->generate($this->getComplexSchema());
        $expect = file_get_contents(__DIR__ . '/resource/jsonschema_complex.json');

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testGenerateOOP()
    {
        $generator = new JsonSchema();

        $actual = (string) $generator->generate($this->getOOPSchema());
        $expect = file_get_contents(__DIR__ . '/resource/jsonschema_oop.json');

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
