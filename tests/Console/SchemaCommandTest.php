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
use PSX\Schema\Tests\Parser\Popo\Complexb35219bc;
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
            'source' => Complexb35219bc::class,
            'format' => 'jsonschema',
        ));

        $actual = $commandTester->getDisplay();
        $expect = <<<'JSON'
{
    "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
    "id": "urn:schema.phpsx.org#",
    "definitions": {
        "ref5525537f7f38b6988025ca659a7b315d": {
            "title": "config",
            "type": "object",
            "additionalProperties": {
                "type": "string"
            },
            "reference": "PSX\\Schema\\Tests\\Parser\\Popo\\Complex5525537f"
        },
        "ref73afba2a3732aa422e2dede6fd26d0cb": {
            "title": "location",
            "description": "Location of the person",
            "type": "object",
            "properties": {
                "lat": {
                    "type": "number"
                },
                "long": {
                    "type": "number"
                }
            },
            "additionalProperties": true,
            "reference": "PSX\\Schema\\Tests\\Parser\\Popo\\Complex73afba2a"
        },
        "ref3b735bb119d1f8f279637029c0d482e1": {
            "title": "author",
            "description": "An simple author element with some description",
            "type": "object",
            "properties": {
                "title": {
                    "type": "string",
                    "pattern": "[A-z]{3,16}"
                },
                "email": {
                    "description": "We will send no spam to this addresss",
                    "type": "string"
                },
                "categories": {
                    "type": "array",
                    "items": {
                        "type": "string"
                    },
                    "title": "categories",
                    "maxItems": 8
                },
                "locations": {
                    "type": "array",
                    "items": {
                        "$ref": "#\/definitions\/ref73afba2a3732aa422e2dede6fd26d0cb"
                    },
                    "title": "locations",
                    "description": "Array of locations"
                },
                "origin": {
                    "$ref": "#\/definitions\/ref73afba2a3732aa422e2dede6fd26d0cb"
                }
            },
            "additionalProperties": false,
            "required": [
                "title"
            ],
            "reference": "PSX\\Schema\\Tests\\Parser\\Popo\\Complex3b735bb1"
        },
        "ref55c1692462753300d5eecf90dc979d09": {
            "title": "web",
            "description": "An application",
            "type": "object",
            "properties": {
                "name": {
                    "type": "string"
                },
                "url": {
                    "type": "string"
                }
            },
            "additionalProperties": {
                "type": "string"
            },
            "minProperties": 2,
            "maxProperties": 8,
            "reference": "PSX\\Schema\\Tests\\Parser\\Popo\\Complex55c16924"
        },
        "ref0ae50ca2769f912fdb609180fef2ab22": {
            "oneOf": [
                {
                    "$ref": "#\/definitions\/ref73afba2a3732aa422e2dede6fd26d0cb"
                },
                {
                    "$ref": "#\/definitions\/ref55c1692462753300d5eecf90dc979d09"
                }
            ]
        },
        "ref4041e76cd4c2d30153165760e80c506e": {
            "title": "source",
            "oneOf": [
                {
                    "$ref": "#\/definitions\/ref3b735bb119d1f8f279637029c0d482e1"
                },
                {
                    "$ref": "#\/definitions\/ref55c1692462753300d5eecf90dc979d09"
                }
            ]
        },
        "refa80788599984d8da6729b8be82b7a016": {
            "title": "meta",
            "description": "Some meta data",
            "type": "object",
            "properties": {
                "createDate": {
                    "type": "string",
                    "format": "date-time"
                }
            },
            "patternProperties": {
                "^tags_\\d$": {
                    "type": "string"
                },
                "^location_\\d$": {
                    "$ref": "#\/definitions\/ref73afba2a3732aa422e2dede6fd26d0cb"
                }
            },
            "additionalProperties": false,
            "reference": "PSX\\Schema\\Tests\\Parser\\Popo\\Complexa8078859"
        }
    },
    "title": "news",
    "description": "An general news entry",
    "type": "object",
    "properties": {
        "config": {
            "$ref": "#\/definitions\/ref5525537f7f38b6988025ca659a7b315d"
        },
        "tags": {
            "type": "array",
            "items": {
                "type": "string"
            },
            "title": "tags",
            "minItems": 1,
            "maxItems": 6
        },
        "receiver": {
            "type": "array",
            "items": {
                "$ref": "#\/definitions\/ref3b735bb119d1f8f279637029c0d482e1"
            },
            "title": "receiver",
            "minItems": 1
        },
        "resources": {
            "type": "array",
            "items": {
                "$ref": "#\/definitions\/ref0ae50ca2769f912fdb609180fef2ab22"
            },
            "title": "resources"
        },
        "profileImage": {
            "type": "string",
            "format": "base64"
        },
        "read": {
            "type": "boolean"
        },
        "source": {
            "$ref": "#\/definitions\/ref4041e76cd4c2d30153165760e80c506e"
        },
        "author": {
            "$ref": "#\/definitions\/ref3b735bb119d1f8f279637029c0d482e1"
        },
        "meta": {
            "$ref": "#\/definitions\/refa80788599984d8da6729b8be82b7a016"
        },
        "sendDate": {
            "type": "string",
            "format": "date"
        },
        "readDate": {
            "type": "string",
            "format": "date-time"
        },
        "expires": {
            "type": "string",
            "format": "duration"
        },
        "price": {
            "type": "number",
            "minimum": 1,
            "maximum": 100
        },
        "rating": {
            "type": "integer",
            "minimum": 1,
            "maximum": 5
        },
        "content": {
            "description": "Contains the main content of the news entry",
            "type": "string",
            "minLength": 3,
            "maxLength": 512
        },
        "question": {
            "type": "string",
            "enum": [
                "foo",
                "bar"
            ]
        },
        "coffeeTime": {
            "type": "string",
            "format": "time"
        },
        "profileUri": {
            "type": "string",
            "format": "uri"
        }
    },
    "additionalProperties": false,
    "required": [
        "receiver",
        "price",
        "content"
    ],
    "reference": "PSX\\Schema\\Tests\\Parser\\Popo\\Complexb35219bc"
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
