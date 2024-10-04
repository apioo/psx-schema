<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\ScalarPropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\TypeInterface;

/**
 * MarkupAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class MarkupAbstract extends CodeGeneratorAbstract
{
    protected int $heading;
    protected string $prefix;

    public function __construct(?Config $config = null)
    {
        parent::__construct();

        $heading = (int) $config?->get('heading');

        $this->heading = $heading >= 1 && $heading <= 6 ? $heading : 1;
        $this->prefix  = $config?->get('prefix') ?? 'psx_model_';
    }

    protected function getConstraints(TypeInterface $type): array
    {
        $constraints = [];

        if ($type instanceof ArrayPropertyType) {
            $minItems = $type->getMinItems();
            if ($minItems !== null) {
                $constraints['minItems'] = $minItems;
            }

            $maxItems = $type->getMaxItems();
            if ($maxItems !== null) {
                $constraints['maxItems'] = $maxItems;
            }
        } elseif ($type instanceof NumberPropertyType) {
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
        } elseif ($type instanceof StringPropertyType) {
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

        if ($type instanceof ScalarPropertyType) {
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
