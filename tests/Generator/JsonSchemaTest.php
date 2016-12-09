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
        "Object79a542c6": {
            "type": "object",
            "additionalProperties": {
                "type": "string"
            }
        },
        "Location": {
            "type": "object",
            "title": "location",
            "description": "Location of the person",
            "properties": {
                "lat": {
                    "type": "number"
                },
                "long": {
                    "type": "number"
                }
            },
            "additionalProperties": true,
            "required": [
                "lat",
                "long"
            ]
        },
        "Author": {
            "type": "object",
            "title": "author",
            "description": "An simple author element with some description",
            "properties": {
                "title": {
                    "type": "string",
                    "pattern": "[A-z]{3,16}"
                },
                "email": {
                    "type": "string",
                    "description": "We will send no spam to this addresss"
                },
                "categories": {
                    "type": "array",
                    "items": {
                        "type": "string"
                    },
                    "maxItems": 8
                },
                "locations": {
                    "type": "array",
                    "description": "Array of locations",
                    "items": {
                        "$ref": "#\/definitions\/Location"
                    }
                },
                "origin": {
                    "$ref": "#\/definitions\/Location"
                }
            },
            "additionalProperties": false,
            "required": [
                "title"
            ]
        },
        "Web": {
            "type": "object",
            "title": "web",
            "description": "An application",
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
            "required": [
                "name",
                "url"
            ]
        },
        "Meta": {
            "type": "object",
            "title": "meta",
            "description": "Some meta data",
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
                    "$ref": "#\/definitions\/Location"
                }
            },
            "additionalProperties": false
        }
    },
    "type": "object",
    "title": "news",
    "description": "An general news entry",
    "properties": {
        "config": {
            "$ref": "#\/definitions\/Object79a542c6"
        },
        "tags": {
            "type": "array",
            "items": {
                "type": "string"
            },
            "minItems": 1,
            "maxItems": 6
        },
        "receiver": {
            "type": "array",
            "items": {
                "$ref": "#\/definitions\/Author"
            },
            "minItems": 1
        },
        "resources": {
            "type": "array",
            "items": {
                "oneOf": [
                    {
                        "$ref": "#\/definitions\/Location"
                    },
                    {
                        "$ref": "#\/definitions\/Web"
                    }
                ]
            }
        },
        "profileImage": {
            "type": "string",
            "format": "base64"
        },
        "read": {
            "type": "boolean"
        },
        "source": {
            "oneOf": [
                {
                    "$ref": "#\/definitions\/Author"
                },
                {
                    "$ref": "#\/definitions\/Web"
                }
            ]
        },
        "author": {
            "$ref": "#\/definitions\/Author"
        },
        "meta": {
            "$ref": "#\/definitions\/Meta"
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
            "type": "string",
            "description": "Contains the main content of the news entry",
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
