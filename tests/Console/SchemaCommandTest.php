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

namespace PSX\Schema\Tests\Console;

use Doctrine\Common\Annotations\SimpleAnnotationReader;
use PSX\Schema\Console\SchemaCommand;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * SchemaCommandTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testCommand()
    {
        $reader = new SimpleAnnotationReader();
        $reader->addNamespace('PSX\\Schema\\Parser\\Popo\\Annotation');

        $command = new SchemaCommand($reader, 'urn:phpsx.org');

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'parser' => 'popo',
            'source' => 'PSX\Schema\Tests\Parser\Popo\News',
            'format' => 'jsonschema',
        ));

        $actual = $commandTester->getDisplay();
        $expect = <<<'JSON'
{
    "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
    "id": "urn:schema.phpsx.org#",
    "type": "object",
    "title": "record",
    "definitions": {
        "ref55c6af017850766bb43c35c3a5308cf8": {
            "type": "object",
            "properties": {
                "id": {
                    "type": "integer"
                },
                "name": {
                    "type": "string"
                },
                "email": {
                    "type": "string"
                }
            },
            "title": "author",
            "reference": "PSX\\Schema\\Tests\\Parser\\Popo\\Author",
            "additionalProperties": false
        },
        "ref8ea17bd280ad7a490807842559096981": {
            "type": "object",
            "properties": {
                "id": {
                    "type": "integer"
                },
                "author": {
                    "$ref": "#\/definitions\/ref55c6af017850766bb43c35c3a5308cf8"
                },
                "text": {
                    "type": "string"
                }
            },
            "reference": "PSX\\Schema\\Tests\\Parser\\Popo\\Comment",
            "additionalProperties": false
        }
    },
    "properties": {
        "id": {
            "type": "integer"
        },
        "title": {
            "type": "string"
        },
        "author": {
            "$ref": "#\/definitions\/ref55c6af017850766bb43c35c3a5308cf8"
        },
        "comments": {
            "type": "array",
            "items": {
                "$ref": "#\/definitions\/ref8ea17bd280ad7a490807842559096981"
            },
            "title": "comments"
        },
        "date": {
            "type": "string",
            "format": "date-time"
        }
    },
    "reference": "PSX\\Schema\\Tests\\Parser\\Popo\\News",
    "additionalProperties": false
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
