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

use PSX\Schema\Builder;
use PSX\Schema\Property;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;

/**
 * BuilderTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class BuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testBuilder()
    {
        $builder = new Builder('foo');

        $builder
            ->setDescription('bar')
            ->setRequired(['foo', 'bar'])
            ->addPatternProperty('^x-', Property::getInteger())
            ->setAdditionalProperties(Property::getString())
            ->setClass('stdClass');

        $property = $builder->getProperty();

        $this->assertInstanceOf(PropertyInterface::class, $property);
        $this->assertEquals(PropertyType::TYPE_OBJECT, $property->getType());
        $this->assertEquals('foo', $property->getTitle());
        $this->assertEquals('bar', $property->getDescription());
        $this->assertEquals('stdClass', $property->getClass());
    }
}
