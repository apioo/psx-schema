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

namespace PSX\Schema\Tests\Visitor;

use PHPUnit\Framework\TestCase;
use PSX\DateTime\Date;
use PSX\DateTime\DateTime;
use PSX\DateTime\Duration;
use PSX\DateTime\Time;
use PSX\Record\RecordInterface;
use PSX\Schema\Exception\ValidationException;
use PSX\Schema\Tests\Visitor\TypeVisitor\ArrayAccessClass;
use PSX\Schema\Tests\Visitor\TypeVisitor\PopoClass;
use PSX\Schema\Tests\Visitor\TypeVisitor\RecordClass;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\TypeFactory;
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
class TypeVisitorTest extends TestCase
{
    public function testVisitArray()
    {
        $type = TypeFactory::getArray();
        $data = (new TypeVisitor())->visitArray([10], $type, '');

        $this->assertIsArray($data);
        $this->assertSame([10], $data);
    }

    public function testVisitArrayValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function (array $data) {
                return count($data) < 2;
            }])
        ]);

        $type = TypeFactory::getArray();

        (new TypeVisitor($validator))->visitArray([10, 8, 6], $type, '/foo/bar');
    }

    public function testVisitBinary()
    {
        $type = TypeFactory::getBinary();
        $data = (new TypeVisitor())->visitBinary(base64_encode('foo'), $type, '');

        $this->assertIsResource($data);
        $this->assertSame('foo', stream_get_contents($data));
    }

    public function testVisitBinaryValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function ($data) {
                return fstat($data)['size'] < 2;
            }])
        ]);

        $type = TypeFactory::getBinary();

        (new TypeVisitor($validator))->visitBinary(base64_encode('foo'), $type, '/foo/bar');
    }

    public function testVisitBoolean()
    {
        $type = TypeFactory::getBoolean();

        $this->assertSame(true, (new TypeVisitor())->visitBoolean(true, $type, ''));
    }

    public function testVisitBooleanValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function ($data) {
                return $data === true;
            }])
        ]);

        $type = TypeFactory::getBoolean();

        (new TypeVisitor($validator))->visitBoolean(false, $type, '/foo/bar');
    }

    public function testVisitStruct()
    {
        $type = TypeFactory::getStruct()
            ->setAttribute(TypeAbstract::ATTR_CLASS, PopoClass::class)
            ->addProperty('foo', TypeFactory::getString())
            ->addProperty('bar', TypeFactory::getString());

        // popo class
        $type->setAttribute(TypeAbstract::ATTR_CLASS, PopoClass::class);

        $record = (new TypeVisitor())->visitStruct((object) ['foo' => 'bar', 'bar' => 'foo'], $type, '');

        $this->assertInstanceOf(PopoClass::class, $record);
        $this->assertEquals('bar', $record->getFoo());
        $this->assertEquals('foo', $record->getBar());
    }

    public function testVisitStructMapping()
    {
        $type = TypeFactory::getStruct()
            ->setAttribute(TypeAbstract::ATTR_CLASS, PopoClass::class)
            ->setAttribute(TypeAbstract::ATTR_MAPPING, ['my-custom-prop' => 'bar'])
            ->addProperty('foo', TypeFactory::getString())
            ->addProperty('bar', TypeFactory::getString());

        // popo class
        $type->setAttribute(TypeAbstract::ATTR_CLASS, PopoClass::class);

        $record = (new TypeVisitor())->visitStruct((object) ['foo' => 'bar', 'my-custom-prop' => 'foo'], $type, '');

        $this->assertInstanceOf(PopoClass::class, $record);
        $this->assertEquals('bar', $record->getFoo());
        $this->assertEquals('foo', $record->getBar());
    }

    public function testVisitStructValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function (RecordInterface $data) {
                return isset($data->foo);
            }])
        ]);

        $type = TypeFactory::getStruct();

        (new TypeVisitor($validator))->visitStruct((object) ['bar' => 'foo'], $type, '/foo/bar');
    }

    public function testVisitStructValidatePopo()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function (PopoClass $data) {
                return $data->getFoo() == 'foo';
            }])
        ]);

        $type = TypeFactory::getStruct();
        $type->setAttribute(TypeAbstract::ATTR_CLASS, PopoClass::class);

        (new TypeVisitor($validator))->visitStruct((object) ['foo' => 'bar', 'bar' => 'foo'], $type, '/foo/bar');
    }

    public function testVisitMap()
    {
        $type = TypeFactory::getMap()
            ->setAttribute(TypeAbstract::ATTR_CLASS, ArrayAccessClass::class)
            ->setAdditionalProperties(TypeFactory::getString());

        // array access class
        $record = (new TypeVisitor())->visitMap((object) ['foo' => 'bar', 'bar' => 'foo'], $type, '');

        $this->assertInstanceOf(ArrayAccessClass::class, $record);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $record->getArrayCopy());

        // record class
        $type->setAttribute(TypeAbstract::ATTR_CLASS, RecordClass::class);

        $record = (new TypeVisitor())->visitMap((object) ['foo' => 'bar', 'bar' => 'foo'], $type, '');

        $this->assertInstanceOf(RecordClass::class, $record);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $record->getProperties());
    }

    public function testVisitDateTime()
    {
        $type = TypeFactory::getDateTime();

        $this->assertInstanceOf('DateTime', (new TypeVisitor())->visitDateTime('2002-10-10T17:00:00Z', $type, ''));
        $this->assertInstanceOf('DateTime', (new TypeVisitor())->visitDateTime('2002-10-10T17:00:00+01:00', $type, ''));
    }

    public function testVisitDateTimeInvalidFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Must be valid date time format');

        $type = TypeFactory::getDateTime();

        (new TypeVisitor())->visitDateTime('foo', $type, '');
    }

    public function testVisitDateTimeValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function (DateTime $data) {
                return $data->format('d') == 8;
            }])
        ]);

        $type = TypeFactory::getDateTime();

        (new TypeVisitor($validator))->visitDateTime('2002-10-10T17:00:00Z', $type, '/foo/bar');
    }

    public function testVisitDate()
    {
        $type = TypeFactory::getDate();

        $this->assertInstanceOf(Date::class, (new TypeVisitor())->visitDate('2000-01-01', $type, ''));
        $this->assertInstanceOf(Date::class, (new TypeVisitor())->visitDate('2000-01-01+13:00', $type, ''));
    }

    public function testVisitDateInvalidFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Must be valid date format');

        $type = TypeFactory::getDate();

        (new TypeVisitor())->visitDate('foo', $type, '');
    }

    public function testVisitDateValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function (Date $data) {
                return $data->format('d') == 8;
            }])
        ]);

        $type = TypeFactory::getDate();

        (new TypeVisitor($validator))->visitDate('2002-10-10', $type, '/foo/bar');
    }

    public function testVisitDuration()
    {
        $type = TypeFactory::getDuration();

        $this->assertInstanceOf(Duration::class, (new TypeVisitor())->visitDuration('P1D', $type, ''));
        $this->assertInstanceOf(Duration::class, (new TypeVisitor())->visitDuration('P1DT12H', $type, ''));
    }

    public function testVisitDurationInvalidFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Must be duration forma');

        $type = TypeFactory::getDuration();

        (new TypeVisitor())->visitDuration('foo', $type, '');
    }

    public function testVisitDurationValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function (Duration $data) {
                return $data->d == 2;
            }])
        ]);

        $type = TypeFactory::getDuration();

        (new TypeVisitor($validator))->visitDuration('P1D', $type, '/foo/bar');
    }

    public function testVisitNumber()
    {
        $type = TypeFactory::getNumber();

        $this->assertSame(1.1, (new TypeVisitor())->visitNumber(1.1, $type, ''));
    }

    public function testVisitNumberValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function ($data) {
                return $data < 2.2;
            }])
        ]);

        $type = TypeFactory::getNumber();

        (new TypeVisitor($validator))->visitNumber(12.34, $type, '/foo/bar');
    }

    public function testVisitInteger()
    {
        $type = TypeFactory::getInteger();

        $this->assertSame(1, (new TypeVisitor())->visitNumber(1, $type, ''));
    }

    public function testVisitIntegerValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function ($data) {
                return $data < 2;
            }])
        ]);

        $type = TypeFactory::getInteger();

        (new TypeVisitor($validator))->visitInteger(12, $type, '/foo/bar');
    }

    public function testVisitString()
    {
        $type = TypeFactory::getString();

        $this->assertSame('foo', (new TypeVisitor())->visitString('foo', $type, ''));
    }

    public function testVisitStringValidate()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/foo/bar has an invalid length min 8 and max 16 signs');

        $validator = new Validator([
            new Field('/foo/bar', [new Filter\Length(8, 16)])
        ]);

        $type = TypeFactory::getString();

        (new TypeVisitor($validator))->visitString('foo', $type, '/foo/bar');
    }

    public function testVisitTime()
    {
        $type = TypeFactory::getTime();

        $this->assertInstanceOf(Time::class, (new TypeVisitor())->visitTime('10:00:00', $type, ''));
        $this->assertInstanceOf(Time::class, (new TypeVisitor())->visitTime('10:00:00+02:00', $type, ''));
    }

    public function testVisitTimeInvalidFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Must be valid time format');

        $type = TypeFactory::getTime();

        (new TypeVisitor())->visitTime('foo', $type, '');
    }

    public function testVisitTimeValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function (Time $data) {
                return $data->format('H') == 11;
            }])
        ]);

        $type = TypeFactory::getTime();

        (new TypeVisitor($validator))->visitTime('10:00:00', $type, '/foo/bar');
    }

    public function testVisitUri()
    {
        $type = TypeFactory::getUri();

        $this->assertInstanceOf(Uri::class, (new TypeVisitor())->visitUri('/foo', $type, ''));
        $this->assertInstanceOf(Uri::class, (new TypeVisitor())->visitUri('http://foo.com?foo=bar', $type, ''));
    }

    public function testVisitUriValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function (Uri $data) {
                return $data->getAuthority() == 'bar.com';
            }])
        ]);

        $type = TypeFactory::getUri();

        (new TypeVisitor($validator))->visitUri('http://foo.com?foo=bar', $type, '/foo/bar');
    }
}
