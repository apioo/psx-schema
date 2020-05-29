<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\StringType;
use PSX\Schema\TypeInterface;

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
    public function __construct(int $heading = 1, string $prefix = 'psx_model_')
    {
        parent::__construct();

        $this->heading = $heading >= 1 && $heading <= 6 ? $heading : 1;
        $this->prefix  = $prefix;
    }

    /**
     * @param \PSX\Schema\TypeInterface $type
     * @return array
     */
    protected function getConstraints(TypeInterface $type)
    {
        $constraints = [];

        if ($type instanceof ArrayType) {
            $minItems = $type->getMinItems();
            if ($minItems !== null) {
                $constraints['minItems'] = $minItems;
            }

            $maxItems = $type->getMaxItems();
            if ($maxItems !== null) {
                $constraints['maxItems'] = $maxItems;
            }
        } elseif ($type instanceof NumberType) {
            $minimum = $type->getMinimum();
            if ($minimum !== null) {
                $constraints['minimum'] = $minimum;
            }

            $maximum = $type->getMaximum();
            if ($maximum !== null) {
                $constraints['maximum'] = $maximum;
            }

            $multipleOf = $type->getMultipleOf();
            if ($multipleOf !== null) {
                $constraints['multipleOf'] = $multipleOf;
            }
        } elseif ($type instanceof StringType) {
            $minLength = $type->getMinLength();
            if ($minLength !== null) {
                $constraints['minLength'] = $minLength;
            }

            $maxLength = $type->getMaxLength();
            if ($maxLength !== null) {
                $constraints['maxLength'] = $maxLength;
            }

            $pattern = $type->getPattern();
            if ($pattern !== null) {
                $constraints['pattern'] = $pattern;
            }
        }

        if ($type instanceof ScalarType) {
            $enum = $type->getEnum();
            if ($enum !== null) {
                $constraints['enum'] = $enum;
            }

            $const = $type->getConst();
            if ($const !== null) {
                $constraints['const'] = $const;
            }
        }

        return $constraints;
    }
}
