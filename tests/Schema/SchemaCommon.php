<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Tests\Schema;

use PSX\Schema\SchemaAbstract;
use PSX\Schema\TypeFactory;

class SchemaCommon extends SchemaAbstract
{
    public function build(): void
    {
        $entry = $this->newStruct('Entry');
        $entry->addInteger('title');

        $author = $this->newStruct('Author');
        $author->addInteger('name');

        $location = $this->newStruct('Location');
        $location->setDescription('Location of the person');
        $location->addInteger('lat');
        $location->addInteger('long');
        $location->addArray('entry', TypeFactory::getReference('Entry'));
        $location->addReference('author', 'Author');
    }
}
