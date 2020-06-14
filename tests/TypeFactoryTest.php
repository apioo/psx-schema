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

use PHPUnit\Framework\TestCase;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\TypeFactory;

/**
 * TypeFactoryTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class TypeFactoryTest extends TestCase
{
    public function testArrayType()
    {
        $this->assertInstanceOf(ArrayType::class, TypeFactory::getArray());
    }

    public function testBinaryType()
    {
        $this->assertInstanceOf(StringType::class, TypeFactory::getBinary());
        $this->assertEquals(TypeAbstract::FORMAT_BINARY, TypeFactory::getBinary()->getFormat());
    }
    
    public function testBoolean()
    {
        $this->assertInstanceOf(BooleanType::class, TypeFactory::getBoolean());
    }

    public function testDateTime()
    {
        $this->assertInstanceOf(StringType::class, TypeFactory::getDateTime());
        $this->assertEquals(TypeAbstract::FORMAT_DATETIME, TypeFactory::getDateTime()->getFormat());
    }

    public function testDate()
    {
        $this->assertInstanceOf(StringType::class, TypeFactory::getDate());
        $this->assertEquals(TypeAbstract::FORMAT_DATE, TypeFactory::getDate()->getFormat());
    }

    public function testDuration()
    {
        $this->assertInstanceOf(StringType::class, TypeFactory::getDuration());
        $this->assertEquals(TypeAbstract::FORMAT_DURATION, TypeFactory::getDuration()->getFormat());
    }

    public function testIntegerType()
    {
        $this->assertInstanceOf(IntegerType::class, TypeFactory::getInteger());
    }

    public function testNumberType()
    {
        $this->assertInstanceOf(NumberType::class, TypeFactory::getNumber());
    }

    public function testStructType()
    {
        $this->assertInstanceOf(StructType::class, TypeFactory::getStruct());
    }

    public function testMapType()
    {
        $this->assertInstanceOf(MapType::class, TypeFactory::getMap());
    }

    public function testStringType()
    {
        $this->assertInstanceOf(StringType::class, TypeFactory::getString());
    }

    public function testTime()
    {
        $this->assertInstanceOf(StringType::class, TypeFactory::getTime());
        $this->assertEquals(TypeAbstract::FORMAT_TIME, TypeFactory::getTime()->getFormat());
    }

    public function testUri()
    {
        $this->assertInstanceOf(StringType::class, TypeFactory::getUri());
        $this->assertEquals(TypeAbstract::FORMAT_URI, TypeFactory::getUri()->getFormat());
    }
}
