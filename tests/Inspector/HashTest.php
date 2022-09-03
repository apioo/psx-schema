<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

        $this->assertEquals('dece91b3a9245f6d069dcce286e3c30dc7a32807a6e38423722c2e9ab9b731ea', $value, $value);
    }
}
