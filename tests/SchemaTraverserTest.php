<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Schema\Parser;
use PSX\Schema\SchemaTraverser;
use PSX\Schema\Tests\SchemaTraverser\RecursionModel;
use PSX\Schema\Visitor\IncomingVisitor;
use PSX\Schema\Visitor\OutgoingVisitor;

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

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /config/test must be of type string
     */
    public function testInvalidAdditionalPropertyType()
    {
        $data = $this->getData();
        $data->config->test = ['foo'];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /tags must contain less or equal than 6 items
     */
    public function testInvalidMaxArrayItems()
    {
        $data = $this->getData();
        for ($i = 0; $i < 5; $i++) {
            $data->tags[] = 'tag-' . $i;
        }

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /tags must contain more or equal than 1 items
     */
    public function testInvalidMinArrayItems()
    {
        $data = $this->getData();
        $data->tags = [];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /config must contain less or equal than 6 properties
     */
    public function testInvalidMaxObjectItems()
    {
        $data = $this->getData();
        for ($i = 0; $i < 6; $i++) {
            $data->config->{$i . '-foo'} = 'foo-' . $i;
        }

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /config must contain more or equal than 1 properties
     */
    public function testInvalidMinObjectItems()
    {
        $data = $this->getData();
        $data->config = (object) [
        ];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /receiver/1 must be of type object
     */
    public function testInvalidArrayPrototypeType()
    {
        $data = $this->getData();
        $data->receiver[] = 'foo';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /resources/3 must match one required schema
     */
    public function testInvalidArrayPrototypeChoiceType()
    {
        $data = $this->getData();
        $data->resources[] = [
            'baz' => 'foo'
        ];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /profileImage must be a valid Base64 encoded string [RFC4648]
     */
    public function testInvalidBinary()
    {
        $data = $this->getData();
        $data->profileImage = 'foo';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /price must be greater or equal than 1
     */
    public function testInvalidMinFloat()
    {
        $data = $this->getData();
        $data->price = 0;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /price must be lower or equal than 100
     */
    public function testInvalidMaxFloat()
    {
        $data = $this->getData();
        $data->price = 101;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /rating must be greater or equal than 1
     */
    public function testInvalidMinInteger()
    {
        $data = $this->getData();
        $data->rating = 0;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /rating must be lower or equal than 5
     */
    public function testInvalidMaxInteger()
    {
        $data = $this->getData();
        $data->rating = 6;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /content must contain more or equal than 3 characters
     */
    public function testInvalidMinString()
    {
        $data = $this->getData();
        $data->content = 'a';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /content must contain less or equal than 512 characters
     */
    public function testInvalidMaxString()
    {
        $data = $this->getData();
        $data->content = str_repeat('a', 513);

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /question is not in enumeration ["foo","bar"]
     */
    public function testInvalidEnumeration()
    {
        $data = $this->getData();
        $data->question = 'baz';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /version must contain the constant value "http:\/\/foo.bar"
     */
    public function testInvalidConst()
    {
        $data = $this->getData();
        $data->version = 'baz';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /author/title does not match pattern [[A-z]{3,16}]
     */
    public function testInvalidPattern()
    {
        $data = $this->getData();
        $data->author->title = '1234';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /meta/tags_0 must be of type string
     */
    public function testInvalidMapProperty()
    {
        $data = $this->getData();
        $data->meta->tags_0 = ['foo'];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
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
