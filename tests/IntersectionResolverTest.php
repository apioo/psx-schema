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
use PSX\Schema\Definitions;
use PSX\Schema\IntersectionResolver;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\StructType;
use PSX\Schema\TypeFactory;

/**
 * IntersectionResolverTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class IntersectionResolverTest extends TestCase
{
    public function testResolve()
    {
        $a = new StructType();
        $a->setProperties([
            'foo' => TypeFactory::getString()
        ]);

        $b = new StructType();
        $b->setProperties([
            'bar' => TypeFactory::getString()
        ]);

        $definitions = new Definitions();
        $definitions->addType('Foo', $a);
        $definitions->addType('Bar', $b);

        $type = new IntersectionType();
        $type->setAllOf([
            TypeFactory::getReference('Foo'),
            TypeFactory::getReference('Bar')
        ]);

        $resolver = new IntersectionResolver($definitions);
        $result = $resolver->resolve($type);

        $this->assertEquals(['foo', 'bar'], array_keys($result->getProperties()));
    }

    public function testResolveNotPossible()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('All of must contain only struct types');

        $a = new StructType();
        $a->setProperties([
            'foo' => TypeFactory::getString()
        ]);

        $b = new BooleanType();

        $definitions = new Definitions();
        $definitions->addType('Foo', $a);
        $definitions->addType('Bar', $b);

        $type = new IntersectionType();
        $type->setAllOf([
            TypeFactory::getReference('Foo'),
            TypeFactory::getReference('Bar')
        ]);

        $resolver = new IntersectionResolver($definitions);
        $result = $resolver->resolve($type);

        $this->assertEquals(['foo', 'bar'], array_keys($result->getProperties()));
    }
}
