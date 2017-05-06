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

namespace PSX\Schema\Tests\Visitor;

use PSX\DateTime\Date;
use PSX\DateTime\DateTime;
use PSX\DateTime\Duration;
use PSX\DateTime\Time;
use PSX\Record\RecordInterface;
use PSX\Schema\Property;
use PSX\Schema\Tests\Visitor\TypeVisitor\ArrayAccessClass;
use PSX\Schema\Tests\Visitor\TypeVisitor\PopoClass;
use PSX\Schema\Tests\Visitor\TypeVisitor\RecordClass;
use PSX\Schema\Tests\Visitor\TypeVisitor\StdClass;
use PSX\Schema\Validation\Field;
use PSX\Schema\Validation\Validator;
use PSX\Schema\Visitor\TypeVisitor;
use PSX\Uri\Uri;
use PSX\Validate\Filter;

/**
 * TypeVisitorTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class TypeVisitorTest extends \PHPUnit_Framework_TestCase
{
    public function testVisitArray()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getArray();
        $data     = $visitor->visitArray([10], $property, '');

        $this->assertInternalType('array', $data);
        $this->assertSame([10], $data);
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testVisitArrayValidate()
    {
        $validator = new Validator([
            new Field('/foo/bar', [function (array $data) {
                return count($data) < 2;
            }])
        ]);

        $property = Property::getArray();
        $visitor  = new TypeVisitor($validator);
        $visitor->visitArray([10, 8, 6], $property, '/foo/bar');
    }

    public function testVisitBinary()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getBinary();
        $data     = $visitor->visitBinary(base64_encode('foo'), $property, '');

        $this->assertInternalType('resource', $data);
        $this->assertSame('foo', stream_get_contents($data));
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testVisitBinaryValidate()
    {
        $validator = new Validator([
            new Field('/foo/bar', [function ($data) {
                return fstat($data)['size'] < 2;
            }])
        ]);

        $property = Property::getBinary();
        $visitor  = new TypeVisitor($validator);
        $visitor->visitBinary(base64_encode('foo'), $property, '/foo/bar');
    }

    public function testVisitBoolean()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getBoolean();

        $this->assertSame(true, $visitor->visitBoolean(true, $property, ''));
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testVisitBooleanValidate()
    {
        $validator = new Validator([
            new Field('/foo/bar', [function ($data) {
                return $data === true;
            }])
        ]);

        $property = Property::getBoolean();
        $visitor  = new TypeVisitor($validator);
        $visitor->visitBoolean(false, $property, '/foo/bar');
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

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testVisitObjectValidate()
    {
        $validator = new Validator([
            new Field('/foo/bar', [function (RecordInterface $data) {
                return isset($data->foo);
            }])
        ]);

        $property = Property::getObject();
        $visitor  = new TypeVisitor($validator);
        $visitor->visitObject((object) ['bar' => 'foo'], $property, '/foo/bar');
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testVisitObjectValidatePopo()
    {
        $validator = new Validator([
            new Field('/foo/bar', [function (PopoClass $data) {
                return $data->getFoo() == 'foo';
            }])
        ]);

        $property = Property::getObject();
        $property->setClass(PopoClass::class);
        $visitor  = new TypeVisitor($validator);
        $visitor->visitObject((object) ['foo' => 'bar', 'bar' => 'foo'], $property, '/foo/bar');
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

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testVisitDateTimeValidate()
    {
        $validator = new Validator([
            new Field('/foo/bar', [function (DateTime $data) {
                return $data->format('d') == 8;
            }])
        ]);

        $property = Property::getDateTime();
        $visitor  = new TypeVisitor($validator);
        $visitor->visitDateTime('2002-10-10T17:00:00Z', $property, '/foo/bar');
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

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testVisitDateValidate()
    {
        $validator = new Validator([
            new Field('/foo/bar', [function (Date $data) {
                return $data->format('d') == 8;
            }])
        ]);

        $property = Property::getDate();
        $visitor  = new TypeVisitor($validator);
        $visitor->visitDate('2002-10-10', $property, '/foo/bar');
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

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testVisitDurationValidate()
    {
        $validator = new Validator([
            new Field('/foo/bar', [function (Duration $data) {
                return $data->d == 2;
            }])
        ]);

        $property = Property::getDuration();
        $visitor  = new TypeVisitor($validator);
        $visitor->visitDuration('P1D', $property, '/foo/bar');
    }

    public function testVisitNumber()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getNumber();

        $this->assertSame(1.1, $visitor->visitNumber(1.1, $property, ''));
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testVisitNumberValidate()
    {
        $validator = new Validator([
            new Field('/foo/bar', [function ($data) {
                return $data < 2.2;
            }])
        ]);

        $property = Property::getNumber();
        $visitor  = new TypeVisitor($validator);
        $visitor->visitNumber(12.34, $property, '/foo/bar');
    }

    public function testVisitInteger()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getInteger();

        $this->assertSame(1, $visitor->visitNumber(1, $property, ''));
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testVisitIntegerValidate()
    {
        $validator = new Validator([
            new Field('/foo/bar', [function ($data) {
                return $data < 2;
            }])
        ]);

        $property = Property::getInteger();
        $visitor  = new TypeVisitor($validator);
        $visitor->visitInteger(12, $property, '/foo/bar');
    }

    public function testVisitString()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getString();

        $this->assertSame('foo', $visitor->visitString('foo', $property, ''));
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /foo/bar has an invalid length min 8 and max 16 signs
     */
    public function testVisitStringValidate()
    {
        $validator = new Validator([
            new Field('/foo/bar', [new Filter\Length(8, 16)])
        ]);

        $property = Property::getString();
        $visitor  = new TypeVisitor($validator);
        $visitor->visitString('foo', $property, '/foo/bar');
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

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testVisitTimeValidate()
    {
        $validator = new Validator([
            new Field('/foo/bar', [function (Time $data) {
                return $data->format('H') == 11;
            }])
        ]);

        $property = Property::getTime();
        $visitor  = new TypeVisitor($validator);
        $visitor->visitTime('10:00:00', $property, '/foo/bar');
    }

    public function testVisitUri()
    {
        $visitor  = new TypeVisitor();
        $property = Property::getUri();

        $this->assertInstanceOf('PSX\Uri\Uri', $visitor->visitUri('/foo', $property, ''));
        $this->assertInstanceOf('PSX\Uri\Uri', $visitor->visitUri('http://foo.com?foo=bar', $property, ''));
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testVisitUriValidate()
    {
        $validator = new Validator([
            new Field('/foo/bar', [function (Uri $data) {
                return $data->getAuthority() == 'bar.com';
            }])
        ]);

        $property = Property::getUri();
        $visitor  = new TypeVisitor($validator);
        $visitor->visitUri('http://foo.com?foo=bar', $property, '/foo/bar');
    }
}
