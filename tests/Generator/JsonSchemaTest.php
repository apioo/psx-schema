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
use PSX\Schema\Parser;

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
        $actual    = $generator->generate($this->getSchema());
        $expect    = <<<'JSON'
{
    "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
    "id": "urn:schema.phpsx.org#",
    "definitions": {
        "Config": {
            "type": "object",
            "title": "config",
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
            "$ref": "#\/definitions\/Config"
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

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testGenerateRecursive()
    {
        $schema    = Parser\JsonSchema::fromFile(__DIR__ . '/../Parser/JsonSchema/schema.json');
        $generator = new JsonSchema();
        $actual    = $generator->generate($schema);
        $expect    = <<<'JSON'
{
    "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
    "id": "urn:schema.phpsx.org#",
    "definitions": {
        "ObjectId": {
            "type": "object",
            "additionalProperties": {
                "$ref": "#"
            }
        },
        "ObjectId": {
            "type": "object",
            "additionalProperties": {
                "anyOf": [
                    {
                        "$ref": "#"
                    },
                    {
                        "type": "array",
                        "items": {
                            "type": "string"
                        },
                        "minItems": 1,
                        "uniqueItems": true
                    }
                ]
            }
        }
    },
    "type": "object",
    "title": "json schema",
    "description": "Core schema meta-schema",
    "properties": {
        "id": {
            "type": "string",
            "format": "uri"
        },
        "$schema": {
            "type": "string",
            "format": "uri"
        },
        "title": {
            "type": "string"
        },
        "description": {
            "type": "string"
        },
        "default": {},
        "multipleOf": {
            "type": "number",
            "minimum": 0,
            "exclusiveMinimum": true
        },
        "maximum": {
            "type": "number"
        },
        "exclusiveMaximum": {
            "type": "boolean"
        },
        "minimum": {
            "type": "number"
        },
        "exclusiveMinimum": {
            "type": "boolean"
        },
        "maxLength": {
            "type": "integer",
            "minimum": 0
        },
        "minLength": {
            "allOf": [
                {
                    "type": "integer",
                    "minimum": 0
                },
                {}
            ]
        },
        "pattern": {
            "type": "string",
            "format": "regex"
        },
        "additionalItems": {
            "anyOf": [
                {
                    "type": "boolean"
                },
                {
                    "$ref": "#"
                }
            ]
        },
        "items": {
            "anyOf": [
                {
                    "$ref": "#"
                },
                {
                    "type": "array",
                    "items": {
                        "$ref": "#"
                    },
                    "minItems": 1
                }
            ]
        },
        "maxItems": {
            "type": "integer",
            "minimum": 0
        },
        "minItems": {
            "allOf": [
                {
                    "type": "integer",
                    "minimum": 0
                },
                {}
            ]
        },
        "uniqueItems": {
            "type": "boolean"
        },
        "maxProperties": {
            "type": "integer",
            "minimum": 0
        },
        "minProperties": {
            "allOf": [
                {
                    "type": "integer",
                    "minimum": 0
                },
                {}
            ]
        },
        "required": {
            "type": "array",
            "items": {
                "type": "string"
            },
            "minItems": 1,
            "uniqueItems": true
        },
        "additionalProperties": {
            "anyOf": [
                {
                    "type": "boolean"
                },
                {
                    "$ref": "#"
                }
            ]
        },
        "definitions": {
            "$ref": "#\/definitions\/ObjectId"
        },
        "properties": {
            "$ref": "#\/definitions\/ObjectId"
        },
        "patternProperties": {
            "$ref": "#\/definitions\/ObjectId"
        },
        "dependencies": {
            "$ref": "#\/definitions\/ObjectId"
        },
        "enum": {
            "type": "array",
            "minItems": 1,
            "uniqueItems": true
        },
        "type": {
            "anyOf": [
                {
                    "enum": [
                        "array",
                        "boolean",
                        "integer",
                        "null",
                        "number",
                        "object",
                        "string"
                    ]
                },
                {
                    "type": "array",
                    "items": {
                        "enum": [
                            "array",
                            "boolean",
                            "integer",
                            "null",
                            "number",
                            "object",
                            "string"
                        ]
                    },
                    "minItems": 1,
                    "uniqueItems": true
                }
            ]
        },
        "allOf": {
            "type": "array",
            "items": {
                "$ref": "#"
            },
            "minItems": 1
        },
        "anyOf": {
            "type": "array",
            "items": {
                "$ref": "#"
            },
            "minItems": 1
        },
        "oneOf": {
            "type": "array",
            "items": {
                "$ref": "#"
            },
            "minItems": 1
        },
        "not": {
            "$ref": "#"
        }
    },
    "dependencies": {
        "exclusiveMaximum": [
            "maximum"
        ],
        "exclusiveMinimum": [
            "minimum"
        ]
    }
}
JSON;

        $actual = preg_replace('/Object([0-9A-Fa-f]{8})/', 'ObjectId', $actual);
        
        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }
}
