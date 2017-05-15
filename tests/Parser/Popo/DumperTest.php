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

namespace PSX\Schema\Tests\Parser\Popo;

use Doctrine\Common\Annotations\AnnotationReader;
use PSX\DateTime\Date;
use PSX\DateTime\DateTime;
use PSX\DateTime\Duration;
use PSX\DateTime\Time;
use PSX\Record\Record;
use PSX\Record\RecordInterface;
use PSX\Schema\Parser\Popo\Dumper;
use PSX\Uri\Uri;

/**
 * DumperTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class DumperTest extends \PHPUnit_Framework_TestCase
{
    public function testDump()
    {
        include_once __DIR__ . '/News.php';

        $config = new Config();
        $config['foo'] = 'bar';

        $location = new Location();
        $location->setLat(12.34);
        $location->setLong(56.78);
        $location['foo'] = 'bar';

        $author = new Author();
        $author->setTitle('foo');
        $author->setEmail('foo@bar.com');
        $author->setCategories(['foo', 'bar']);
        $author->setLocations([$location, $location]);
        $author->setOrigin($location);

        $web = new Web();
        $web->setName('foo');
        $web->setUrl('http://google.com');
        $web['email'] = 'foo@bar.com';

        $profileImage = fopen('php://memory', 'r+');
        fwrite($profileImage, 'foobar');

        $meta = new Meta();
        $meta->setCreateDate(new DateTime('2016-12-11T10:50:00'));
        $meta['tags_0'] = 'foo';
        $meta['tags_1'] = 'bar';
        $meta['location_0'] = $location;

        $news = new News();
        $news->setConfig($config);
        $news->setTags(['foo', 'bar']);
        $news->setReceiver([$author]);
        $news->setResources([$web, $location]);
        $news->setProfileImage($profileImage);
        $news->setRead(false);
        $news->setSource($web);
        $news->setAuthor($author);
        $news->setMeta($meta);
        $news->setSendDate(new Date('2016-12-11'));
        $news->setReadDate(new DateTime('2016-12-11T10:50:00'));
        $news->setExpires(new Duration('P1D'));
        $news->setPrice(50);
        $news->setRating(4);
        $news->setContent('foobar');
        $news->setQuestion('foo');
        $news->setCoffeeTime(new Time('10:49:00'));
        $news->setProfileUri(new Uri('urn:foo:image'));

        $reader = new AnnotationReader();
        $dumper = new Dumper($reader);
        $actual = $dumper->dump($news);

        $this->assertInstanceOf(RecordInterface::class, $actual);

        $actual = json_encode($actual, JSON_PRETTY_PRINT);
        $expect = <<<JSON
{
    "config": {
        "foo": "bar"
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
                "foo",
                "bar"
            ],
            "locations": [
                {
                    "lat": 12.34,
                    "long": 56.78,
                    "foo": "bar"
                },
                {
                    "lat": 12.34,
                    "long": 56.78,
                    "foo": "bar"
                }
            ],
            "origin": {
                "lat": 12.34,
                "long": 56.78,
                "foo": "bar"
            }
        }
    ],
    "resources": [
        {
            "name": "foo",
            "url": "http:\/\/google.com",
            "email": "foo@bar.com"
        },
        {
            "lat": 12.34,
            "long": 56.78,
            "foo": "bar"
        }
    ],
    "profileImage": "Zm9vYmFy",
    "read": false,
    "source": {
        "name": "foo",
        "url": "http:\/\/google.com",
        "email": "foo@bar.com"
    },
    "author": {
        "title": "foo",
        "email": "foo@bar.com",
        "categories": [
            "foo",
            "bar"
        ],
        "locations": [
            {
                "lat": 12.34,
                "long": 56.78,
                "foo": "bar"
            },
            {
                "lat": 12.34,
                "long": 56.78,
                "foo": "bar"
            }
        ],
        "origin": {
            "lat": 12.34,
            "long": 56.78,
            "foo": "bar"
        }
    },
    "meta": {
        "createDate": "2016-12-11T10:50:00Z",
        "tags_0": "foo",
        "tags_1": "bar",
        "location_0": {
            "lat": 12.34,
            "long": 56.78,
            "foo": "bar"
        }
    },
    "sendDate": "2016-12-11",
    "readDate": "2016-12-11T10:50:00Z",
    "expires": "P1D",
    "price": 50,
    "rating": 4,
    "content": "foobar",
    "question": "foo",
    "coffeeTime": "10:49:00",
    "profileUri": "urn:foo:image"
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    /**
     * @dataProvider traversableProvider
     */
    public function testDumpTraversable()
    {
        include_once __DIR__ . '/News.php';

        $subLocation = new Location();
        $subLocation->setLat(12.34);
        $subLocation->setLong(56.78);
        $subLocation['foo'] = 'bar';

        $resource = fopen('php://memory', 'r+');
        fwrite($resource, 'foobar');

        $location = new Location();
        $location->setLat(12.34);
        $location->setLong(56.78);
        $location['assoc_array'] = ['foo' => $subLocation, 'date' => new DateTime(2016, 12, 24), 'string' => 'bar', 'resource' => $resource];
        $location['stdclass'] = (object) ['foo' => $subLocation, 'date' => new DateTime(2016, 12, 24), 'string' => 'bar', 'resource' => $resource];
        $location['array'] = [$subLocation, 'date' => new DateTime(2016, 12, 24), 'string' => 'bar', 'resource' => $resource];

        $locations = [
            $location,
            Record::fromArray(['lat' => 12, 'long' => 12]),
        ];

        $author = new Author();
        $author->setLocations($locations);

        $reader = new AnnotationReader();
        $dumper = new Dumper($reader);
        $actual = $dumper->dump($author);

        $this->assertInstanceOf(RecordInterface::class, $actual);

        $actual = json_encode($actual, JSON_PRETTY_PRINT);
        $expect = <<<JSON
{
    "locations": [
        {
            "lat": 12.34,
            "long": 56.78,
            "assoc_array": {
                "foo": {
                    "lat": 12.34,
                    "long": 56.78,
                    "foo": "bar"
                },
                "date": "2016-12-24T00:00:00Z",
                "string": "bar",
                "resource": "foobar"
            },
            "stdclass": {
                "foo": {
                    "lat": 12.34,
                    "long": 56.78,
                    "foo": "bar"
                },
                "date": "2016-12-24T00:00:00Z",
                "string": "bar",
                "resource": "foobar"
            },
            "array": [
                {
                    "lat": 12.34,
                    "long": 56.78,
                    "foo": "bar"
                },
                "2016-12-24T00:00:00Z",
                "bar",
                "foobar"
            ]
        },
        {
            "lat": 12,
            "long": 12
        }
    ]
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function traversableProvider()
    {
        return [
            [],
            [],
        ];
    }
}
