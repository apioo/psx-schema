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

namespace PSX\Schema\Tests;

use PSX\Schema\SchemaAbstract;
use PSX\Schema\Tests\Parser\Popo;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\TypeFactory;

/**
 * TestSchema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TestSchema extends SchemaAbstract
{
    public function build(): void
    {
        $location = $this->newStruct('Location');
        $location->setDescription('Location of the person');
        $location->addNumber('lat');
        $location->addNumber('long');
        $location->setRequired(['lat', 'long']);
        $location->setAttribute(TypeAbstract::ATTR_CLASS, Popo\Location::class);

        $web = $this->newStruct('Web');
        $web->setDescription('An application');
        $web->addString('name');
        $web->addString('url');
        $web->setRequired(['name', 'url']);
        $web->setAttribute(TypeAbstract::ATTR_CLASS, Popo\Web::class);

        $author = $this->newStruct('Author');
        $author->setDescription('An simple author element with some description');
        $author->addString('title')
            ->setPattern('[A-z]{3,16}');
        $author->addString('email')
            ->setDescription('We will send no spam to this address')
            ->setNullable(true);
        $author->addArray('categories', TypeFactory::getString())
            ->setMaxItems(8);
        $author->addArray('locations', TypeFactory::getReference('Location'))
            ->setDescription('Array of locations');
        $author->addReference('origin', 'Location');
        $author->setRequired(['title']);
        $author->setAttribute(TypeAbstract::ATTR_CLASS, Popo\Author::class);

        $meta = $this->newMap('Meta');
        $meta->setAdditionalProperties(TypeFactory::getString());
        $meta->setMinProperties(1);
        $meta->setMaxProperties(6);
        $meta->setAttribute(TypeAbstract::ATTR_CLASS, Popo\Meta::class);

        $news = $this->newStruct('News');
        $news->setDescription('An general news entry');
        $news->addReference('config', 'Meta');
        $news->addArray('tags', TypeFactory::getString())
            ->setMinItems(1)
            ->setMaxItems(6);
        $news->addArray('receiver', TypeFactory::getReference('Author'))
            ->setMinItems(1);
        $news->addArray('resources', TypeFactory::getUnion([
            TypeFactory::getReference('Location'),
            TypeFactory::getReference('Web')
        ]));
        $news->addBinary('profileImage');
        $news->addBoolean('read');
        $news->addUnion('source', [
            TypeFactory::getReference('Author'),
            TypeFactory::getReference('Web')
        ]);
        $news->addReference('author', 'Author');
        $news->addReference('meta', 'Meta');
        $news->addDate('sendDate');
        $news->addDateTime('readDate');
        $news->addDuration('expires');
        $news->addNumber('price')
            ->setMinimum(1)
            ->setMaximum(100);
        $news->addInteger('rating')
            ->setMinimum(1)
            ->setMaximum(5);
        $news->addString('content')
            ->setDescription('Contains the main content of the news entry')
            ->setMinLength(3)
            ->setMaxLength(512);
        $news->addString('question')
            ->setEnum(['foo', 'bar']);
        $news->addString('version')
            ->setConst('http://foo.bar');
        $news->addTime('coffeeTime');
        $news->addUri('profileUri');
        $news->addString('g-recaptcha-response');
        $news->add('payload', TypeFactory::getAny());
        $news->setRequired(['receiver', 'price', 'content']);
        $news->setAttribute(TypeAbstract::ATTR_CLASS, Popo\News::class);
        $news->setAttribute(TypeAbstract::ATTR_MAPPING, ['g-recaptcha-response' => 'captcha']);
    }
}
