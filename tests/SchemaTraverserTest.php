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

namespace PSX\Schema\Tests;

use PSX\Schema\Exception\TraverserException;
use PSX\Schema\SchemaTraverser;
use PSX\Schema\Tests\Parser\Popo\ArrayList;
use PSX\Schema\Tests\Parser\Popo\Form_Container;
use PSX\Schema\Tests\Parser\Popo\Form_Element_Input;
use PSX\Schema\Tests\Parser\Popo\HashMap;
use PSX\Schema\Visitor\TypeVisitor;

/**
 * SchemaTraverserTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
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

        // we expect that the value from test gets converted to null since array is invalid and only strings are allows
        $data->config->test = null;

        $actual = json_encode($result, JSON_PRETTY_PRINT);
        $expect = json_encode($data);

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testInvalidAdditionalPropertyType()
    {
        $this->expectException(TraverserException::class);
        $this->expectExceptionMessage('/config/test must be of type string');

        $data = $this->getData();
        $data->config->test = ['foo'];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidArrayPrototypeType()
    {
        $this->expectException(TraverserException::class);
        $this->expectExceptionMessage('/receiver/1 must be of type object');

        $data = $this->getData();
        $data->receiver[] = 'foo';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testInvalidMapProperty()
    {
        $this->expectException(TraverserException::class);
        $this->expectExceptionMessage('/meta/tags_0 must be of type string');

        $data = $this->getData();
        $data->meta->tags_0 = ['foo'];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testTraverseNullable()
    {
        $this->expectException(TraverserException::class);
        $this->expectExceptionMessage('/content must not be null');

        $data = $this->getData();
        $data->content = null;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testTraverseNullableNested()
    {
        $this->expectException(TraverserException::class);
        $this->expectExceptionMessage('/author/title must not be null');

        $data = $this->getData();
        $data->author->title = null;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testTraverseNullableObject()
    {
        $this->expectException(TraverserException::class);
        $this->expectExceptionMessage('/content must not be null');

        $data = $this->getData();
        $data->content = null;

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
        $this->expectException(TraverserException::class);
        $this->expectExceptionMessage('Provided discriminator type is invalid, possible values are: http://fusio-project.org/ns/2015/form/input, http://fusio-project.org/ns/2015/form/select, http://fusio-project.org/ns/2015/form/tag, http://fusio-project.org/ns/2015/form/textarea');

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
        $this->expectException(TraverserException::class);
        $this->expectExceptionMessage('/elements/0 must be of type object');

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
        $this->expectException(TraverserException::class);
        $this->expectExceptionMessage('Configured discriminator property "element" is invalid');

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
        if (PHP_VERSION_ID < 80000) {
            $this->markTestSkipped('Works only at PHP 8.0');
        }

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

    public function testTraverseUnknownProperties()
    {
        $this->expectException(TraverserException::class);
        $this->expectExceptionMessage('/ property "foo" is unknown');

        $schema = $this->schemaManager->getSchema(Form_Element_Input::class);
        $data = <<<JSON
{
    "element": "text",
    "name": "foo",
    "type": "bar",
    "foo": "bar"
}
JSON;

        $traverser = new SchemaTraverser(ignoreUnknown: false);
        $traverser->traverse(\json_decode($data), $schema, new TypeVisitor());
    }

    public function testTraverseArray()
    {
        $schema = $this->schemaManager->getSchema(ArrayList::class);
        $data = <<<JSON
[
  "foo",
  "bar"
]
JSON;

        $traverser = new SchemaTraverser();
        $result = $traverser->traverse(\json_decode($data), $schema, new TypeVisitor());

        $actual = json_encode($result, JSON_PRETTY_PRINT);

        $this->assertJsonStringEqualsJsonString($data, $actual, $actual);
    }

    public function testTraverseMap()
    {
        $schema = $this->schemaManager->getSchema(HashMap::class);
        $data = <<<JSON
{
  "foo": "foo",
  "bar": "bar"
}
JSON;

        $traverser = new SchemaTraverser();
        $result = $traverser->traverse(\json_decode($data), $schema, new TypeVisitor());

        $actual = json_encode($result, JSON_PRETTY_PRINT);

        $this->assertJsonStringEqualsJsonString($data, $actual, $actual);
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
