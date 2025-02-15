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

use PSX\Schema\SchemaAbstract;
use PSX\Schema\Tests\Parser\Popo;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\Factory\PropertyTypeFactory;

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
        $location->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, Popo\Location::class);

        $author = $this->newStruct('Author');
        $author->setDescription('An simple author element with some description');
        $author->addString('title');
        $author->addString('email')
            ->setDescription('We will send no spam to this address')
            ->setNullable(true);
        $author->addArray('categories', PropertyTypeFactory::getString());
        $author->addArray('locations', PropertyTypeFactory::getReference('Location'))
            ->setDescription('Array of locations');
        $author->addReference('origin', 'Location');
        $author->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, Popo\Author::class);

        $meta = $this->newMap('Meta', PropertyTypeFactory::getString());
        $meta->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, Popo\Meta::class);

        $news = $this->newStruct('News');
        $news->setDescription('An general news entry');
        $news->addReference('config', 'Meta');
        $news->add('inlineConfig', PropertyTypeFactory::getMap(PropertyTypeFactory::getString()));

        $news->addMap('mapTags', PropertyTypeFactory::getString());
        $news->addMap('mapReceiver', PropertyTypeFactory::getReference('Author'));

        $news->addArray('tags', PropertyTypeFactory::getString());
        $news->addArray('receiver', PropertyTypeFactory::getReference('Author'));
        $news->addArray('data', PropertyTypeFactory::getArray(PropertyTypeFactory::getNumber()));

        $news->addBoolean('read');
        $news->addReference('author', 'Author');
        $news->addReference('meta', 'Meta');
        $news->addDate('sendDate');
        $news->addDateTime('readDate');
        $news->addNumber('price');
        $news->addInteger('rating');
        $news->addString('content')
            ->setDescription('Contains the main content of the news entry');
        $news->addString('question');
        $news->addString('version');
        $news->addTime('coffeeTime');
        $news->addString('g-recaptcha-response');
        $news->addString('media.fields');
        $news->add('payload', PropertyTypeFactory::getAny());
        $news->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, Popo\News::class);
        $news->setAttribute(DefinitionTypeAbstract::ATTR_MAPPING, ['g-recaptcha-response' => 'captcha']);
    }
}
