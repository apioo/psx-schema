<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\SimpleAnnotationReader;
use PSX\Schema\Console\SchemaCommand;
use PSX\Schema\Parser\Popo;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManager;
use PSX\Schema\Tests\Parser\Popo\News;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * SchemaCommandTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateJsonSchemaPopo()
    {
        $command = $this->getSchemaCommand();

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'source' => News::class,
            'format' => 'jsonschema',
        ));

        $actual = $commandTester->getDisplay();
        $expect = <<<'JSON'
{
    "$schema": "http:\/\/json-schema.org\/draft-04\/schema#",
    "id": "urn:schema.phpsx.org#",
    "definitions": {
        "Config": {
            "type": "object",
            "title": "config",
            "additionalProperties": {
                "type": "string"
            },
            "class": "PSX\\Schema\\Tests\\Parser\\Popo\\Config"
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
            ],
            "class": "PSX\\Schema\\Tests\\Parser\\Popo\\Location"
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
            ],
            "class": "PSX\\Schema\\Tests\\Parser\\Popo\\Author"
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
            ],
            "class": "PSX\\Schema\\Tests\\Parser\\Popo\\Web"
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
            "additionalProperties": false,
            "class": "PSX\\Schema\\Tests\\Parser\\Popo\\Meta"
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
    ],
    "class": "PSX\\Schema\\Tests\\Parser\\Popo\\News"
}
JSON;

        $this->assertJsonStringEqualsJsonString($expect, $actual, $actual);
    }

    public function testGenerateJsonSchemaSwagger()
    {
        $command = $this->getSchemaCommand();

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'source' => __DIR__ . '/../Parser/JsonSchema/swagger.json',
            'format' => 'php',
        ));

        $actual = $commandTester->getDisplay();

        file_put_contents(__DIR__ . '/generated_swagger.php', $actual);

        include_once __DIR__ . '/generated_swagger.php';

        $reader = new SimpleAnnotationReader();
        $reader->addNamespace('PSX\\Schema\\Parser\\Popo\\Annotation');

        $parser = new Popo($reader);
        $schema = $parser->parse(\PSX\Generation\A_JSON_Schema_for_Swagger_____API_::class);

        $this->assertInstanceOf('PSX\Schema\SchemaInterface', $schema);
    }

    public function testGenerateJsonSchemaJsonSchema()
    {
        $command = $this->getSchemaCommand();

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'source' => __DIR__ . '/../Parser/JsonSchema/schema.json',
            'format' => 'php',
        ));

        $actual = $commandTester->getDisplay();

        file_put_contents(__DIR__ . '/generated_jsonschema.php', $actual);

        include_once __DIR__ . '/generated_jsonschema.php';

        $reader = new SimpleAnnotationReader();
        $reader->addNamespace('PSX\\Schema\\Parser\\Popo\\Annotation');

        $parser = new Popo($reader);
        $schema = $parser->parse(\PSX\Generation\Json_schema::class);

        $this->assertInstanceOf('PSX\Schema\SchemaInterface', $schema);
    }

    public function testCommandGenerateHtml()
    {
        $command = $this->getSchemaCommand();

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'source' => __DIR__ . '/../Parser/JsonSchema/schema.json',
            'format' => 'html',
        ));

        $actual = $commandTester->getDisplay();
        $actual = preg_replace('/psx_model_Object([0-9A-Fa-f]{8})/', '[dynamic_id]', $actual);

        $expect = <<<'HTML'
<?xml version="1.0"?>
<div>
  <div class="psx-object" id="psx_model_Json_schema">
    <h1>json schema</h1>
    <div class="psx-object-description">Core schema meta-schema</div>
    <pre class="psx-object-json">
      <span class="psx-object-json-pun">{</span>
      <span class="psx-object-json-key">"id"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">
        <a href="http://tools.ietf.org/html/rfc3986" title="RFC3339">URI</a>
      </span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"$schema"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">
        <a href="http://tools.ietf.org/html/rfc3986" title="RFC3339">URI</a>
      </span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"title"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">String</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"description"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">String</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"default"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Mixed</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"multipleOf"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Number</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"maximum"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Number</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"exclusiveMaximum"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Boolean</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"minimum"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Number</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"exclusiveMinimum"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Boolean</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"maxLength"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Integer</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"minLength"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Mixed</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"pattern"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">String</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"additionalItems"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Mixed</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"items"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Mixed</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"maxItems"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Integer</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"minItems"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Mixed</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"uniqueItems"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Boolean</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"maxProperties"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Integer</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"minProperties"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Mixed</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"required"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type">String</span>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"additionalProperties"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Mixed</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"definitions"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-object">Object (<a href="#[dynamic_id]">Object</a>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"properties"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-object">Object (<a href="#[dynamic_id]">Object</a>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"patternProperties"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-object">Object (<a href="#[dynamic_id]">Object</a>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"dependencies"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-object">Object (<a href="#[dynamic_id]">Object</a>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"enum"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-array">Array ()</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"type"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Mixed</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"allOf"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"anyOf"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"oneOf"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-key">"not"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-pun">}</span>
    </pre>
    <table class="table psx-object-properties">
      <colgroup>
        <col width="30%"/>
        <col width="70%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Field</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">id</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">
                <a href="http://tools.ietf.org/html/rfc3986" title="RFC3339">URI</a>
              </span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">$schema</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">
                <a href="http://tools.ietf.org/html/rfc3986" title="RFC3339">URI</a>
              </span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">title</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">String</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">description</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">String</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">default</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Mixed</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">multipleOf</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Number</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>Minimum</dt>
              <dd>
                <span class="psx-constraint-minimum">0</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">maximum</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Number</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">exclusiveMaximum</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Boolean</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">minimum</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Number</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">exclusiveMinimum</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Boolean</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">maxLength</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Integer</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>Minimum</dt>
              <dd>
                <span class="psx-constraint-minimum">0</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">minLength</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Mixed</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>AllOf</dt>
              <dd>
                <ul class="psx-property-combination">
                  <li>
                    <span class="psx-property-type">Integer</span>
                  </li>
                  <li>
                    <span class="psx-property-type">Mixed</span>
                  </li>
                </ul>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">pattern</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">String</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">additionalItems</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Mixed</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>AnyOf</dt>
              <dd>
                <ul class="psx-property-combination">
                  <li>
                    <span class="psx-property-type">Boolean</span>
                  </li>
                  <li>
                    <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>
                  </li>
                </ul>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">items</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Mixed</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>AnyOf</dt>
              <dd>
                <ul class="psx-property-combination">
                  <li>
                    <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>
                  </li>
                  <li>
                    <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>)</span>
                  </li>
                </ul>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">maxItems</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Integer</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>Minimum</dt>
              <dd>
                <span class="psx-constraint-minimum">0</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">minItems</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Mixed</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>AllOf</dt>
              <dd>
                <ul class="psx-property-combination">
                  <li>
                    <span class="psx-property-type">Integer</span>
                  </li>
                  <li>
                    <span class="psx-property-type">Mixed</span>
                  </li>
                </ul>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">uniqueItems</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Boolean</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">maxProperties</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Integer</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>Minimum</dt>
              <dd>
                <span class="psx-constraint-minimum">0</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">minProperties</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Mixed</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>AllOf</dt>
              <dd>
                <ul class="psx-property-combination">
                  <li>
                    <span class="psx-property-type">Integer</span>
                  </li>
                  <li>
                    <span class="psx-property-type">Mixed</span>
                  </li>
                </ul>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">required</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type">String</span>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>MinItems</dt>
              <dd>
                <span class="psx-constraint-minimum">1</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">additionalProperties</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Mixed</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>AnyOf</dt>
              <dd>
                <ul class="psx-property-combination">
                  <li>
                    <span class="psx-property-type">Boolean</span>
                  </li>
                  <li>
                    <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>
                  </li>
                </ul>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">definitions</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-object">Object (<a href="#[dynamic_id]">Object</a>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">properties</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-object">Object (<a href="#[dynamic_id]">Object</a>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">patternProperties</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-object">Object (<a href="#[dynamic_id]">Object</a>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">dependencies</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-object">Object (<a href="#[dynamic_id]">Object</a>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">enum</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-array">Array ()</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>MinItems</dt>
              <dd>
                <span class="psx-constraint-minimum">1</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">type</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Mixed</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>AnyOf</dt>
              <dd>
                <ul class="psx-property-combination">
                  <li>
                    <span class="psx-property-type">Mixed</span>
                  </li>
                  <li>
                    <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type">Mixed</span>)</span>
                  </li>
                </ul>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">allOf</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>MinItems</dt>
              <dd>
                <span class="psx-constraint-minimum">1</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">anyOf</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>MinItems</dt>
              <dd>
                <span class="psx-constraint-minimum">1</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">oneOf</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>)</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>MinItems</dt>
              <dd>
                <span class="psx-constraint-minimum">1</span>
              </dd>
            </dl>
          </td>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">not</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>
            </span>
            <br/>
            <div class="psx-property-description">Core schema meta-schema</div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="psx-object" id="[dynamic_id]">
    <h1>Object</h1>
    <pre class="psx-object-json">
      <span class="psx-object-json-pun">{</span>
      <span class="psx-object-json-key">"*"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-pun">}</span>
    </pre>
    <table class="table psx-object-properties">
      <colgroup>
        <col width="30%"/>
        <col width="70%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Field</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">*</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>
            </span>
            <br/>
            <div class="psx-property-description">Core schema meta-schema</div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="psx-object" id="[dynamic_id]">
    <h1>Object</h1>
    <pre class="psx-object-json">
      <span class="psx-object-json-pun">{</span>
      <span class="psx-object-json-key">"*"</span>
      <span class="psx-object-json-pun">: </span>
      <span class="psx-property-type">Mixed</span>
      <span class="psx-object-json-pun">,</span>
      <span class="psx-object-json-pun">}</span>
    </pre>
    <table class="table psx-object-properties">
      <colgroup>
        <col width="30%"/>
        <col width="70%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Field</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">*</span>
          </td>
          <td>
            <span class="psx-property-type">
              <span class="psx-property-type">Mixed</span>
            </span>
            <br/>
            <div class="psx-property-description"/>
            <dl class="psx-property-constraint">
              <dt>AnyOf</dt>
              <dd>
                <ul class="psx-property-combination">
                  <li>
                    <span class="psx-property-type psx-property-type-object">Object (<a href="#psx_model_Json_schema">json schema</a>)</span>
                  </li>
                  <li>
                    <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type">String</span>)</span>
                  </li>
                </ul>
              </dd>
            </dl>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
HTML;

        $this->assertXmlStringEqualsXmlString($expect, '<div>' . $actual . '</div>', $actual);
    }

    public function testCommandGenerateSerialize()
    {
        $command = $this->getSchemaCommand();

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'source' => __DIR__ . '/../Parser/JsonSchema/schema.json',
            'format' => 'serialize',
        ));

        $actual = $commandTester->getDisplay();
        $schema = unserialize($actual);

        $this->assertInstanceOf(SchemaInterface::class, $schema);
    }

    protected function getSchemaCommand()
    {
        return new SchemaCommand(new SchemaManager(new AnnotationReader()));
    }
}
