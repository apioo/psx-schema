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

namespace PSX\Schema\Tests;

use Doctrine\Common\Annotations\SimpleAnnotationReader;
use PSX\Data\Record\Transformer;
use PSX\Schema\Parser;
use PSX\Schema\SchemaTraverser;
use PSX\Schema\Tests\SchemaTraverser\RecursionModel;
use PSX\Schema\Visitor\OutgoingVisitor;
use PSX\Schema\Visitor\IncomingVisitor;

/**
 * SchemaTraverserTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaTraverserTest extends SchemaTestCase
{
    public function testNormalIncoming()
    {
        $traverser = new SchemaTraverser();
        $result    = $traverser->traverse($this->getData(), $this->getSchema(), new IncomingVisitor());

        $this->assertInstanceOf('PSX\Record\RecordInterface', $result);

        // the incoming visitior transforms binary types to resources. Because
        // of this we cant json_encode the result directly therefor we use the
        // outgoing visitor
        $result = $traverser->traverse($result, $this->getSchema(), new OutgoingVisitor());

        $this->assertInstanceOf('PSX\Record\RecordInterface', $result);

        $actual = json_encode($result, JSON_PRETTY_PRINT);
        $expect = $this->getExpectedJson();

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testNormalOutgoing()
    {
        $traverser = new SchemaTraverser();
        $result    = $traverser->traverse($this->getData(), $this->getSchema(), new OutgoingVisitor());

        $this->assertInstanceOf('PSX\Record\RecordInterface', $result);

        $actual = json_encode($result, JSON_PRETTY_PRINT);
        $expect = $this->getExpectedJson();

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /config/test must be a string
     */
    public function testInvalidAdditionalPropertyType()
    {
        $data = $this->getData();
        $data['config']['test'] = ['foo'];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /tags must contain less or equal then 6 items
     */
    public function testInvalidMaxArrayItems()
    {
        $data = $this->getData();
        for ($i = 0; $i < 5; $i++) {
            $data['tags'][] = 'tag-' . $i;
        }

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /tags must contain more or equal then 1 items
     */
    public function testInvalidMinArrayItems()
    {
        $data = $this->getData();
        $data['tags'] = [];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /resources/1 must contain less or equal then 8 properties
     */
    public function testInvalidMaxObjectItems()
    {
        $data = $this->getData();
        for ($i = 0; $i < 6; $i++) {
            $data['resources'][1][$i . '-foo'] = 'foo-' . $i;
        }

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /resources/1 must contain more or equal then 2 properties
     */
    public function testInvalidMinObjectItems()
    {
        $data = $this->getData();
        $data['resources'][1] = [
            'name' => 'foo'
        ];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /receiver/1 must be an object
     */
    public function testInvalidArrayPrototypeType()
    {
        $data = $this->getData();
        $data['receiver'][] = 'foo';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /resources/3 must be one of the following types (location, web)
     */
    public function testInvalidArrayPrototypeChoiceType()
    {
        $data = $this->getData();
        $data['resources'][] = [
            'baz' => 'foo'
        ];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /profileImage must be a valid Base64 encoded string [RFC4648]
     */
    public function testInvalidBinary()
    {
        $data = $this->getData();
        $data['profileImage'] = 'foo';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /price must be greater or equal then 1
     */
    public function testInvalidMinFloat()
    {
        $data = $this->getData();
        $data['price'] = 0;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /price must be lower or equal then 100
     */
    public function testInvalidMaxFloat()
    {
        $data = $this->getData();
        $data['price'] = 101;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /rating must be greater or equal then 1
     */
    public function testInvalidMinInteger()
    {
        $data = $this->getData();
        $data['rating'] = 0;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /rating must be lower or equal then 5
     */
    public function testInvalidMaxInteger()
    {
        $data = $this->getData();
        $data['rating'] = 6;

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /content must contain more or equal then 3 characters
     */
    public function testInvalidMinString()
    {
        $data = $this->getData();
        $data['content'] = 'a';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /content must contain less or equal then 512 characters
     */
    public function testInvalidMaxString()
    {
        $data = $this->getData();
        $data['content'] = str_repeat('a', 513);

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /question is not in enumeration [foo, bar]
     */
    public function testInvalidEnumeration()
    {
        $data = $this->getData();
        $data['question'] = 'baz';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /author/title does not match pattern [[A-z]{3,16}]
     */
    public function testInvalidPattern()
    {
        $data = $this->getData();
        $data['author']['title'] = '1234';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /meta property "foo_0" does not exist
     */
    public function testInvalidAdditionalPatternProperties()
    {
        $data = $this->getData();
        $data['meta']['foo_0'] = 'foo';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /meta/tags_0 must be a string
     */
    public function testInvalidatternPropertiesTags()
    {
        $data = $this->getData();
        $data['meta']['tags_0'] = ['foo'];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     * @expectedExceptionMessage /meta/location_0 must be an object
     */
    public function testInvalidatternPropertiesLocation()
    {
        $data = $this->getData();
        $data['meta']['location_0'] = 'foo';

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $this->getSchema(), new IncomingVisitor());
    }

    public function testRecursion()
    {
        $parser = new Parser\Popo($this->reader);
        $schema = $parser->parse(RecursionModel::class);

        $data = [
            'title' => 'level1',
            'model' => [
                'title' => 'level2',
                'model' => [
                    'title' => 'level3',
                    'model' => [
                        'title' => 'level4',
                        'model' => [
                            'title' => 'level5',
                            'model' => [
                                'title' => 'level6',
                                'model' => [
                                    'title' => 'level7',
                                    'model' => [
                                        'title' => 'level8'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $traverser = new SchemaTraverser();
        $result    = $traverser->traverse($data, $schema, new OutgoingVisitor());

        $this->assertEquals('level1', $result->title);
        $this->assertEquals('level2', $result->model->title);
        $this->assertEquals('level3', $result->model->model->title);
        $this->assertEquals('level4', $result->model->model->model->title);
        $this->assertEquals('level5', $result->model->model->model->model->title);
        $this->assertEquals('level6', $result->model->model->model->model->model->title);
        $this->assertEquals('level7', $result->model->model->model->model->model->model->title);
        $this->assertEquals('level8', $result->model->model->model->model->model->model->model->title);
        $this->assertEquals(null, $result->model->model->model->model->model->model->model->model);
    }

    /**
     * @expectedException \PSX\Schema\ValidationException
     */
    public function testMaxRecursion()
    {
        $parser = new Parser\Popo($this->reader);
        $schema = $parser->parse(RecursionModel::class);

        $data = [
            'title' => 'level1',
            'model' => [
                'title' => 'level2',
                'model' => [
                    'title' => 'level3',
                    'model' => [
                        'title' => 'level4',
                        'model' => [
                            'title' => 'level5',
                            'model' => [
                                'title' => 'level6',
                                'model' => [
                                    'title' => 'level7',
                                    'model' => [
                                        'title' => 'level8',
                                        'model' => [
                                            'title' => 'level9',
                                            'model' => [
                                                'title' => 'level10',
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $traverser = new SchemaTraverser();
        $traverser->traverse($data, $schema, new OutgoingVisitor());
    }
    
    protected function getData()
    {
        $location = [
            'lat' => 51.2984641,
            'long' => 6.9227502,
            // allows any additional properties
            'foo' => [
                'bar' => 'test'
            ],
            'bar' => 'foo'
        ];

        $web = [
            'name' => 'web',
            'url' => 'http://google.com',
            // allows additional string properties
            'foo' => 'foo',
        ];

        $author = [
            'title' => 'foo',
            'email' => 'foo@bar.com',
            'categories' => ['admin', 'user'],
            'locations' => [$location],
            'origin' => $location,
        ];

        $meta = [
            // pattern properties
            'tags_0' => 'foo',
            'tags_1' => 'bar',
            'location_0' => $location,
            'location_1' => $location,
        ];

        $resource = fopen('php://temp', 'r+');
        fwrite($resource, 'foobar');
        rewind($resource);

        return [
            'config' => [
                // allows additional string properties
                'foo' => 'bar',
                'bar' => 'bar',
            ],
            'tags' => ['foo', 'bar'],
            'receiver' => [$author],
            'resources' => [$location, $web, $location],
            'profileImage' => $resource,
            'read' => true,
            'source' => $author,
            'author' => $author,
            'meta' => $meta,
            'sendDate' => new \DateTime('2016-05-28T12:12:00'),
            'readDate' => new \DateTime('2016-05-28T12:12:00'),
            'expires' => new \DateInterval('P1D'),
            'price' => 20.45,
            'rating' => 2,
            'content' => 'lorem ipsum',
            'question' => 'foo',
            'coffeeTime' => new \DateTime('2016-05-28T12:12:00'),
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
    "readDate": "2016-05-28T12:12:00Z",
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