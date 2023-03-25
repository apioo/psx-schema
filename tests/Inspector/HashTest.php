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

namespace PSX\Schema\Tests;

use PSX\Schema\Inspector\Hash;
use PSX\Schema\Tests\Schema\SchemaA;

/**
 * HashTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class HashTest extends SchemaTestCase
{
    public function testGenerate()
    {
        $schema = $this->schemaManager->getSchema(SchemaA::class)->getDefinitions();

        $value = (new Hash())->generate($schema);

        $this->assertEquals('7f30d51e70578cce4138b638a3d7a64494b16e83540e12f8905d3d6daa9beafc', $value, $value);
    }

    public function testGenerateByType()
    {
        $schema = $this->schemaManager->getSchema(SchemaA::class)->getDefinitions();

        $value = (new Hash())->generateByType($schema->getType('LocationA'));

        $this->assertEquals('c82f263dc455ec2af3b7acf6df0c483a873079d4d7357345a41220ef58528446', $value, $value);
    }
}
