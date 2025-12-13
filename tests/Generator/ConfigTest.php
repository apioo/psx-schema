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

namespace PSX\Schema\Tests\Generator;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PSX\Schema\Generator\Config;

/**
 * ConfigTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ConfigTest extends TestCase
{
    #[DataProvider('toStringProvider')]
    public function testToString(array $value, string $expect)
    {
        $config = Config::fromArray($value);

        $this->assertEquals($expect, $config->toString());
    }

    public static function toStringProvider(): array
    {
        return [
            [[], 'e30='],
            [[], 'e30='],
            [[], 'e30='],
            [['foo' => ''], 'eyJmb28iOiIifQ=='],
            [['foo' => 'bar'], 'eyJmb28iOiJiYXIifQ=='],
            [['foo' => ['test' => 'bar']], 'eyJmb28iOnsidGVzdCI6ImJhciJ9fQ=='],
        ];
    }

    #[DataProvider('queryStringProvider')]
    public function testFromQueryString(mixed $value, array $expect)
    {
        $config = Config::fromQueryString($value);

        $this->assertInstanceOf(Config::class, $config);
        $this->assertEquals($expect, $config->getAll());
    }

    public static function queryStringProvider(): array
    {
        return [
            [null, []],
            ['', []],
            [' ', []],
            ['foo', ['foo' => '']],
            ['foo=bar', ['foo' => 'bar']],
            ['foo[test]=bar', ['foo' => ['test' => 'bar']]],
        ];
    }

    #[DataProvider('base64StringProvider')]
    public function testFromBase64String(string $value, object $expect)
    {
        $config = Config::fromBase64String($value);

        $this->assertInstanceOf(Config::class, $config);
        $this->assertJsonStringEqualsJsonString(\json_encode($expect), \json_encode($config));
    }

    public static function base64StringProvider(): array
    {
        return [
            ['e30=', (object) []],
            ['e30=', (object) []],
            ['e30=', (object) []],
            ['eyJmb28iOiIifQ==', (object) ['foo' => '']],
            ['eyJmb28iOiJiYXIifQ==', (object) ['foo' => 'bar']],
            ['eyJmb28iOnsidGVzdCI6ImJhciJ9fQ==', (object) ['foo' => (object) ['test' => 'bar']]],
        ];
    }
}