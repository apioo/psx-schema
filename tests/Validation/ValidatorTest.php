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

namespace PSX\Schema\Tests\Validation;

use PHPUnit\Framework\TestCase;
use PSX\Schema\Exception\ValidationException;
use PSX\Schema\Validation\Field;
use PSX\Schema\Validation\Validator;
use PSX\Schema\Validation\ValidatorInterface;
use PSX\Validate\Filter;

/**
 * ValidatorTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ValidatorTest extends TestCase
{
    public function testValidate()
    {
        $validator = $this->getValidator();
        $validator->validate('/id', 2);

        $this->assertInstanceOf(ValidatorInterface::class, $validator);
    }

    public function testValidateInvalid()
    {
        $this->expectException(ValidationException::class);

        $validator = $this->getValidator();
        $validator->validate('/id', 4);
    }

    public function testValidateUnknown()
    {
        $validator = $this->getValidator();
        $validator->validate('/foo', 4);

        $this->assertInstanceOf(ValidatorInterface::class, $validator);
    }

    public function testGetFields()
    {
        $fields    = [new Field('id', [new Filter\Length(1, 2)])];
        $validator = new Validator($fields);

        $this->assertEquals($fields, $validator->getFields());
    }

    public function testValidateExceptionValues()
    {
        try {
            $validator = $this->getValidator();
            $validator->validate('/author/name', 'foooo');

            $this->fail('Validator must throw an exception');
        } catch (ValidationException $e) {
            $this->assertEquals('/author/name has an invalid length min 1 and max 2 signs', $e->getMessage());
            $this->assertEquals('filter', $e->getKeyword());
            $this->assertEquals(['author', 'name'], $e->getPath());
        }
    }

    protected function getValidator()
    {
        $fields = [
            new Field('id', [new Filter\Length(1, 2)]),
            new Field('title', [new Filter\Length(1, 2)]),
            new Field('author/name', [new Filter\Length(1, 2)]),
        ];

        return new Validator($fields);
    }
}
