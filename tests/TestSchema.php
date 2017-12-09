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

use PSX\Schema\Property;
use PSX\Schema\SchemaAbstract;

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
        $sb = $this->getSchemaBuilder('location')
            ->setAdditionalProperties(true)
            ->setDescription('Location of the person')
            ->setRequired(['lat', 'long']);
        $sb->number('lat');
        $sb->number('long');
        $location = $sb->getProperty();

        $sb = $this->getSchemaBuilder('web')
            ->setAdditionalProperties(Property::getString())
            ->setMinProperties(2)
            ->setMaxProperties(8)
            ->setDescription('An application')
            ->setRequired(['name', 'url']);
        $sb->string('name');
        $sb->string('url');
        $web = $sb->getProperty();

        $sb = $this->getSchemaBuilder('author')
            ->setDescription('An simple author element with some description');
        $sb->string('title')
            ->setPattern('[A-z]{3,16}');
        $sb->property('email')
            ->setType(['string', 'null'])
            ->setDescription('We will send no spam to this address');
        $sb->arrayType('categories')
            ->setItems(Property::getString())
            ->setMaxItems(8);
        $sb->arrayType('locations')
            ->setItems($location)
            ->setDescription('Array of locations');
        $sb->objectType('origin', $location);
        $sb->setRequired(['title']);
        $sb->setAdditionalProperties(false);
        $author = $sb->getProperty();

        $sb = $this->getSchemaBuilder('meta')
            ->setDescription('Some meta data')
            ->addPatternProperty('^tags_\d$', Property::getString())
            ->addPatternProperty('^location_\d$', $location);
        $sb->dateTime('createDate');
        $sb->setAdditionalProperties(false);
        $meta = $sb->getProperty();

        $sb = $this->getSchemaBuilder('news')
            ->setDescription('An general news entry');
        $sb->objectType('config')
            ->setTitle('config')
            ->setAdditionalProperties(Property::getString());
        $sb->arrayType('tags')
            ->setItems(Property::getString())
            ->setMinItems(1)
            ->setMaxItems(6);
        $sb->arrayType('receiver')
            ->setItems($author)
            ->setMinItems(1);
        $sb->arrayType('resources')
            ->setItems(Property::get()->setOneOf([$location, $web])->setTitle('resource'));
        $sb->binary('profileImage');
        $sb->boolean('read');
        $sb->property('source')
            ->setOneOf([$author, $web])->setTitle('source');
        $sb->objectType('author', $author);
        $sb->objectType('meta', $meta);
        $sb->date('sendDate');
        $sb->dateTime('readDate');
        $sb->duration('expires');
        $sb->number('price')
            ->setMinimum(1)
            ->setMaximum(100);
        $sb->integer('rating')
            ->setMinimum(1)
            ->setMaximum(5);
        $sb->string('content')
            ->setDescription('Contains the main content of the news entry')
            ->setMinLength(3)
            ->setMaxLength(512);
        $sb->string('question')
            ->setEnum(['foo', 'bar']);
        $sb->string('version')
            ->setConst('http://foo.bar');
        $sb->time('coffeeTime');
        $sb->uri('profileUri');
        $sb->setRequired(['receiver', 'price', 'content']);
        $sb->setAdditionalProperties(false);

        return $sb->getProperty();
    }
}
