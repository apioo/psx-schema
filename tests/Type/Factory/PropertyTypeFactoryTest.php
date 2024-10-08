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

namespace PSX\Schema\Tests\Type\Factory;

use PHPUnit\Framework\TestCase;
use PSX\Schema\Format;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\BooleanPropertyType;
use PSX\Schema\Type\Factory\PropertyTypeFactory;
use PSX\Schema\Type\IntegerPropertyType;
use PSX\Schema\Type\MapPropertyType;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\StringPropertyType;

/**
 * PropertyTypeFactoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class PropertyTypeFactoryTest extends TestCase
{
    public function testArrayType()
    {
        $this->assertInstanceOf(ArrayPropertyType::class, PropertyTypeFactory::getArray());
    }

    public function testBoolean()
    {
        $this->assertInstanceOf(BooleanPropertyType::class, PropertyTypeFactory::getBoolean());
    }

    public function testDateTime()
    {
        $this->assertInstanceOf(StringPropertyType::class, PropertyTypeFactory::getDateTime());
        $this->assertEquals(Format::DATETIME, PropertyTypeFactory::getDateTime()->getFormat());
    }

    public function testDate()
    {
        $this->assertInstanceOf(StringPropertyType::class, PropertyTypeFactory::getDate());
        $this->assertEquals(Format::DATE, PropertyTypeFactory::getDate()->getFormat());
    }

    public function testIntegerType()
    {
        $this->assertInstanceOf(IntegerPropertyType::class, PropertyTypeFactory::getInteger());
    }

    public function testNumberType()
    {
        $this->assertInstanceOf(NumberPropertyType::class, PropertyTypeFactory::getNumber());
    }

    public function testMapType()
    {
        $this->assertInstanceOf(MapPropertyType::class, PropertyTypeFactory::getMap());
    }

    public function testStringType()
    {
        $this->assertInstanceOf(StringPropertyType::class, PropertyTypeFactory::getString());
    }

    public function testTime()
    {
        $this->assertInstanceOf(StringPropertyType::class, PropertyTypeFactory::getTime());
        $this->assertEquals(Format::TIME, PropertyTypeFactory::getTime()->getFormat());
    }
}
