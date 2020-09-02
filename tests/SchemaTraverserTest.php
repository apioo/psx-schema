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

use PSX\Schema\SchemaTraverser;
use PSX\Schema\Tests\Parser\Popo\Form_Container;
use PSX\Schema\Tests\Parser\Popo\Form_Element_Input;
use PSX\Schema\ValidationException;
use PSX\Schema\Visitor\IncomingVisitor;
use PSX\Schema\Visitor\OutgoingVisitor;
use PSX\Schema\Visitor\TypeVisitor;

/**
 * SchemaTraverserTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaTraverserTest extends SchemaTestCase
{
    public function testTraverse()
    {
        $traverser = new SchemaTraverser();
        $result    = $traverser->traverse($this->getData(), $this->getSchema());

        $actual = json_encode($result, JSON_PRETTY_PRINT);
        $expect = $this->getExpectedJson();

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testTraverseNoConstraints()
    {
        $traverser = new SchemaTraverser(false);
        $result    = $traverser->traverse($this->getData(), $this->getSchema());

        $actual = json_encode($result, JSON_PRETTY_PRINT);
        $expect = $this->getExpectedJson();

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testTraverseNoConstraintsAllowInvalidValue()
    {
        $data = $this->getData();
        $data->config->test = ['foo'];

        $traverser = new SchemaTraverser(false);
        $result    = $traverser->traverse($data, $this->getSchema());

        $actual = json_encode($result, JSON_PRETTY_PRINT);
        $expect = json_encode($data);

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testInvalidAdditionalPropertyType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/config/test must be of type string');

        $data = $this->getData();
        $data->config->test = ['foo'];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidMaxArrayItems()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/tags must contain less or equal than 6 items');

        $data = $this->getData();
        for ($i = 0; $i < 5; $i++) {
            $data->tags[] = 'tag-' . $i;
        }

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidMinArrayItems()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/tags must contain more or equal than 1 items');

        $data = $this->getData();
        $data->tags = [];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidMaxObjectItems()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/config must contain less or equal than 6 properties');

        $data = $this->getData();
        for ($i = 0; $i < 6; $i++) {
            $data->config->{$i . '-foo'} = 'foo-' . $i;
        }

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidMinObjectItems()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/config must contain more or equal than 1 properties');

        $data = $this->getData();
        $data->config = (object) [
        ];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidArrayPrototypeType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/receiver/1 must be of type object');

        $data = $this->getData();
        $data->receiver[] = 'foo';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidArrayPrototypeChoiceType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/resources/3 must match one required schema');

        $data = $this->getData();
        $data->resources[] = [
            'baz' => 'foo'
        ];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidBinary()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/profileImage must be a valid Base64 encoded string [RFC4648]');

        $data = $this->getData();
        $data->profileImage = 'foo';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidMinFloat()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/price must be greater or equal than 1');

        $data = $this->getData();
        $data->price = 0;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidMaxFloat()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/price must be lower or equal than 100');

        $data = $this->getData();
        $data->price = 101;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidMinInteger()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/rating must be greater or equal than 1');

        $data = $this->getData();
        $data->rating = 0;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidMaxInteger()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/rating must be lower or equal than 5');

        $data = $this->getData();
        $data->rating = 6;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidMinString()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/content must contain more or equal than 3 characters');

        $data = $this->getData();
        $data->content = 'a';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidMaxString()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/content must contain less or equal than 512 characters');

        $data = $this->getData();
        $data->content = str_repeat('a', 513);

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidEnumeration()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/question is not in enumeration ["foo","bar"]');

        $data = $this->getData();
        $data->question = 'baz';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidConst()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/version must contain the constant value "http:\/\/foo.bar"');

        $data = $this->getData();
        $data->version = 'baz';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidPattern()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/author/title does not match pattern [[A-z]{3,16}]');

        $data = $this->getData();
        $data->author->title = '1234';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidMapProperty()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/meta/tags_0 must be of type string');

        $data = $this->getData();
        $data->meta->tags_0 = ['foo'];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testTraverseDiscriminator()
    {
        $schema = $this->schemaManager->getSchema(Form_Container::class);
        $data = <<<JSON
{
    "elements": [{
        "element": "http://fusio-project.org/ns/2015/form/input"
    },{
        "element": "http://fusio-project.org/ns/2015/form/textarea"
    }]
}
JSON;

        $traverser = new SchemaTraverser();
        $result = $traverser->traverse(\json_decode($data), $schema);

        $actual = json_encode($result, JSON_PRETTY_PRINT);

        $this->assertJsonStringEqualsJsonString($data, $actual, $actual);
    }

    public function testTraverseDiscriminatorInvalidType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/elements/0 discriminated union provided type "foo" not available, use one of http://fusio-project.org/ns/2015/form/input, http://fusio-project.org/ns/2015/form/select, http://fusio-project.org/ns/2015/form/tag, http://fusio-project.org/ns/2015/form/textarea');

        $schema = $this->schemaManager->getSchema(Form_Container::class);
        $data = <<<JSON
{
    "elements": [{
        "element": "foo"
    },{
        "element": "http://fusio-project.org/ns/2015/form/textarea"
    }]
}
JSON;

        $traverser = new SchemaTraverser();
        $traverser->traverse(\json_decode($data), $schema);
    }

    public function testTraverseDiscriminatorInvalidDataType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/elements/0 discriminated union provided value must be an object');

        $schema = $this->schemaManager->getSchema(Form_Container::class);
        $data = <<<JSON
{
    "elements": ["foo"]
}
JSON;

        $traverser = new SchemaTraverser();
        $traverser->traverse(\json_decode($data), $schema);
    }

    public function testTraverseDiscriminatorNoType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('/elements/0 discriminated union object must have the property "element"');

        $schema = $this->schemaManager->getSchema(Form_Container::class);
        $data = <<<JSON
{
    "elements": [{
        "foo": "http://fusio-project.org/ns/2015/form/textarea"
    }]
}
JSON;

        $traverser = new SchemaTraverser();
        $traverser->traverse(\json_decode($data), $schema);
    }

    public function testTraverseExtends()
    {
        $schema = $this->schemaManager->getSchema(Form_Element_Input::class);
        $data = <<<JSON
{
    "element": "text",
    "name": "foo",
    "type": "bar",
    "parent": {
        "element": "form",
        "name": "bar",
        "type": "foo"
    }
}
JSON;

        $traverser = new SchemaTraverser();
        /** @var Form_Element_Input $result */
        $result = $traverser->traverse(\json_decode($data), $schema, new TypeVisitor());

        $this->assertInstanceOf(Form_Element_Input::class, $result);
        $this->assertEquals('text', $result->getElement());
        $this->assertEquals('foo', $result->getName());
        $this->assertEquals('bar', $result->getType());
        $this->assertInstanceOf(Form_Element_Input::class, $result->getParent());
        $this->assertEquals('form', $result->getParent()->getElement());
        $this->assertEquals('bar', $result->getParent()->getName());
        $this->assertEquals('foo', $result->getParent()->getType());
    }

    protected function getData()
    {
        return json_decode(file_get_contents(__DIR__ . '/SchemaTraverser/expected.json'));
    }

    protected function getExpectedJson()
    {
        return file_get_contents(__DIR__ . '/SchemaTraverser/expected.json');
    }
}
