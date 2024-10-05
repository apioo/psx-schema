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

namespace PSX\Schema\Tests;

use PSX\Schema\Inspector\ChangelogGenerator;
use PSX\Schema\Tests\Schema\SchemaA;
use PSX\Schema\Tests\Schema\SchemaB;

/**
 * ChangelogGeneratorTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ChangelogGeneratorTest extends SchemaTestCase
{
    public function testGenerate()
    {
        $schemaA = $this->schemaManager->getSchema(SchemaA::class)->getDefinitions();
        $schemaB = $this->schemaManager->getSchema(SchemaB::class)->getDefinitions();

        $generator = new ChangelogGenerator();

        $actual = iterator_to_array($generator->generate($schemaA, $schemaB), false);
        $expect = [
            'Type "LocationA" was removed',
            'Type "LocationB" was added',
        ];

        $this->assertEquals($expect, $actual);
    }
}