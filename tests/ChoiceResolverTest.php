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
use PSX\Schema\Builder;
use PSX\Schema\ChoiceResolver;
use PSX\Schema\Property\ChoiceType;
use PSX\Schema\Property\ComplexType;
use PSX\Schema\SchemaManager;

/**
 * ChoiceResolverTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ChoiceResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \PSX\Schema\Property\ChoiceType
     */
    protected $choiceType;

    /**
     * @var \PSX\Schema\ChoiceResolverInterface
     */
    protected $choiceResolver;

    protected function setUp()
    {
        $builder = new Builder('a');
        $builder->string('foo');
        $builder->string('bar')->setRequired(true);
        $complexA = $builder->getProperty();

        $builder = new Builder('b');
        $builder->string('foo');
        $builder->string('baz')->setRequired(true);
        $complexB = $builder->getProperty();

        $builder = new Builder('c');
        $complexC = $builder->getProperty();

        $choiceType = new ChoiceType('choice');
        $choiceType->add($complexA);
        $choiceType->add($complexB);
        $choiceType->add($complexC);

        $this->choiceType     = $choiceType;
        $this->choiceResolver = new ChoiceResolver();
    }

    public function testGetProperty()
    {
        $data = [
            'foo' => 'test',
            'bar' => 'test',
        ];

        $property = $this->choiceResolver->getProperty($data, '/', $this->choiceType);
        
        $this->assertInstanceOf('PSX\Schema\Property\ComplexType', $property);
    }

    public function testGetPropertyNoProperties()
    {
        $data = [
            'foo' => 'test',
            'bar' => 'test',
        ];

        $property = $this->choiceResolver->getProperty($data, '/', new ChoiceType('choice'));
        
        $this->assertEquals(null, $property);
    }

    public function testGetPropertyNoMatch()
    {
        $data = [
            'faz' => 'test',
        ];

        $property = $this->choiceResolver->getProperty($data, '/', new ChoiceType('choice'));

        $this->assertEquals(null, $property);
    }

    public function testGetTypes()
    {
        $types = $this->choiceResolver->getTypes($this->choiceType);
        
        $this->assertEquals(['a' => null, 'b' => null, 'c' => null], $types);
    }
}
