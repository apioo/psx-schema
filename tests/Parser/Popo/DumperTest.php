<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use PHPUnit\Framework\TestCase;
use PSX\DateTime\Date;
use PSX\DateTime\DateTime;
use PSX\DateTime\Duration;
use PSX\DateTime\Time;
use PSX\Record\RecordInterface;
use PSX\Schema\Parser\Popo\Dumper;
use PSX\Uri\Uri;

/**
 * DumperTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class DumperTest extends TestCase
{
    public function testDump()
    {
        include_once __DIR__ . '/News.php';

        $config = new Meta();
        $config['foo'] = 'bar';

        $location = new Location();
        $location->setLat(12.34);
        $location->setLong(56.78);

        $author = new Author();
        $author->setTitle('foo');
        $author->setEmail('foo@bar.com');
        $author->setCategories(['foo', 'bar']);
        $author->setLocations([$location, $location]);
        $author->setOrigin($location);

        $web = new Web();
        $web->setName('foo');
        $web->setUrl('http://google.com');

        $profileImage = fopen('php://memory', 'r+');
        fwrite($profileImage, 'foobar');

        $meta = new Meta();
        $meta['tags_0'] = 'foo';
        $meta['tags_1'] = 'bar';

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
        $expect = file_get_contents(__DIR__ . '/expect.json');

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testDumpTraversable()
    {
        include_once __DIR__ . '/News.php';

        $location = new Location();
        $location->setLat(12.34);
        $location->setLong(56.78);

        $locations = [
            $location,
            $location,
        ];

        $author = new Author();
        $author->setLocations($locations);

        $reader = new AnnotationReader();
        $dumper = new Dumper($reader);
        $actual = $dumper->dump($author);

        $this->assertInstanceOf(RecordInterface::class, $actual);

        $actual = json_encode($actual, JSON_PRETTY_PRINT);
        $expect = file_get_contents(__DIR__ . '/expect_iterable.json');

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
