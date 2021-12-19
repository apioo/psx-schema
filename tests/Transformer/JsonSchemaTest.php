<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Tests\Transformer;

use PHPUnit\Framework\TestCase;
use PSX\Schema\Transformer\JsonSchema;

/**
 * JsonSchemaTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class JsonSchemaTest extends TestCase
{
    /**
     * @dataProvider testProvider
     */
    public function testConvert(string $file)
    {
        $schema = file_get_contents(__DIR__ . '/jsonschema/actual/' . $file);
        $actual = (new JsonSchema())->transform(\json_decode($schema));

        $expectFile = __DIR__ . '/jsonschema/expect/' . $file;

        $this->assertJsonStringEqualsJsonFile($expectFile, \json_encode($actual));
    }

    public function testProvider(): array
    {
        $result = [];
        $tests = scandir(__DIR__ . '/jsonschema/actual');
        foreach ($tests as $file) {
            if ($file[0] === '.') {
                continue;
            }

            $result[] = [$file];
        }

        return $result;
    }
}
