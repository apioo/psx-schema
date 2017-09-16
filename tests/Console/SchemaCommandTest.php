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
        $expect = file_get_contents(__DIR__ . '/popo.json');

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

        $expect = file_get_contents(__DIR__ . '/html.htm');

        $this->assertXmlStringEqualsXmlString('<div>' . $expect . '</div>', '<div>' . $actual . '</div>', $actual);
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
