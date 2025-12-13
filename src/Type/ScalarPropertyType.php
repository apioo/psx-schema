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

namespace PSX\Schema\Type;

use PSX\Schema\Format;

/**
 * ScalarType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class ScalarPropertyType extends PropertyTypeAbstract
{
    protected ?Format $format = null;
    protected ?string $default = null;

    public function getFormat(): ?Format
    {
        return $this->format;
    }

    public function setFormat(Format $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function getDefault(): ?string
    {
        return $this->default;
    }

    public function setDefault(?string $default): void
    {
        $this->default = $default;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), array_filter([
            'format' => $this->format?->value,
            'default' => $this->default,
        ], function($value){
            return $value !== null;
        }));
    }
}
