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

use PSX\Schema\Property;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
use PSX\Schema\SchemaAbstract;
use PSX\Schema\Tests\Parser\Popo;

/**
 * TestSchema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class TestSchema extends SchemaAbstract
{
    public function getDefinition()
    {
        $location = Property::getStruct();
        $location->setDescription('Location of the person');
        $location->addProperty('lat', Property::getNumber());
        $location->addProperty('long', Property::getNumber());
        $location->setRequired(['lat', 'long']);
        $location->setAttribute(PropertyType::ATTR_CLASS, Popo\Location::class);

        $web = Property::getStruct();
        $web->setDescription('An application');
        $web->addProperty('name', Property::getString());
        $web->addProperty('url', Property::getString());
        $web->setRequired(['name', 'url']);
        $web->setAttribute(PropertyType::ATTR_CLASS, Popo\Web::class);

        $author = Property::getStruct();
        $author->setDescription('An simple author element with some description');
        $author->addProperty('title', Property::getString()
            ->setPattern('[A-z]{3,16}'));
        $author->addProperty('email', Property::getString()
            ->setDescription('We will send no spam to this address')
            ->setNullable(true));
        $author->addProperty('categories', Property::getArray()
            ->setItems(Property::getString())
            ->setMaxItems(8));
        $author->addProperty('locations', Property::getArray()
            ->setDescription('Array of locations')
            ->setItems($location));
        $author->addProperty('origin', $location);
        $author->setRequired(['title']);
        $author->setAttribute(PropertyType::ATTR_CLASS, Popo\Author::class);

        $meta = Property::getMap();
        $meta->setAdditionalProperties(Property::getString());
        $meta->setAttribute(PropertyType::ATTR_CLASS, Popo\Meta::class);

        $news = Property::getStruct();
        $news->setDescription('An general news entry');
        $news->addProperty('config', Property::getMap()
            ->setAdditionalProperties(Property::getString()));
        $news->addProperty('tags', Property::getArray()
            ->setItems(Property::getString())
            ->setMinItems(1)
            ->setMaxItems(6));
        $news->addProperty('receiver', Property::getArray()
            ->setItems($author)
            ->setMinItems(1));
        $news->addProperty('resources', Property::getUnion()
            ->setOneOf([$location, $web]));
        $news->addProperty('profileImage', Property::getBinary());
        $news->addProperty('read', Property::getBoolean());
        $news->addProperty('source', Property::getUnion()
            ->setOneOf([$author, $web]));
        $news->addProperty('author', $author);
        $news->addProperty('meta', $meta);
        $news->addProperty('sendDate', Property::getDate());
        $news->addProperty('readDate', Property::getDateTime());
        $news->addProperty('expires', Property::getDuration());
        $news->addProperty('price', Property::getNumber()
            ->setMinimum(1)
            ->setMaximum(100));
        $news->addProperty('rating', Property::getInteger()
            ->setMinimum(1)
            ->setMaximum(5));
        $news->addProperty('content', Property::getString()
            ->setDescription('Contains the main content of the news entry')
            ->setMinLength(3)
            ->setMaxLength(512));
        $news->addProperty('question', Property::getString()
            ->setEnum(['foo', 'bar']));
        $news->addProperty('version', Property::getString()
            ->setConst('http://foo.bar'));
        $news->addProperty('coffeeTime', Property::getTime());
        $news->addProperty('profileUri', Property::getUri());
        $news->addProperty('g-recaptcha-response', Property::getString());
        $news->setRequired(['receiver', 'price', 'content']);
        $news->setAttribute(PropertyType::ATTR_CLASS, Popo\News::class);
        $news->setAttribute(PropertyType::ATTR_MAPPING, ['g-recaptcha-response' => 'captcha']);

        return $news;
    }
}
