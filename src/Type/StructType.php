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
use PSX\Schema\TypeInterface;

/**
 * StructType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class StructType extends ObjectType
{
    /**
     * @var string
     */
    protected $extends;

    /**
     * @var array
     */
    protected $properties;

    /**
     * @var array
     */
    protected $required;

    /**
     * @return string
     */
    public function getExtends(): ?string
    {
        return $this->extends;
    }

    /**
     * @param string $extends
     */
    public function setExtends(string $extends): void
    {
        $this->extends = $extends;
    }

    /**
     * @return array
     */
    public function getProperties(): ?array
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     * @return self
     * @throws InvalidSchemaException
     */
    public function setProperties(array $properties): self
    {
        $this->properties = [];
        foreach ($properties as $name => $property) {
            $this->addProperty($name, $property);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param \PSX\Schema\TypeInterface $property
     * @return self
     * @throws InvalidSchemaException
     */
    public function addProperty(string $name, TypeInterface $property): self
    {
        TypeAssert::assertProperty($property);

        $this->properties[$name] = $property;

        return $this;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\TypeInterface
     */
    public function getProperty(string $name): ?TypeInterface
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasProperty(string $name): bool
    {
        return isset($this->properties[$name]);
    }

    /**
     * @param string $name
     * @return self
     */
    public function removeProperty(string $name): self
    {
        if (isset($this->properties[$name])) {
            unset($this->properties[$name]);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getRequired(): ?array
    {
        return $this->required;
    }

    /**
     * @param array $required
     * @return self
     */
    public function setRequired(array $required): self
    {
        $this->required = $required;

        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), array_filter([
            '$extends' => $this->extends,
            'type' => 'object',
            'properties' => $this->properties,
            'required' => $this->required,
        ], function($value){
            return $value !== null;
        }));
    }

    public function __clone()
    {
        if ($this->properties !== null) {
            $properties = $this->properties;
            $this->properties = [];

            foreach ($properties as $name => $property) {
                $this->properties[$name] = clone $property;
            }
        }
    }
}
