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
use PSX\Schema\Parser\Popo;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManager;
use PSX\Schema\Tests\Parser\Popo\News;
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
        $actual = preg_replace('/psx-type-([0-9A-Fa-f]{32})/', 'psx-type-[id]', $actual);
        
        $expect = <<<'HTML'
<?xml version="1.0"?>
<div>
  <div class="psx-complex-type" id="psx-type-[id]">
    <h1>json schema</h1>
    <small>http://json-schema.org/draft-04/schema</small>
    <div class="psx-type-description">Core schema meta-schema</div>
    <table class="table psx-type-properties">
      <colgroup>
        <col width="20%"/>
        <col width="20%"/>
        <col width="40%"/>
        <col width="20%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Property</th>
          <th>Type</th>
          <th>Description</th>
          <th>Constraints</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">id</span>
          </td>
          <td>
            <span class="psx-property-type">
              <a href="http://tools.ietf.org/html/rfc3986" title="RFC3339">URI</a>
            </span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">$schema</span>
          </td>
          <td>
            <span class="psx-property-type">
              <a href="http://tools.ietf.org/html/rfc3986" title="RFC3339">URI</a>
            </span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">title</span>
          </td>
          <td>
            <span class="psx-property-type">String</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">description</span>
          </td>
          <td>
            <span class="psx-property-type">String</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">default</span>
          </td>
          <td/>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">multipleOf</span>
          </td>
          <td>
            <span class="psx-property-type">Number</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td>
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
            <span class="psx-property-type">Number</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">exclusiveMaximum</span>
          </td>
          <td>
            <span class="psx-property-type">Boolean</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">minimum</span>
          </td>
          <td>
            <span class="psx-property-type">Number</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">exclusiveMinimum</span>
          </td>
          <td>
            <span class="psx-property-type">Boolean</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">maxLength</span>
          </td>
          <td>
            <span class="psx-property-type">Integer</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td>
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
            <span class="psx-property-type">AllOf ( | )</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">pattern</span>
          </td>
          <td>
            <span class="psx-property-type">String</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">additionalItems</span>
          </td>
          <td>
            <span class="psx-property-type">AnyOf (<span class="psx-property-type">Boolean</span> | )</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">items</span>
          </td>
          <td>
            <span class="psx-property-type">AnyOf ( | <span class="psx-property-type psx-property-type-array">Array ()</span>)</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">maxItems</span>
          </td>
          <td/>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">minItems</span>
          </td>
          <td/>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">uniqueItems</span>
          </td>
          <td>
            <span class="psx-property-type">Boolean</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">maxProperties</span>
          </td>
          <td/>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">minProperties</span>
          </td>
          <td/>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">required</span>
          </td>
          <td>
            <span class="psx-property-type psx-property-type-array">Array (<span class="psx-property-type">String</span>)</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td>
            <dl class="psx-property-constraint">
              <dt>Minimum</dt>
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
            <span class="psx-property-type">AnyOf (<span class="psx-property-type">Boolean</span> | )</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">definitions</span>
          </td>
          <td>
            <span class="psx-property-type psx-property-type-complex">
              <a href="#psx-type-[id]">Object</a>
            </span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">properties</span>
          </td>
          <td>
            <span class="psx-property-type psx-property-type-complex">
              <a href="#psx-type-[id]">Object</a>
            </span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">patternProperties</span>
          </td>
          <td>
            <span class="psx-property-type psx-property-type-complex">
              <a href="#psx-type-[id]">Object</a>
            </span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">dependencies</span>
          </td>
          <td>
            <span class="psx-property-type psx-property-type-complex">
              <a href="#psx-type-[id]">Object</a>
            </span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">enum</span>
          </td>
          <td>
            <span class="psx-property-type psx-property-type-array">Array ()</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td>
            <dl class="psx-property-constraint">
              <dt>Minimum</dt>
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
            <span class="psx-property-type">AnyOf ( | <span class="psx-property-type psx-property-type-array">Array ()</span>)</span>
          </td>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">allOf</span>
          </td>
          <td/>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">anyOf</span>
          </td>
          <td/>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">oneOf</span>
          </td>
          <td/>
          <td>
            <span class="psx-property-description"/>
          </td>
          <td/>
        </tr>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">not</span>
          </td>
          <td/>
          <td>
            <span class="psx-property-description">Core schema meta-schema</span>
          </td>
          <td/>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="psx-complex-type" id="psx-type-[id]">
    <h1>Object</h1>
    <table class="table psx-type-properties">
      <colgroup>
        <col width="20%"/>
        <col width="20%"/>
        <col width="40%"/>
        <col width="20%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Property</th>
          <th>Type</th>
          <th>Description</th>
          <th>Constraints</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">*</span>
          </td>
          <td/>
          <td>
            <span class="psx-property-description">Additional properties must be of this type</span>
          </td>
          <td/>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="psx-complex-type" id="psx-type-[id]">
    <h1>Object</h1>
    <table class="table psx-type-properties">
      <colgroup>
        <col width="20%"/>
        <col width="20%"/>
        <col width="40%"/>
        <col width="20%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Property</th>
          <th>Type</th>
          <th>Description</th>
          <th>Constraints</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">*</span>
          </td>
          <td/>
          <td>
            <span class="psx-property-description">Additional properties must be of this type</span>
          </td>
          <td/>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="psx-complex-type" id="psx-type-[id]">
    <h1>Object</h1>
    <table class="table psx-type-properties">
      <colgroup>
        <col width="20%"/>
        <col width="20%"/>
        <col width="40%"/>
        <col width="20%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Property</th>
          <th>Type</th>
          <th>Description</th>
          <th>Constraints</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">*</span>
          </td>
          <td/>
          <td>
            <span class="psx-property-description">Additional properties must be of this type</span>
          </td>
          <td/>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="psx-complex-type" id="psx-type-[id]">
    <h1>Object</h1>
    <table class="table psx-type-properties">
      <colgroup>
        <col width="20%"/>
        <col width="20%"/>
        <col width="40%"/>
        <col width="20%"/>
      </colgroup>
      <thead>
        <tr>
          <th>Property</th>
          <th>Type</th>
          <th>Description</th>
          <th>Constraints</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            <span class="psx-property-name psx-property-optional">*</span>
          </td>
          <td>
            <span class="psx-property-type">AnyOf ( | )</span>
          </td>
          <td>
            <span class="psx-property-description">Additional properties must be of this type</span>
          </td>
          <td/>
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
        $reader = new SimpleAnnotationReader();
        $reader->addNamespace('PSX\\Schema\\Parser\\Popo\\Annotation');

        return new SchemaCommand(new SchemaManager($reader), 'urn:phpsx.org');
    }
}
