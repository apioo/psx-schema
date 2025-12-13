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

use PHPUnit\Framework\Attributes\DataProvider;
use PSX\Schema\Exception\InvalidSchemaException;
use PSX\Schema\SchemaSource;

/**
 * SchemaSourceTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class SchemaSourceTest extends SchemaTestCase
{
    public function testFile()
    {
        $source = SchemaSource::fromFile(__DIR__ . '/BuilderTest.php');

        $this->assertEquals('file', $source->getScheme());
        $this->assertEquals('/BuilderTest.php', str_replace(__DIR__, '', $source->getSource()));
        $this->assertEquals('file:///BuilderTest.php', str_replace(__DIR__, '', (string) $source));
    }

    public function testFileInvalid()
    {
        $this->expectException(InvalidSchemaException::class);

        SchemaSource::fromFile(__DIR__ . '/foo.txt');
    }

    public function testUrlHttp()
    {
        $source = SchemaSource::fromUrl('http://typeschema.org/spec.json');

        $this->assertEquals('http', $source->getScheme());
        $this->assertEquals('typeschema.org/spec.json', $source->getSource());
        $this->assertEquals('http://typeschema.org/spec.json', (string) $source);
    }

    public function testUrlHttps()
    {
        $source = SchemaSource::fromUrl('https://typeschema.org/spec.json');

        $this->assertEquals('https', $source->getScheme());
        $this->assertEquals('typeschema.org/spec.json', $source->getSource());
        $this->assertEquals('https://typeschema.org/spec.json', (string) $source);
    }

    public function testUrlInvalid()
    {
        $this->expectException(InvalidSchemaException::class);

        SchemaSource::fromUrl('foobar');
    }

    public function testClass()
    {
        $source = SchemaSource::fromClass(SchemaSourceTest::class);

        $this->assertEquals('php+class', $source->getScheme());
        $this->assertEquals('PSX.Schema.Tests.SchemaSourceTest', $source->getSource());
        $this->assertEquals('php+class://PSX.Schema.Tests.SchemaSourceTest', (string) $source);
    }

    public function testClassInvalid()
    {
        $this->expectException(InvalidSchemaException::class);

        SchemaSource::fromClass('foobar');
    }

    public function testType()
    {
        $source = SchemaSource::fromType('array<string, string>');

        $this->assertEquals('php+doc', $source->getScheme());
        $this->assertEquals('array<string, string>', $source->getSource());
        $this->assertEquals('php+doc://array<string, string>', (string) $source);
    }

    public function testTypeHub()
    {
        $source = SchemaSource::fromTypeHub('apioo', 'software', '0.1.2');

        $this->assertEquals('typehub', $source->getScheme());
        $this->assertEquals('apioo:software@0.1.2', $source->getSource());
        $this->assertEquals('typehub://apioo:software@0.1.2', (string) $source);
    }

    #[DataProvider('stringProvider')]
    public function testString(string $string, string $expectString)
    {
        $this->assertEquals($expectString, (string) SchemaSource::fromString($string));
    }

    public static function stringProvider(): array
    {
        return [
            [__DIR__ . '/BuilderTest.php', 'file://' . __DIR__ . '/BuilderTest.php'],
            ['http://typeschema.org/spec.json', 'http://typeschema.org/spec.json'],
            ['https://typeschema.org/spec.json', 'https://typeschema.org/spec.json'],
            [SchemaSourceTest::class, 'php+class://' . str_replace('\\', '.', SchemaSourceTest::class)],
            ['array<string, string>', 'php+doc://array<string, string>'],
        ];
    }
}
