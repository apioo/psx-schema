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
     * @expectedExceptionMessage /tags must contain less or equal then 6 items
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
     * @expectedExceptionMessage /tags must contain more or equal then 1 items
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
     * @expectedExceptionMessage /resources/1 must match one required schema
     */
    public function testInvalidMaxObjectItems()
    {
        $data = $this->getData();
        for ($i = 0; $i < 6; $i++) {
            $data->resources[1]->{$i . '-foo'} = 'foo-' . $i;
        }

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /resources/1 must match one required schema
     */
    public function testInvalidMinObjectItems()
    {
        $data = $this->getData();
        $data->resources[1] = [
            'name' => 'foo'
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
     * @expectedExceptionMessage /price must be greater or equal then 1
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
     * @expectedExceptionMessage /price must be lower or equal then 100
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
     * @expectedExceptionMessage /rating must be greater or equal then 1
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
     * @expectedExceptionMessage /rating must be lower or equal then 5
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
     * @expectedExceptionMessage /content must contain more or equal then 3 characters
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
     * @expectedExceptionMessage /content must contain less or equal then 512 characters
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
     * @expectedExceptionMessage /question is not in enum ["foo","bar"]
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
     * @expectedExceptionMessage /receiver/0/title does not match pattern [[A-z]{3,16}]
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
     * @expectedExceptionMessage /meta property "foo_0" is not allowed
     */
    public function testInvalidAdditionalPatternProperties()
    {
        $data = $this->getData();
        $data->meta->foo_0 = 'foo';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /meta/tags_0 must be of type string
     */
    public function testInvalidatternPropertiesTags()
    {
        $data = $this->getData();
        $data->meta->tags_0 = ['foo'];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /meta/location_0 must be of type object
     */
    public function testInvalidatternPropertiesLocation()
    {
        $data = $this->getData();
        $data->meta->location_0 = 'foo';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema());
    }

    public function testRecursion()
    {
        $parser = new Parser\Popo($this->reader);
        $schema = $parser->parse(RecursionModel::class);

        $data = $this->getRecData(16);

        $traverser = new SchemaTraverser();
        $result    = $traverser->traverse($data, $schema);

        $this->assertEquals('level1', $result->title);
        $this->assertEquals('level2', $result->model->title);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage /model/model/model/model/model/model/model/model/model/model/model/model/model/model/model/model/title max recursion depth reached
     */
    public function testMaxRecursion()
    {
        $parser = new Parser\Popo($this->reader);
        $schema = $parser->parse(RecursionModel::class);

        $data = $this->getRecData(17);

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $schema);
    }

    protected function getRecData($maxDepth, $depth = 1)
    {
        if ($depth > $maxDepth) {
            return null;
        }

        $data  = ['title' => 'level' . $depth];
        $model = $this->getRecData($maxDepth, $depth + 1);
        if ($model !== null) {
            $data['model'] = $model;
        }

        return (object) $data;
    }

    protected function getData()
    {
        $location = (object) [
            'lat' => 51.2984641,
            'long' => 6.9227502,
            // allows any additional properties
            'foo' => [
                'bar' => 'test'
            ],
            'bar' => 'foo'
        ];

        $web = (object) [
            'name' => 'web',
            'url' => 'http://google.com',
            // allows additional string properties
            'foo' => 'foo',
        ];

        $author = (object) [
            'title' => 'foo',
            'email' => 'foo@bar.com',
            'categories' => ['admin', 'user'],
            'locations' => [$location],
            'origin' => $location,
        ];

        $meta = (object) [
            // pattern properties
            'tags_0' => 'foo',
            'tags_1' => 'bar',
            'location_0' => $location,
            'location_1' => $location,
        ];

        return (object) [
            'config' => (object) [
                // allows additional string properties
                'foo' => 'bar',
                'bar' => 'bar',
            ],
            'tags' => ['foo', 'bar'],
            'receiver' => [$author],
            'resources' => [$location, $web, $location],
            'profileImage' => base64_encode('foobar'),
            'read' => true,
            'source' => $author,
            'author' => $author,
            'meta' => $meta,
            'sendDate' => '2016-05-28',
            'readDate' => '2016-05-28T12:12:00',
            'expires' => 'P1D',
            'price' => 20.45,
            'rating' => 2,
            'content' => 'lorem ipsum',
            'question' => 'foo',
            'coffeeTime' => '12:12:00',
            'profileUri' => 'urn:news:1',
        ];
    }

    protected function getExpectedJson()
    {
        return <<<JSON
{
    "config": {
        "foo": "bar",
        "bar": "bar"
    },
    "tags": [
        "foo",
        "bar"
    ],
    "receiver": [
        {
            "title": "foo",
            "email": "foo@bar.com",
            "categories": [
                "admin",
                "user"
            ],
            "locations": [
                {
                    "lat": 51.2984641,
                    "long": 6.9227502,
                    "foo": {
                        "bar": "test"
                    },
                    "bar": "foo"
                }
            ],
            "origin": {
                "lat": 51.2984641,
                "long": 6.9227502,
                "foo": {
                    "bar": "test"
                },
                "bar": "foo"
            }
        }
    ],
    "resources": [
        {
            "lat": 51.2984641,
            "long": 6.9227502,
            "foo": {
                "bar": "test"
            },
            "bar": "foo"
        },
        {
            "name": "web",
            "url": "http:\/\/google.com",
            "foo": "foo"
        },
        {
            "lat": 51.2984641,
            "long": 6.9227502,
            "foo": {
                "bar": "test"
            },
            "bar": "foo"
        }
    ],
    "profileImage": "Zm9vYmFy",
    "read": true,
    "source": {
        "title": "foo",
        "email": "foo@bar.com",
        "categories": [
            "admin",
            "user"
        ],
        "locations": [
            {
                "lat": 51.2984641,
                "long": 6.9227502,
                "foo": {
                    "bar": "test"
                },
                "bar": "foo"
            }
        ],
        "origin": {
            "lat": 51.2984641,
            "long": 6.9227502,
            "foo": {
                "bar": "test"
            },
            "bar": "foo"
        }
    },
    "author": {
        "title": "foo",
        "email": "foo@bar.com",
        "categories": [
            "admin",
            "user"
        ],
        "locations": [
            {
                "lat": 51.2984641,
                "long": 6.9227502,
                "foo": {
                    "bar": "test"
                },
                "bar": "foo"
            }
        ],
        "origin": {
            "lat": 51.2984641,
            "long": 6.9227502,
            "foo": {
                "bar": "test"
            },
            "bar": "foo"
        }
    },
    "meta": {
        "tags_0": "foo",
        "tags_1": "bar",
        "location_0": {
            "lat": 51.2984641,
            "long": 6.9227502,
            "foo": {
                "bar": "test"
            },
            "bar": "foo"
        },
        "location_1": {
            "lat": 51.2984641,
            "long": 6.9227502,
            "foo": {
                "bar": "test"
            },
            "bar": "foo"
        }
    },
    "sendDate": "2016-05-28",
    "readDate": "2016-05-28T12:12:00",
    "expires": "P1D",
    "price": 20.45,
    "rating": 2,
    "content": "lorem ipsum",
    "question": "foo",
    "coffeeTime": "12:12:00",
    "profileUri": "urn:news:1"
}
JSON;
    }
}
