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
use PSX\Schema\Format;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\BooleanPropertyType;
use PSX\Schema\Type\IntegerPropertyType;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\TypeFactory;

/**
 * TypeFactoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TypeFactoryTest extends TestCase
{
    public function testArrayType()
    {
        $this->assertInstanceOf(ArrayPropertyType::class, TypeFactory::getArray());
    }

    public function testBinaryType()
    {
        $this->assertInstanceOf(StringPropertyType::class, TypeFactory::getBinary());
        $this->assertEquals(Format::BINARY, TypeFactory::getBinary()->getFormat());
    }
    
    public function testBoolean()
    {
        $this->assertInstanceOf(BooleanPropertyType::class, TypeFactory::getBoolean());
    }

    public function testDateTime()
    {
        $this->assertInstanceOf(StringPropertyType::class, TypeFactory::getDateTime());
        $this->assertEquals(Format::DATETIME, TypeFactory::getDateTime()->getFormat());
    }

    public function testDate()
    {
        $this->assertInstanceOf(StringPropertyType::class, TypeFactory::getDate());
        $this->assertEquals(Format::DATE, TypeFactory::getDate()->getFormat());
    }

    public function testDuration()
    {
        $this->assertInstanceOf(StringPropertyType::class, TypeFactory::getDuration());
        $this->assertEquals(Format::DURATION, TypeFactory::getDuration()->getFormat());
    }

    public function testIntegerType()
    {
        $this->assertInstanceOf(IntegerPropertyType::class, TypeFactory::getInteger());
    }

    public function testNumberType()
    {
        $this->assertInstanceOf(NumberPropertyType::class, TypeFactory::getNumber());
    }

    public function testStructType()
    {
        $this->assertInstanceOf(StructDefinitionType::class, TypeFactory::getStruct());
    }

    public function testMapType()
    {
        $this->assertInstanceOf(MapDefinitionType::class, TypeFactory::getMap());
    }

    public function testStringType()
    {
        $this->assertInstanceOf(StringPropertyType::class, TypeFactory::getString());
    }

    public function testTime()
    {
        $this->assertInstanceOf(StringPropertyType::class, TypeFactory::getTime());
        $this->assertEquals(Format::TIME, TypeFactory::getTime()->getFormat());
    }

    public function testUri()
    {
        $this->assertInstanceOf(StringPropertyType::class, TypeFactory::getUri());
        $this->assertEquals(Format::URI, TypeFactory::getUri()->getFormat());
    }
}
