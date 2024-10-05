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

use PHPUnit\Framework\TestCase;
use PSX\Schema\DefinitionTypeFactory;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\StructDefinitionType;

/**
 * DefinitionTypeFactoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class DefinitionTypeFactoryTest extends TestCase
{
    public function testStructType()
    {
        $this->assertInstanceOf(StructDefinitionType::class, DefinitionTypeFactory::getStruct());
    }

    public function testMapType()
    {
        $this->assertInstanceOf(MapDefinitionType::class, DefinitionTypeFactory::getMap());
    }

    public function testArrayType()
    {
        $this->assertInstanceOf(ArrayDefinitionType::class, DefinitionTypeFactory::getArray());
    }
}
