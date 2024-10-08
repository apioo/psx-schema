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

namespace PSX\Schema\Tests\Parser;

use PSX\Schema\SchemaInterface;
use PSX\Schema\Tests\SchemaTestCase;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\Type\UnionType;

/**
 * ParserTestCase
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class ParserTestCase extends SchemaTestCase
{
    protected function assertDiscriminator(SchemaInterface $schema): void
    {
        /** @var StructDefinitionType $container */
        $element = $schema->getDefinitions()->getType('Form_Element');
        $this->assertInstanceOf(StructDefinitionType::class, $element);

        $expect = [
            'Form_Element_Input' => 'http://fusio-project.org/ns/2015/form/input',
            'Form_Element_Select' => 'http://fusio-project.org/ns/2015/form/select',
            'Form_Element_Tag' => 'http://fusio-project.org/ns/2015/form/tag',
            'Form_Element_TextArea' => 'http://fusio-project.org/ns/2015/form/textarea',
        ];

        $this->assertEquals('element', $element->getDiscriminator());
        $this->assertEquals($expect, $element->getMapping());
    }
}
