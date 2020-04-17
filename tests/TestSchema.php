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

use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Property;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
use PSX\Schema\SchemaAbstract;
use PSX\Schema\Tests\Parser\Popo;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\TypeFactory;
use PSX\Schema\TypeInterface;

/**
 * TestSchema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class TestSchema extends SchemaAbstract
{
    public function build(DefinitionsInterface $definitions): TypeInterface
    {
        $location = TypeFactory::getStruct();
        $location->setDescription('Location of the person');
        $location->addProperty('lat', TypeFactory::getNumber());
        $location->addProperty('long', TypeFactory::getNumber());
        $location->setRequired(['lat', 'long']);
        $location->setAttribute(TypeAbstract::ATTR_CLASS, Popo\Location::class);
        $definitions->addType('Location', $location);

        $web = TypeFactory::getStruct();
        $web->setDescription('An application');
        $web->addProperty('name', TypeFactory::getString());
        $web->addProperty('url', TypeFactory::getString());
        $web->setRequired(['name', 'url']);
        $web->setAttribute(TypeAbstract::ATTR_CLASS, Popo\Web::class);
        $definitions->addType('Web', $web);

        $author = TypeFactory::getStruct();
        $author->setDescription('An simple author element with some description');
        $author->addProperty('title', TypeFactory::getString()
            ->setPattern('[A-z]{3,16}'));
        $author->addProperty('email', TypeFactory::getString()
            ->setDescription('We will send no spam to this address')
            ->setNullable(true));
        $author->addProperty('categories', TypeFactory::getArray()
            ->setItems(TypeFactory::getString())
            ->setMaxItems(8));
        $author->addProperty('locations', TypeFactory::getArray()
            ->setDescription('Array of locations')
            ->setItems(TypeFactory::getReference('Location')));
        $author->addProperty('origin', TypeFactory::getReference('Location'));
        $author->setRequired(['title']);
        $author->setAttribute(TypeAbstract::ATTR_CLASS, Popo\Author::class);
        $definitions->addType('Author', $author);

        $meta = TypeFactory::getMap();
        $meta->setAdditionalProperties(TypeFactory::getString());
        $meta->setMinProperties(1);
        $meta->setMaxProperties(6);
        $meta->setAttribute(TypeAbstract::ATTR_CLASS, Popo\Meta::class);
        $definitions->addType('Meta', $meta);

        $news = TypeFactory::getStruct();
        $news->setTitle('News');
        $news->setDescription('An general news entry');
        $news->addProperty('config', TypeFactory::getReference('Meta'));
        $news->addProperty('tags', TypeFactory::getArray()
            ->setItems(TypeFactory::getString())
            ->setMinItems(1)
            ->setMaxItems(6));
        $news->addProperty('receiver', TypeFactory::getArray()
            ->setItems(TypeFactory::getReference('Author'))
            ->setMinItems(1));
        $news->addProperty('resources', TypeFactory::getArray()
            ->setItems(TypeFactory::getUnion([
                TypeFactory::getReference('Location'),
                TypeFactory::getReference('Web')
            ])));
        $news->addProperty('profileImage', TypeFactory::getBinary());
        $news->addProperty('read', TypeFactory::getBoolean());
        $news->addProperty('source', TypeFactory::getUnion([
            TypeFactory::getReference('Author'),
            TypeFactory::getReference('Web')
        ]));
        $news->addProperty('author', TypeFactory::getReference('Author'));
        $news->addProperty('meta', TypeFactory::getReference('Meta'));
        $news->addProperty('sendDate', TypeFactory::getDate());
        $news->addProperty('readDate', TypeFactory::getDateTime());
        $news->addProperty('expires', TypeFactory::getDuration());
        $news->addProperty('price', TypeFactory::getNumber()
            ->setMinimum(1)
            ->setMaximum(100));
        $news->addProperty('rating', TypeFactory::getInteger()
            ->setMinimum(1)
            ->setMaximum(5));
        $news->addProperty('content', TypeFactory::getString()
            ->setDescription('Contains the main content of the news entry')
            ->setMinLength(3)
            ->setMaxLength(512));
        $news->addProperty('question', TypeFactory::getString()
            ->setEnum(['foo', 'bar']));
        $news->addProperty('version', TypeFactory::getString()
            ->setConst('http://foo.bar'));
        $news->addProperty('coffeeTime', TypeFactory::getTime());
        $news->addProperty('profileUri', TypeFactory::getUri());
        $news->addProperty('g-recaptcha-response', TypeFactory::getString());
        $news->setRequired(['receiver', 'price', 'content']);
        $news->setAttribute(TypeAbstract::ATTR_CLASS, Popo\News::class);
        $news->setAttribute(TypeAbstract::ATTR_MAPPING, ['g-recaptcha-response' => 'captcha']);

        return $news;
    }
}
