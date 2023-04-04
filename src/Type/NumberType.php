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

namespace PSX\Schema\Type;

use PSX\Schema\Exception\InvalidSchemaException;

/**
 * NumberType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class NumberType extends ScalarType
{
    protected int|float|null $minimum = null;
    protected int|float|null $maximum = null;
    protected ?bool $exclusiveMinimum = null;
    protected ?bool $exclusiveMaximum = null;
    protected int|float|null $multipleOf = null;

    public function getMinimum(): float|int|null
    {
        return $this->minimum;
    }

    /**
     * @throws InvalidSchemaException
     */
    public function setMinimum(int|float $minimum): self
    {
        $this->minimum = $minimum;

        return $this;
    }

    public function getMaximum(): float|int|null
    {
        return $this->maximum;
    }

    public function setMaximum(int|float $maximum): self
    {
        $this->maximum = $maximum;

        return $this;
    }

    public function getExclusiveMinimum(): ?bool
    {
        return $this->exclusiveMinimum;
    }

    public function setExclusiveMinimum(bool $exclusiveMinimum): self
    {
        $this->exclusiveMinimum = $exclusiveMinimum;

        return $this;
    }

    public function getExclusiveMaximum(): ?bool
    {
        return $this->exclusiveMaximum;
    }

    public function setExclusiveMaximum(bool $exclusiveMaximum): self
    {
        $this->exclusiveMaximum = $exclusiveMaximum;

        return $this;
    }

    public function getMultipleOf(): float|int|null
    {
        return $this->multipleOf;
    }

    public function setMultipleOf(int|float $multipleOf): self
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
        ], function ($value) {
            return $value !== null;
        }));
    }
}
