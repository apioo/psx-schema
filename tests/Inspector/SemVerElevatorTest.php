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

namespace PSX\Schema\Tests;

use PSX\Schema\Inspector\ChangelogGenerator;
use PSX\Schema\Inspector\SemVerElevator;
use PSX\Schema\Tests\Schema\SchemaA;
use PSX\Schema\Tests\Schema\SchemaB;

/**
 * SemVerElevatorTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SemVerElevatorTest extends SchemaTestCase
{
    public function testElevate()
    {
        $schemaA = $this->schemaManager->getSchema(SchemaA::class);
        $schemaB = $this->schemaManager->getSchema(SchemaB::class);

        $elevator = new SemVerElevator();

        $this->assertEquals('0.1.0', $elevator->elevate('', $schemaA));
        $this->assertEquals('1.0.0', $elevator->elevate('0.4.0', $schemaA, $schemaB));
        $this->assertEquals('2.0.0', $elevator->elevate('1.1.0', $schemaA, $schemaB));
        $this->assertEquals('1.1.1', $elevator->elevate('1.1.0', $schemaA, $schemaA));
    }
}