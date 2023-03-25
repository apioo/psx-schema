<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use PSX\Schema\Parser\TypeSchema;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StructType;
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
        $schema = TypeSchema::fromFile(__DIR__ . '/TypeSchema/test_schema.json');

        $this->assertSchema($this->getSchema(), $schema);
    }

    public function testParseTypeSchema()
    {
        $schema = TypeSchema::fromFile(__DIR__ . '/TypeSchema/typeschema.json');
        $type   = $schema->getType();

        $this->assertInstanceOf(TypeInterface::class, $type);
    }

    public function testDiscriminator()
    {
        $schema = TypeSchema::fromFile(__DIR__ . '/TypeSchema/form_container.json');

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

        $client   = new Client\Client(['handler' => $stack]);
        $resolver = TypeSchema\ImportResolver::createDefault($client);

        $parser = new TypeSchema($resolver);
        $schema = $parser->parse(file_get_contents(__DIR__ . '/TypeSchema/test_schema_external.json'));

        /** @var StructType $type */
        $type = $schema->getType();
        $this->assertInstanceOf(StructType::class, $type);
        $reference = $type->getProperty('user');
        $this->assertInstanceOf(ReferenceType::class, $reference);

        $type = $schema->getDefinitions()->getType($reference->getRef());
        $this->assertInstanceOf(StructType::class, $type);

        $this->assertEquals(1, count($container));
        $transaction = array_shift($container);

        $this->assertEquals('GET', $transaction['request']->getMethod());
        $this->assertEquals(['acme.com'], $transaction['request']->getHeader('Host'));
    }

    public function testParseTypeHubResource()
    {
        $client = new Client\Client();
        $parser = new TypeSchema(TypeSchema\ImportResolver::createDefault($client));
        $schema = $parser->parse(file_get_contents(__DIR__ . '/TypeSchema/test_schema_typehub.json'));

        /** @var StructType $type */
        $type = $schema->getType();
        $this->assertInstanceOf(StructType::class, $type);
        $reference = $type->getProperty('software');
        $this->assertInstanceOf(ReferenceType::class, $reference);

        $type = $schema->getDefinitions()->getType($reference->getRef());
        $this->assertInstanceOf(StructType::class, $type);
    }

    public function testParseInvalidFile()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('/^Could not load json schema (.*)$/');

        TypeSchema::fromFile(__DIR__ . '/TypeSchema/foo.json');
    }
}
