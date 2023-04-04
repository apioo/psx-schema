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
use PSX\Schema\TypeAssert;
use PSX\Schema\TypeInterface;

/**
 * MapType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class MapType extends ObjectType
{
    protected TypeInterface|bool|null $additionalProperties = null;
    protected ?int $minProperties = null;
    protected ?int $maxProperties = null;

    public function getAdditionalProperties(): TypeInterface|bool|null
    {
        return $this->additionalProperties;
    }

    /**
     * @throws InvalidSchemaException
     */
    public function setAdditionalProperties(TypeInterface|bool $additionalProperties): self
    {
        if ($additionalProperties === false) {
            throw new InvalidSchemaException('Map additional properties must not be false only true is allowed as boolean value');
        } elseif ($additionalProperties instanceof TypeInterface) {
            TypeAssert::assertProperty($additionalProperties);
        }

        $this->additionalProperties = $additionalProperties;

        return $this;
    }

    public function getMinProperties(): ?int
    {
        return $this->minProperties;
    }

    public function setMinProperties(int $minProperties): self
    {
        $this->minProperties = $minProperties;

        return $this;
    }

    public function getMaxProperties(): ?int
    {
        return $this->maxProperties;
    }

    public function setMaxProperties(int $maxProperties): self
    {
        $this->maxProperties = $maxProperties;
        
        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), array_filter([
            'type' => 'object',
            'additionalProperties' => $this->additionalProperties,
            'minProperties' => $this->minProperties,
            'maxProperties' => $this->maxProperties,
        ], function($value){
            return $value !== null;
        }));
    }

    public function __clone()
    {
        if ($this->additionalProperties !== null) {
            $additionalProperties = $this->additionalProperties;
            if ($additionalProperties instanceof TypeInterface) {
                $this->additionalProperties = clone $additionalProperties;
            }
        }
    }
}
