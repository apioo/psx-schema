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

namespace PSX\Schema\Type;

use InvalidArgumentException;

/**
 * NumberType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class NumberType extends ScalarType
{
    /**
     * @var integer|float
     */
    protected $minimum;

    /**
     * @var integer|float
     */
    protected $maximum;

    /**
     * @var boolean
     */
    protected $exclusiveMinimum;

    /**
     * @var boolean
     */
    protected $exclusiveMaximum;

    /**
     * @var integer
     */
    protected $multipleOf;

    /**
     * @return int|float
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * @param int|float $minimum
     * @return self
     */
    public function setMinimum($minimum): self
    {
        if ($minimum !== null && !is_int($minimum) && !is_float($minimum)) {
            throw new InvalidArgumentException('Minimum must be either an integer or float');
        }

        $this->minimum = $minimum;

        return $this;
    }

    /**
     * @return int|float
     */
    public function getMaximum()
    {
        return $this->maximum;
    }

    /**
     * @param int|float $maximum
     * @return self
     */
    public function setMaximum($maximum): self
    {
        if ($maximum !== null && !is_int($maximum) && !is_float($maximum)) {
            throw new InvalidArgumentException('Maximum must be either an integer or float');
        }

        $this->maximum = $maximum;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getExclusiveMinimum(): ?bool
    {
        return $this->exclusiveMinimum;
    }

    /**
     * @param boolean $exclusiveMinimum
     * @return self
     */
    public function setExclusiveMinimum(bool $exclusiveMinimum): self
    {
        $this->exclusiveMinimum = $exclusiveMinimum;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getExclusiveMaximum(): ?bool
    {
        return $this->exclusiveMaximum;
    }

    /**
     * @param boolean $exclusiveMaximum
     * @return self
     */
    public function setExclusiveMaximum(bool $exclusiveMaximum): self
    {
        $this->exclusiveMaximum = $exclusiveMaximum;

        return $this;
    }

    /**
     * @return int|float
     */
    public function getMultipleOf()
    {
        return $this->multipleOf;
    }

    /**
     * @param int|float $multipleOf
     * @return self
     */
    public function setMultipleOf($multipleOf): self
    {
        $this->multipleOf = $multipleOf;

        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), array_filter([
            'type' => 'number',
            'minimum' => $this->minimum,
            'maximum' => $this->maximum,
            'exclusiveMinimum' => $this->exclusiveMinimum,
            'exclusiveMaximum' => $this->exclusiveMaximum,
            'multipleOf' => $this->multipleOf,
        ], function($value){
            return $value !== null;
        }));
    }
}
