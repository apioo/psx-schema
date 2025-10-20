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

namespace PSX\Schema\Tests\Parser;

use PSX\Schema\Parser;
use PSX\Schema\Tests\Parser\Popo\ArrayInArray;
use PSX\Schema\Tests\Parser\Popo\Form_Element;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\StructDefinitionType;

/**
 * PopoTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class PopoTest extends ParserTestCase
{
    public function testParse()
    {
        $parser = new Parser\Popo();
        $schema = $parser->parse(Popo\Attribute\News::class);

        $this->assertSchema($this->getSchema(), $schema);
    }

    public function testDiscriminator()
    {
        $parser = new Parser\Popo();
        $schema = $parser->parse(Form_Element::class);

        $this->assertDiscriminator($schema);
    }

    public function testArrayInArray()
    {
        $parser = new Parser\Popo();
        $schema = $parser->parse(ArrayInArray::class);

        $object = $schema->getDefinitions()->getType($schema->getRoot());
        $this->assertInstanceOf(StructDefinitionType::class, $object);

        $items = $object->getProperty('items');
        $this->assertInstanceOf(ArrayPropertyType::class, $items);

        $array = $items->getSchema();
        $this->assertInstanceOf(ArrayPropertyType::class, $array);
        $this->assertInstanceOf(NumberPropertyType::class, $array->getSchema());
    }
}
