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

namespace PSX\Schema\Generator;

use PSX\Schema\PropertyInterface;

/**
 * MarkupAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
abstract class MarkupAbstract extends CodeGeneratorAbstract
{
    /**
     * @var integer
     */
    protected $heading;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @param integer $heading
     * @param string $prefix
     */
    public function __construct($heading = 1, string $prefix = 'psx_model_')
    {
        parent::__construct();

        $this->heading = $heading >= 1 && $heading <= 6 ? $heading : 1;
        $this->prefix  = $prefix;
    }

    /**
     * @param \PSX\Schema\PropertyInterface $property
     * @return array
     */
    protected function getConstraints(PropertyInterface $property)
    {
        $constraints = [];

        // array
        $minItems = $property->getMinItems();
        if ($minItems !== null) {
            $constraints['minItems'] = $minItems;
        }

        $maxItems = $property->getMaxItems();
        if ($maxItems !== null) {
            $constraints['maxItems'] = $maxItems;
        }

        // number
        $minimum = $property->getMinimum();
        if ($minimum !== null) {
            $constraints['minimum'] = $minimum;
        }

        $maximum = $property->getMaximum();
        if ($maximum !== null) {
            $constraints['maximum'] = $maximum;
        }

        $multipleOf = $property->getMultipleOf();
        if ($multipleOf !== null) {
            $constraints['multipleOf'] = $multipleOf;
        }

        // string
        $minLength = $property->getMinLength();
        if ($minLength !== null) {
            $constraints['minLength'] = $minLength;
        }

        $maxLength = $property->getMaxLength();
        if ($maxLength !== null) {
            $constraints['maxLength'] = $maxLength;
        }

        $pattern = $property->getPattern();
        if ($pattern !== null) {
            $constraints['pattern'] = $pattern;
        }

        $enum = $property->getEnum();
        if ($enum !== null) {
            $constraints['enum'] = $enum;
        }

        $const = $property->getConst();
        if ($const !== null) {
            $constraints['const'] = $const;
        }

        return $constraints;
    }
}
