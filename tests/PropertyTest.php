<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Schema\Property;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;

/**
 * PropertyTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class PropertyTest extends \PHPUnit_Framework_TestCase
{
    public function testArrayType()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getArray());
        $this->assertEquals(PropertyType::TYPE_ARRAY, Property::getArray()->getType());
    }

    public function testBinaryType()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getBinary());
        $this->assertEquals(PropertyType::TYPE_STRING, Property::getBinary()->getType());
        $this->assertEquals(PropertyType::FORMAT_BINARY, Property::getBinary()->getFormat());
    }
    
    public function testBoolean()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getBoolean());
        $this->assertEquals(PropertyType::TYPE_BOOLEAN, Property::getBoolean()->getType());
    }

    public function testDateTime()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getDateTime());
        $this->assertEquals(PropertyType::TYPE_STRING, Property::getDateTime()->getType());
        $this->assertEquals(PropertyType::FORMAT_DATETIME, Property::getDateTime()->getFormat());
    }

    public function testDate()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getDate());
        $this->assertEquals(PropertyType::TYPE_STRING, Property::getDate()->getType());
        $this->assertEquals(PropertyType::FORMAT_DATE, Property::getDate()->getFormat());
    }

    public function testDuration()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getDuration());
        $this->assertEquals(PropertyType::TYPE_STRING, Property::getDuration()->getType());
        $this->assertEquals(PropertyType::FORMAT_DURATION, Property::getDuration()->getFormat());
    }

    public function testIntegerType()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getInteger());
        $this->assertEquals(PropertyType::TYPE_INTEGER, Property::getInteger()->getType());
    }

    public function testNullType()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getNull());
        $this->assertEquals(PropertyType::TYPE_NULL, Property::getNull()->getType());
    }

    public function testNumberType()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getNumber());
        $this->assertEquals(PropertyType::TYPE_NUMBER, Property::getNumber()->getType());
    }

    public function testObjectType()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getObject());
        $this->assertEquals(PropertyType::TYPE_OBJECT, Property::getObject()->getType());
    }

    public function testStringType()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getString());
        $this->assertEquals(PropertyType::TYPE_STRING, Property::getString()->getType());
    }

    public function testTime()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getTime());
        $this->assertEquals(PropertyType::TYPE_STRING, Property::getTime()->getType());
        $this->assertEquals(PropertyType::FORMAT_TIME, Property::getTime()->getFormat());
    }

    public function testUri()
    {
        $this->assertInstanceOf(PropertyInterface::class, Property::getUri());
        $this->assertEquals(PropertyType::TYPE_STRING, Property::getUri()->getType());
        $this->assertEquals(PropertyType::FORMAT_URI, Property::getUri()->getFormat());
    }
}
