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

namespace PSX\Schema\Tests;

use Doctrine\Common\Annotations\SimpleAnnotationReader;
use PSX\Schema\Property\ArrayType;
use PSX\Schema\Property\ComplexType;
use PSX\Schema\Property\CompositeTypeAbstract;
use PSX\Schema\PropertyAbstract;
use PSX\Schema\PropertyInterface;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManager;

/**
 * SchemaTestCase
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
abstract class SchemaTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    protected $reader;

    /**
     * @var \PSX\Schema\SchemaManager
     */
    protected $schemaManager;

    protected function setUp()
    {
        $this->reader = new SimpleAnnotationReader();
        $this->reader->addNamespace('PSX\\Schema\\Parser\\Popo\\Annotation');

        $this->schemaManager = new SchemaManager($this->reader);
    }

    protected function getSchema()
    {
        return $this->schemaManager->getSchema('PSX\Schema\Tests\TestSchema');
    }

    protected function assertSchema($leftSchema, $rightSchema)
    {
        $this->assertInstanceOf('PSX\\Schema\\SchemaInterface', $leftSchema);
        $this->assertInstanceOf('PSX\\Schema\\SchemaInterface', $rightSchema);
        $this->assertProperty($leftSchema->getDefinition(), $rightSchema->getDefinition());
    }

    protected function assertProperty($leftProperty, $rightProperty)
    {
        $this->assertInstanceOf('PSX\\Schema\\PropertyInterface', $leftProperty);
        $this->assertInstanceOf('PSX\\Schema\\PropertyInterface', $rightProperty);
        $this->assertInstanceOf(get_class($leftProperty), $rightProperty);

        if ($leftProperty instanceof PropertyAbstract && $rightProperty instanceof PropertyAbstract) {
            $this->assertEquals($leftProperty->isRequired(), $rightProperty->isRequired());
        }

        if ($leftProperty instanceof ComplexType && $rightProperty instanceof ComplexType) {
            $leftProperties  = $leftProperty->getPatternProperties();
            $rightProperties = $rightProperty->getPatternProperties();

            $this->assertEquals(array_keys($leftProperties), array_keys($rightProperties));

            $leftProperties  = $leftProperty->getAdditionalProperties();
            $rightProperties = $rightProperty->getAdditionalProperties();
            
            if (is_bool($leftProperties) && is_bool($rightProperties)) {
                $this->assertEquals($leftProperties, $rightProperties);
            } elseif ($leftProperties instanceof PropertyInterface && $rightProperties instanceof PropertyInterface) {
                $this->assertProperty($leftProperties, $rightProperties);
            }
        }

        if ($leftProperty instanceof CompositeTypeAbstract && $rightProperty instanceof CompositeTypeAbstract) {
            $leftProperties  = $leftProperty->getProperties();
            $rightProperties = $rightProperty->getProperties();

            $this->assertEquals(array_keys($leftProperties), array_keys($rightProperties));

            foreach ($leftProperties as $key => $leftProp) {
                $this->assertProperty($leftProp, $rightProperties[$key]);
            }
        }

        $this->assertEquals($leftProperty->getId(), $rightProperty->getId());
    }
}
