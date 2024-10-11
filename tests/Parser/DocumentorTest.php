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

use PSX\Schema\Exception\ParserException;
use PSX\Schema\Parser;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\ReferencePropertyType;

/**
 * DocumentorTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class DocumentorTest extends ParserTestCase
{
    public function testParse()
    {
        $parser = new Parser\Documentor();
        $schema = $parser->parse('\PSX\Schema\Tests\Parser\Popo\Attribute\News');

        $this->assertSchema($this->getSchema(), $schema);
    }

    public function testParseNotFullyQualified()
    {
        $parser = new Parser\Documentor();
        $schema = $parser->parse('PSX\Schema\Tests\Parser\Popo\Attribute\News');

        $this->assertSchema($this->getSchema(), $schema);
    }

    public function testParseMap()
    {
        $parser = new Parser\Documentor();
        $schema = $parser->parse('\PSX\Record\Record<string, \PSX\Schema\Tests\Parser\Popo\Attribute\News>');

        $this->assertInstanceOf(SchemaInterface::class, $schema);
        $mapType = $schema->getDefinitions()->getType($schema->getRoot());
        $this->assertInstanceOf(MapDefinitionType::class, $mapType);
        $schema = $mapType->getSchema();
        $this->assertInstanceOf(ReferencePropertyType::class, $schema);
        $this->assertEquals('News', $schema->getTarget());
    }

    public function testParseArray()
    {
        $parser = new Parser\Documentor();
        $schema = $parser->parse('array<\PSX\Schema\Tests\Parser\Popo\Attribute\News>');

        $this->assertInstanceOf(SchemaInterface::class, $schema);
        $arrayType = $schema->getDefinitions()->getType($schema->getRoot());
        $this->assertInstanceOf(ArrayDefinitionType::class, $arrayType);
        $schema = $arrayType->getSchema();
        $this->assertInstanceOf(ReferencePropertyType::class, $schema);
        $this->assertEquals('News', $schema->getTarget());
    }

    public function testInvalid()
    {
        $this->expectException(ParserException::class);

        $parser = new Parser\Documentor();
        $parser->parse('foobar');
    }
}
