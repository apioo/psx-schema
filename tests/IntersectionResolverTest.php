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

use PHPUnit\Framework\TestCase;
use PSX\Schema\IntersectionResolver;
use PSX\Schema\Property;
use PSX\Schema\PropertyType;

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
        $a = new PropertyType();
        $a->setProperties([
            'foo' => Property::getString()
        ]);

        $b = new PropertyType();
        $b->setProperties([
            'bar' => Property::getString()
        ]);

        $property = new PropertyType();
        $property->setOneOf([$a, $b]);

        $resolver = new IntersectionResolver();
        $result = $resolver->resolve($property);

        $this->assertEquals(['foo', 'bar'], array_keys($result->getProperties()));
    }

    public function testResolveNotPossible()
    {
        $a = new PropertyType();
        $a->setProperties([
            'foo' => Property::getString()
        ]);

        $b = new PropertyType();
        $b->setOneOf([
            Property::getString(),
            Property::getBoolean()
        ]);

        $property = new PropertyType();
        $property->setOneOf([$a, $b]);

        $resolver = new IntersectionResolver();
        $result = $resolver->resolve($property);

        $this->assertNull($result);
    }
}
