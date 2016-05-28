<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

namespace PSX\Schema\Tests\Parser\Popo;

use PSX\Http;
use PSX\Schema\Parser\JsonSchema;
use PSX\Schema\Parser\Popo\TypeParser;

/**
 * TypeParserTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class TypeParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider typeDataProvider
     */
    public function testParse($type, $baseType, $typeHint, $subTypes)
    {
        $type = TypeParser::parse($type);

        $this->assertEquals($baseType, $type->getBaseType());
        $this->assertEquals($typeHint, $type->getTypeHint());
        $this->assertEquals($subTypes, $type->getSubTypes());
    }

    public function typeDataProvider()
    {
        return [
            ['string', 'string', null, []],
            ['Foo\\Bar', 'complex', 'Foo\\Bar', []],
            ['\\Foo\\Bar', 'complex', 'Foo\\Bar', []],
            ['Foo\\Bar', 'complex', 'Foo\\Bar', []],
            ['choice(Foo\\Bar)', 'choice', 'Foo\\Bar', []],
            ['choice<\\Foo\\Bar>', 'choice', null, ['Foo\\Bar']],
            ['choice<Foo\\Bar>', 'choice', null, ['Foo\\Bar']],
            ['choice<Foo\\Bar,Foo\\Bar,Foo\\Bar>', 'choice', null, ['Foo\\Bar', 'Foo\\Bar', 'Foo\\Bar']],
            ['choice<fo=\\Foo\\Bar>', 'choice', null, ['fo' => 'Foo\\Bar']],
            ['choice<fo=Foo\\Bar>', 'choice', null, ['fo' => 'Foo\\Bar']],
            ['choice(\\Foo\\Bar)<Bar\\Foo, Bar\\Test>', 'choice', 'Foo\\Bar', ['Bar\\Foo', 'Bar\\Test']],
            ['choice(\\Foo\\Bar)<fo=Bar\\Foo, ba=Bar\\Test>', 'choice', 'Foo\\Bar', ['fo' => 'Bar\\Foo', 'ba' => 'Bar\\Test']],
            ['choice<fo=Bar\\Foo, ba=Bar\\Test>', 'choice', null, ['fo' => 'Bar\\Foo', 'ba' => 'Bar\\Test']],
            ['choice<
    fo = Bar\\Foo, 
    ba = Bar\\Test
>', 'choice', null, ['fo' => 'Bar\\Foo', 'ba' => 'Bar\\Test']],
            ['array<choice<\\Foo\\Bar>>', 'array', null, ['choice<\\Foo\\Bar>']],
            ['array<choice(\\Foo\\Bar)<Bar\\Foo, Bar\\Test>>', 'array', null, ['choice(\Foo\Bar)<Bar\Foo,Bar\Test>']],
            ['array<choice(\\Foo\\Bar)<fo=Bar\\Foo, bar=Bar\\Test>>', 'array', null, ['choice(\Foo\Bar)<fo=Bar\Foo,bar=Bar\Test>']],
        ];
    }
}
