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

use PHPUnit\Framework\TestCase;
use PSX\Schema\Builder;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\TypeFactory;

/**
 * BuilderTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class BuilderTest extends TestCase
{
    public function testBuilder()
    {
        $builder = new Builder('foo');
        $builder->setDescription('bar');
        $builder->setRequired(['foo', 'bar']);
        $builder->setClass('stdClass');
        $builder->addArray('array', TypeFactory::getString());
        $builder->addBoolean('boolean');
        $builder->addInteger('integer');
        $builder->addIntersection('intersection', []);
        $builder->addNumber('number');
        $builder->addString('string');
        $builder->addUnion('union', []);

        $builder->addBinary('binary');
        $builder->addDateTime('datetime');
        $builder->addDate('date');
        $builder->addDuration('duration');
        $builder->addTime('time');
        $builder->addUri('uri');

        $type = $builder->getType();

        $this->assertInstanceOf(StructType::class, $type);
        $this->assertEquals(null, $type->getTitle());
        $this->assertEquals('bar', $type->getDescription());
        $this->assertEquals('stdClass', $type->getAttribute(TypeAbstract::ATTR_CLASS));
    }
}