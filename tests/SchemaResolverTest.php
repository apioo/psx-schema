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

use PSX\Schema\SchemaResolver;
use PSX\Schema\Type\Factory\DefinitionTypeFactory;
use PSX\Schema\Type\Factory\PropertyTypeFactory;

/**
 * SchemaResolverTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class SchemaResolverTest extends SchemaTestCase
{
    public function testResolve()
    {
        $schema = $this->getSchema();

        $foo = DefinitionTypeFactory::getStruct();
        $foo->addProperty('bar', PropertyTypeFactory::getString());
        $schema->getDefinitions()->addType('foo', $foo);

        $resolver = new SchemaResolver();
        $resolver->resolve($schema);

        $types = $schema->getDefinitions()->getAllTypes();
        $this->assertEquals(['self:Location', 'self:Author', 'self:Meta', 'self:News'], array_keys($types));
    }
}
