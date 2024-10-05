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

use PHPUnit\Framework\TestCase;
use PSX\Schema\Builder;
use PSX\Schema\ObjectMapper;
use PSX\Schema\SchemaManager;
use PSX\Schema\Tests\Parser\Popo\Attribute\News;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\Factory\PropertyTypeFactory;
use PSX\Schema\Type\StructDefinitionType;

/**
 * ObjectMapperTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ObjectMapperTest extends TestCase
{
    public function testRead()
    {
        $json = <<<'JSON'
{
  "content": "foobar"
}
JSON;

        $objectMapper = $this->newObjectMapper();
        $news = $objectMapper->readJson($json, News::class);

        $this->assertInstanceOf(News::class, $news);
        $this->assertEquals('foobar', $news->getContent());
    }

    public function testWrite()
    {
        $news = new News();
        $news->setContent('foobar');

        $objectMapper = $this->newObjectMapper();
        $json = $objectMapper->writeJson($news);

        $expect = <<<'JSON'
{
  "content": "foobar"
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $json);
    }

    private function newObjectMapper(): ObjectMapper
    {
        return new ObjectMapper(new SchemaManager());
    }
}
