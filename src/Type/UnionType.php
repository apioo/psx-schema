<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

/**
 * UnionType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class UnionType extends TypeAbstract
{
    /**
     * @var array
     */
    protected $oneOf;

    /**
     * @var string
     */
    protected $propertyName;

    /**
     * @var array
     */
    protected $mapping;

    /**
     * @return array
     */
    public function getOneOf(): ?array
    {
        return $this->oneOf;
    }

    /**
     * @param array $oneOf
     * @return self
     * @throws InvalidSchemaException
     */
    public function setOneOf(array $oneOf): self
    {
        TypeAssert::assertUnion($oneOf);

        $this->oneOf = $oneOf;

        return $this;
    }

    /**
     * @param string $propertyName
     * @param array|null $mapping
     * @return $this
     */
    public function setDiscriminator(string $propertyName, ?array $mapping = null): self
    {
        $this->propertyName = $propertyName;
        $this->mapping = $mapping;

        return $this;
    }

    /**
     * @return string
     */
    public function getPropertyName(): ?string
    {
        return $this->propertyName;
    }

    /**
     * @return array
     */
    public function getMapping(): ?array
    {
        return $this->mapping;
    }

    public function toArray(): array
    {
        $discriminator = null;
        if ($this->propertyName !== null) {
            $discriminator = [
                'propertyName' => $this->propertyName,
            ];

            if (!empty($this->mapping)) {
                $discriminator['mapping'] = $this->mapping;
            }
        }

        return array_merge(parent::toArray(), array_filter([
            'oneOf' => $this->oneOf,
            'discriminator' => $discriminator,
        ], function($value){
            return $value !== null;
        }));
    }
}
