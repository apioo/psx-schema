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

namespace PSX\Schema\Tests\Document;

use PHPUnit\Framework\TestCase;
use PSX\Schema\Document\Document;
use PSX\Schema\Document\Type;
use Symfony\Component\Yaml\Yaml;

/**
 * DocumentTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class DocumentTest extends TestCase
{
    public function testDocumentJson()
    {
        $json     = \json_decode(file_get_contents(__DIR__ . '/document.json'));
        $document = Document::from($json);

        $this->assertDocument($document);
    }

    public function testDocumentYaml()
    {
        $yaml     = Yaml::parse(file_get_contents(__DIR__ . '/document.json'));
        $document = Document::from($yaml);

        $this->assertDocument($document);
    }

    protected function assertDocument(Document $document)
    {
        $this->assertEquals(4, count($document->getTypes()));

        $type = $document->getType($document->indexOf('Product'));
        $this->assertInstanceOf(Type::class, $type);
        $this->assertEquals('Product', $type->getName());
        $this->assertEquals('object', $type->getType());
    }
}
