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

namespace PSX\Schema\Tests\Parser;

use PSX\Schema\SchemaInterface;
use PSX\Schema\Tests\SchemaTestCase;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\UnionType;

/**
 * ParserTestCase
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
abstract class ParserTestCase extends SchemaTestCase
{
    protected function assertDiscriminator(SchemaInterface $schema)
    {
        /** @var StructType $container */
        $container = $schema->getDefinitions()->getType('Form_Container');
        $this->assertInstanceOf(StructType::class, $container);

        /** @var ArrayType $elements */
        $elements = $container->getProperty('elements');
        $this->assertInstanceOf(ArrayType::class, $elements);

        /** @var UnionType $items */
        $expect = [
            'http://fusio-project.org/ns/2015/form/input' => 'Form_Element_Input',
            'http://fusio-project.org/ns/2015/form/select' => 'Form_Element_Select',
            'http://fusio-project.org/ns/2015/form/tag' => 'Form_Element_Tag',
            'http://fusio-project.org/ns/2015/form/textarea' => 'Form_Element_TextArea',
        ];

        $items = $elements->getItems();
        $this->assertInstanceOf(UnionType::class, $items);
        $this->assertEquals('element', $items->getPropertyName());
        $this->assertEquals($expect, $items->getMapping());
    }
}
