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

namespace PSX\Schema\Tests\Generator;

use PSX\Schema\Generator\JsonSchema;

/**
 * JsonSchemaTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class JsonSchemaTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $generator = new JsonSchema();
        $result    = $generator->generate($this->getSchema());

        $expect = <<<'JSON'
{
    "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
    "id": "urn:schema.phpsx.org#",
    "definitions": {
        "ref72828040aecd82459c3636a4226e81fc": {
            "title": "config",
            "type": "object",
            "additionalProperties": {
                "type": "string"
            }
        },
        "refb33b896fd4135c2882510d8949e883cf": {
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
            "additionalProperties": true
        },
        "ref4770be5abc2aedca274241c166226fc7": {
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
                        "$ref": "#\/definitions\/refb33b896fd4135c2882510d8949e883cf"
                    },
                    "title": "locations",
                    "description": "Array of locations"
                },
                "origin": {
                    "$ref": "#\/definitions\/refb33b896fd4135c2882510d8949e883cf"
                }
            },
            "additionalProperties": false,
            "required": [
                "title"
            ]
        },
        "ref57c64cac92e27c1db99e6a6793546e12": {
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
            "maxProperties": 8
        },
        "ref4898a93cd82b117833f9683324e0f6dd": {
            "title": "resource",
            "oneOf": [
                {
                    "$ref": "#\/definitions\/refb33b896fd4135c2882510d8949e883cf"
                },
                {
                    "$ref": "#\/definitions\/ref57c64cac92e27c1db99e6a6793546e12"
                }
            ]
        },
        "ref20f5d15c759c1d56a2ed0675fe4b4a0b": {
            "title": "source",
            "oneOf": [
                {
                    "$ref": "#\/definitions\/ref4770be5abc2aedca274241c166226fc7"
                },
                {
                    "$ref": "#\/definitions\/ref57c64cac92e27c1db99e6a6793546e12"
                }
            ]
        },
        "ref68a5de1071c84dc3c357e50c05e674fa": {
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
                    "$ref": "#\/definitions\/refb33b896fd4135c2882510d8949e883cf"
                }
            },
            "additionalProperties": false
        }
    },
    "title": "news",
    "description": "An general news entry",
    "type": "object",
    "properties": {
        "config": {
            "$ref": "#\/definitions\/ref72828040aecd82459c3636a4226e81fc"
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
                "$ref": "#\/definitions\/ref4770be5abc2aedca274241c166226fc7"
            },
            "title": "receiver",
            "minItems": 1
        },
        "resources": {
            "type": "array",
            "items": {
                "$ref": "#\/definitions\/ref4898a93cd82b117833f9683324e0f6dd"
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
            "$ref": "#\/definitions\/ref20f5d15c759c1d56a2ed0675fe4b4a0b"
        },
        "author": {
            "$ref": "#\/definitions\/ref4770be5abc2aedca274241c166226fc7"
        },
        "meta": {
            "$ref": "#\/definitions\/ref68a5de1071c84dc3c357e50c05e674fa"
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
    ]
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $result, $result);
    }
}
