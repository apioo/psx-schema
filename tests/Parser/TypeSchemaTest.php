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

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PSX\Http\Client;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\Parser;
use PSX\Schema\SchemaManager;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\TypeInterface;

/**
 * TypeSchemaTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TypeSchemaTest extends ParserTestCase
{
    public function testParse()
    {
        $parser = new Parser\File(new SchemaManager());
        $schema = $parser->parse(__DIR__ . '/TypeSchema/test_schema.json');

        $this->assertSchema($this->getSchema(), $schema);
        $this->assertSchemaAttributes($this->getSchema(), $schema);
    }

    public function testParseTypeSchema()
    {
        $parser = new Parser\File(new SchemaManager());
        $schema = $parser->parse(__DIR__ . '/TypeSchema/typeschema.json');

        $this->assertEquals('Specification', $schema->getRoot());
    }

    public function testDiscriminator()
    {
        $parser = new Parser\File(new SchemaManager());
        $schema = $parser->parse(__DIR__ . '/TypeSchema/form_container.json');

        $this->assertDiscriminator($schema);
    }

    public function testParseExternalResource()
    {
        $mock = new MockHandler([
            new Response(200, [], file_get_contents(__DIR__ . '/TypeSchema/test_schema.json')),
        ]);

        $container = [];
        $history = Middleware::history($container);

        $stack = HandlerStack::create($mock);
        $stack->push($history);

        $client = new Client\Client(['handler' => $stack]);

        $parser = new Parser\File(new SchemaManager(null, $client));
        $schema = $parser->parse(__DIR__ . '/TypeSchema/test_schema_external.json');

        $this->assertEquals('RootType', $schema->getRoot());

        $root = $schema->getDefinitions()->getType($schema->getRoot());
        $this->assertInstanceOf(StructDefinitionType::class, $root);

        $reference = $root->getProperty('user');
        $this->assertInstanceOf(ReferencePropertyType::class, $reference);

        $type = $schema->getDefinitions()->getType($reference->getTarget());
        $this->assertInstanceOf(StructDefinitionType::class, $type);

        $this->assertEquals(1, count($container));
        $transaction = array_shift($container);

        $this->assertEquals('GET', $transaction['request']->getMethod());
        $this->assertEquals(['acme.com'], $transaction['request']->getHeader('Host'));
    }

    public function testParseTypeHubResource()
    {
        $client = new Client\Client();
        $parser = new Parser\File(new SchemaManager(null, $client));
        $schema = $parser->parse(__DIR__ . '/TypeSchema/test_schema_typehub.json');

        $this->assertEquals('RootType', $schema->getRoot());

        $root = $schema->getDefinitions()->getType($schema->getRoot());
        $this->assertInstanceOf(StructDefinitionType::class, $root);

        $reference = $root->getProperty('software');
        $this->assertInstanceOf(ReferencePropertyType::class, $reference);

        $type = $schema->getDefinitions()->getType($reference->getTarget());
        $this->assertInstanceOf(StructDefinitionType::class, $type);
    }

    public function testParseNestedImport()
    {
        $parser = new Parser\File(new SchemaManager());
        $schema = $parser->parse(__DIR__ . '/TypeSchema/test_schema_import.json', new Parser\Context\FilesystemContext(__DIR__ . '/TypeSchema'));

        /** @var StructDefinitionType $type */
        $type = $schema->getDefinitions()->getType('Test');
        $this->assertInstanceOf(StructDefinitionType::class, $type);

        $reference = $type->getProperty('foo');
        $this->assertInstanceOf(ReferencePropertyType::class, $reference);
        $this->assertEquals('foo:Import', $reference->getTarget());
        $this->assertInstanceOf(StructDefinitionType::class, $schema->getDefinitions()->getType($reference->getTarget()));

        $reference = $type->getProperty('bar');
        $this->assertInstanceOf(ReferencePropertyType::class, $reference);
        $this->assertEquals('my_import:Student', $reference->getTarget());
        $this->assertInstanceOf(StructDefinitionType::class, $schema->getDefinitions()->getType($reference->getTarget()));
    }

    public function testParseInvalidFile()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessageMatches('/^Could not load external schema (.*)$/');

        $parser = new Parser\File(new SchemaManager());
        $parser->parse(__DIR__ . '/TypeSchema/foo.json');
    }
}
