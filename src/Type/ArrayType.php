<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Schema\TypeAssert;
use PSX\Schema\TypeInterface;

/**
 * ArrayType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ArrayType extends TypeAbstract
{
    /**
     * @var TypeInterface
     */
    protected $items;

    /**
     * @var integer
     */
    protected $minItems;

    /**
     * @var integer
     */
    protected $maxItems;

    /**
     * @var boolean
     */
    protected $uniqueItems;

    /**
     * @return TypeInterface
     */
    public function getItems(): ?TypeInterface
    {
        return $this->items;
    }

    /**
     * @param TypeInterface $items
     * @return self
     */
    public function setItems(TypeInterface $items): self
    {
        TypeAssert::assertItem($items);

        $this->items = $items;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinItems(): ?int
    {
        return $this->minItems;
    }

    /**
     * @param int $minItems
     * @return self
     */
    public function setMinItems(int $minItems): self
    {
        $this->minItems = $minItems;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxItems(): ?int
    {
        return $this->maxItems;
    }

    /**
     * @param int $maxItems
     * @return self
     */
    public function setMaxItems(int $maxItems): self
    {
        $this->maxItems = $maxItems;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUniqueItems(): ?bool
    {
        return $this->uniqueItems;
    }

    /**
     * @param bool $uniqueItems
     * @return self
     */
    public function setUniqueItems(bool $uniqueItems): self
    {
        $this->uniqueItems = $uniqueItems;

        return $this;
    }
    
    public function toArray(): array
    {
        return array_merge(parent::toArray(), array_filter([
            'type' => 'array',
            'items' => $this->items,
            'minItems' => $this->minItems,
            'maxItems' => $this->maxItems,
            'uniqueItems' => $this->uniqueItems,
        ], function($value){
            return $value !== null;
        }));
    }

    public function __clone()
    {
        if ($this->items !== null) {
            $items = $this->items;
            if ($items instanceof TypeInterface) {
                $this->items = clone $items;
            }
        }
    }
}
