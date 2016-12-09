<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

namespace PSX\Schema\Tests\Visitor;

use Doctrine\Common\Collections\Collection;
use PSX\Schema\Property;
use PSX\Schema\Tests\Visitor\TypeVisitor\ArrayAccessClass;
use PSX\Schema\Tests\Visitor\TypeVisitor\PopoClass;
use PSX\Schema\Tests\Visitor\TypeVisitor\RecordClass;
use PSX\Schema\Tests\Visitor\TypeVisitor\StdClass;
use PSX\Schema\Visitor\TypeVisitor;
use PSX\Uri\Uri;

/**
 * IncomingVisitorTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class IncomingVisitorTest extends \PHPUnit_Framework_TestCase
{
    public function testVisitArray()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getArray();
        $data     = $visitor->visitArray([10], $property, '');

        $this->assertInstanceOf(Collection::class, $data);
        $this->assertSame([10], $data->toArray());
    }

    public function testVisitBinary()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getBinary();
        $data     = $visitor->visitBinary(base64_encode('foo'), $property, '');

        $this->assertInternalType('resource', $data);
        $this->assertSame('foo', stream_get_contents($data));
    }

    public function testVisitBoolean()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getBinary();

        $this->assertSame(true, $visitor->visitBoolean(true, $property, ''));
    }

    public function testVisitObject()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getObject()
            ->setClass(ArrayAccessClass::class)
            ->addProperty('foo', Property::getString())
            ->addProperty('bar', Property::getString());

        // array access class
        $record = $visitor->visitObject((object) ['foo' => 'bar', 'bar' => 'foo'], $property, '');

        $this->assertInstanceOf(ArrayAccessClass::class, $record);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $record->getArrayCopy());

        // popo class
        $property->setClass(PopoClass::class);

        $record = $visitor->visitObject((object) ['foo' => 'bar', 'bar' => 'foo'], $property, '');

        $this->assertInstanceOf(PopoClass::class, $record);
        $this->assertEquals('bar', $record->getFoo());
        $this->assertEquals('foo', $record->getBar());

        // record class
        $property->setClass(RecordClass::class);

        $record = $visitor->visitObject((object) ['foo' => 'bar', 'bar' => 'foo'], $property, '');

        $this->assertInstanceOf(RecordClass::class, $record);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $record->getProperties());

        // std class
        $property->setClass(StdClass::class);

        $record = $visitor->visitObject((object) ['foo' => 'bar', 'bar' => 'foo'], $property, '');

        $this->assertInstanceOf(StdClass::class, $record);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], (array) $record);
    }

    public function testVisitDateTime()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getDateTime();

        $this->assertInstanceOf('DateTime', $visitor->visitDateTime('2002-10-10T17:00:00Z', $property, ''));
        $this->assertInstanceOf('DateTime', $visitor->visitDateTime('2002-10-10T17:00:00+01:00', $property, ''));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Must be valid date time format
     */
    public function testVisitDateTimeInvalidFormat()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getDateTime();

        $visitor->visitDateTime('foo', $property, '');
    }

    public function testVisitDate()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getDate();

        $this->assertInstanceOf('PSX\DateTime\Date', $visitor->visitDate('2000-01-01', $property, ''));
        $this->assertInstanceOf('PSX\DateTime\Date', $visitor->visitDate('2000-01-01+13:00', $property, ''));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Must be valid date format
     */
    public function testVisitDateInvalidFormat()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getDate();

        $visitor->visitDate('foo', $property, '');
    }

    public function testVisitDuration()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getDuration();

        $this->assertInstanceOf('PSX\DateTime\Duration', $visitor->visitDuration('P1D', $property, ''));
        $this->assertInstanceOf('PSX\DateTime\Duration', $visitor->visitDuration('P1DT12H', $property, ''));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Must be duration forma
     */
    public function testVisitDurationInvalidFormat()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getDuration();

        $visitor->visitDuration('foo', $property, '');
    }

    public function testVisitFloat()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getNumber();

        $this->assertSame(1.1, $visitor->visitNumber(1.1, $property, ''));
    }

    public function testVisitInteger()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getInteger();

        $this->assertSame(1, $visitor->visitNumber(1, $property, ''));
    }

    public function testVisitString()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getString();

        $this->assertSame('foo', $visitor->visitString('foo', $property, ''));
    }

    public function testVisitTime()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getTime();

        $this->assertInstanceOf('PSX\DateTime\Time', $visitor->visitTime('10:00:00', $property, ''));
        $this->assertInstanceOf('PSX\DateTime\Time', $visitor->visitTime('10:00:00+02:00', $property, ''));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Must be valid time format
     */
    public function testVisitTimeInvalidFormat()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getTime();

        $visitor->visitTime('foo', $property, '');
    }

    public function testVisitUri()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getUri();

        $this->assertInstanceOf('PSX\Uri\Uri', $visitor->visitUri('/foo', $property, ''));
        $this->assertInstanceOf('PSX\Uri\Uri', $visitor->visitUri('http://foo.com?foo=bar', $property, ''));
    }
}
