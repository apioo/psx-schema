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

namespace PSX\Schema\Tests\Visitor;

use PHPUnit\Framework\TestCase;
use PSX\DateTime\Duration;
use PSX\DateTime\LocalDate;
use PSX\DateTime\LocalDateTime;
use PSX\DateTime\LocalTime;
use PSX\DateTime\Period;
use PSX\Record\RecordInterface;
use PSX\Schema\Exception\ValidationException;
use PSX\Schema\Tests\Visitor\TypeVisitor\ArrayAccessClass;
use PSX\Schema\Tests\Visitor\TypeVisitor\PopoClass;
use PSX\Schema\Tests\Visitor\TypeVisitor\RecordClass;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\Factory\DefinitionTypeFactory;
use PSX\Schema\Type\Factory\PropertyTypeFactory;
use PSX\Schema\Type\PropertyTypeAbstract;
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
 * @link    https://phpsx.org
 */
class TypeVisitorTest extends TestCase
{
    public function testVisitArray()
    {
        $type = DefinitionTypeFactory::getArray();
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

        $type = DefinitionTypeFactory::getArray();

        (new TypeVisitor($validator))->visitArray([10, 8, 6], $type, '/foo/bar');
    }

    public function testVisitBoolean()
    {
        $type = PropertyTypeFactory::getBoolean();

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

        $type = PropertyTypeFactory::getBoolean();

        (new TypeVisitor($validator))->visitBoolean(false, $type, '/foo/bar');
    }

    public function testVisitStruct()
    {
        $type = DefinitionTypeFactory::getStruct()
            ->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, PopoClass::class)
            ->addProperty('foo', PropertyTypeFactory::getString())
            ->addProperty('bar', PropertyTypeFactory::getString());

        // popo class
        $type->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, PopoClass::class);

        $record = (new TypeVisitor())->visitStruct((object) ['foo' => 'bar', 'bar' => 'foo'], $type, '');

        $this->assertInstanceOf(PopoClass::class, $record);
        $this->assertEquals('bar', $record->getFoo());
        $this->assertEquals('foo', $record->getBar());
    }

    public function testVisitStructMapping()
    {
        $type = DefinitionTypeFactory::getStruct()
            ->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, PopoClass::class)
            ->setAttribute(DefinitionTypeAbstract::ATTR_MAPPING, ['my-custom-prop' => 'bar'])
            ->addProperty('foo', PropertyTypeFactory::getString())
            ->addProperty('bar', PropertyTypeFactory::getString());

        // popo class
        $type->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, PopoClass::class);

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

        $type = DefinitionTypeFactory::getStruct();

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

        $type = DefinitionTypeFactory::getStruct();
        $type->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, PopoClass::class);

        (new TypeVisitor($validator))->visitStruct((object) ['foo' => 'bar', 'bar' => 'foo'], $type, '/foo/bar');
    }

    public function testVisitMap()
    {
        $type = DefinitionTypeFactory::getMap()
            ->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, ArrayAccessClass::class)
            ->setSchema(PropertyTypeFactory::getString());

        // array access class
        $record = (new TypeVisitor())->visitMap((object) ['foo' => 'bar', 'bar' => 'foo'], $type, '');

        $this->assertInstanceOf(ArrayAccessClass::class, $record);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $record->getArrayCopy());

        // record class
        $type->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, RecordClass::class);

        $record = (new TypeVisitor())->visitMap((object) ['foo' => 'bar', 'bar' => 'foo'], $type, '');

        $this->assertInstanceOf(RecordClass::class, $record);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $record->getProperties());
    }

    public function testVisitDateTime()
    {
        $type = PropertyTypeFactory::getDateTime();

        $this->assertInstanceOf(LocalDateTime::class, (new TypeVisitor())->visitDateTime('2002-10-10T17:00:00Z', $type, ''));
        $this->assertInstanceOf(LocalDateTime::class, (new TypeVisitor())->visitDateTime('2002-10-10T17:00:00+01:00', $type, ''));
    }

    public function testVisitDateTimeInvalidFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Must be valid date time format');

        $type = PropertyTypeFactory::getDateTime();

        (new TypeVisitor())->visitDateTime('foo', $type, '');
    }

    public function testVisitDateTimeValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function (LocalDateTime $data) {
                return $data->getDayOfMonth() == 8;
            }])
        ]);

        $type = PropertyTypeFactory::getDateTime();

        (new TypeVisitor($validator))->visitDateTime('2002-10-10T17:00:00Z', $type, '/foo/bar');
    }

    public function testVisitDate()
    {
        $type = PropertyTypeFactory::getDate();

        $this->assertInstanceOf(LocalDate::class, (new TypeVisitor())->visitDate('2000-01-01', $type, ''));
        $this->assertInstanceOf(LocalDate::class, (new TypeVisitor())->visitDate('2000-01-01+13:00', $type, ''));
    }

    public function testVisitDateInvalidFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Must be valid date format');

        $type = PropertyTypeFactory::getDate();

        (new TypeVisitor())->visitDate('foo', $type, '');
    }

    public function testVisitDateValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function (LocalDate $data) {
                return $data->getDayOfMonth() == 8;
            }])
        ]);

        $type = PropertyTypeFactory::getDate();

        (new TypeVisitor($validator))->visitDate('2002-10-10', $type, '/foo/bar');
    }

    public function testVisitNumber()
    {
        $type = PropertyTypeFactory::getNumber();

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

        $type = PropertyTypeFactory::getNumber();

        (new TypeVisitor($validator))->visitNumber(12.34, $type, '/foo/bar');
    }

    public function testVisitInteger()
    {
        $type = PropertyTypeFactory::getInteger();

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

        $type = PropertyTypeFactory::getInteger();

        (new TypeVisitor($validator))->visitInteger(12, $type, '/foo/bar');
    }

    public function testVisitString()
    {
        $type = PropertyTypeFactory::getString();

        $this->assertSame('foo', (new TypeVisitor())->visitString('foo', $type, ''));
    }

    public function testVisitStringValidate()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/foo/bar has an invalid length min 8 and max 16 signs');

        $validator = new Validator([
            new Field('/foo/bar', [new Filter\Length(8, 16)])
        ]);

        $type = PropertyTypeFactory::getString();

        (new TypeVisitor($validator))->visitString('foo', $type, '/foo/bar');
    }

    public function testVisitTime()
    {
        $type = PropertyTypeFactory::getTime();

        $this->assertInstanceOf(LocalTime::class, (new TypeVisitor())->visitTime('10:00:00', $type, ''));
        $this->assertInstanceOf(LocalTime::class, (new TypeVisitor())->visitTime('10:00:00+02:00', $type, ''));
    }

    public function testVisitTimeInvalidFormat()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Must be valid time format');

        $type = PropertyTypeFactory::getTime();

        (new TypeVisitor())->visitTime('foo', $type, '');
    }

    public function testVisitTimeValidate()
    {
        $this->expectException(ValidationException::class);

        $validator = new Validator([
            new Field('/foo/bar', [function (LocalTime $data) {
                return $data->getHour() == 11;
            }])
        ]);

        $type = PropertyTypeFactory::getTime();

        (new TypeVisitor($validator))->visitTime('10:00:00', $type, '/foo/bar');
    }
}
