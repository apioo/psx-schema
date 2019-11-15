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

use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;

/**
 * StructType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class StructType extends PropertyType
{
    /**
     * @var array
     */
    protected $properties;

    /**
     * @var array
     */
    protected $required;

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
     */
    public function setProperties(array $properties): self
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @param string $name
     * @param \PSX\Schema\PropertyInterface $property
     * @return self
     */
    public function addProperty($name, PropertyInterface $property): self
    {
        $this->properties[$name] = $property;

        return $this;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function getProperty($name): ?PropertyInterface
    {
        return isset($this->properties[$name]) ? $this->properties[$name] : null;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasProperty($name): bool
    {
        return isset($this->properties[$name]);
    }

    /**
     * @param string $name
     * @return self
     */
    public function removeProperty($name): self
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
                $this->properties[$name] = clone $properties[$name];
            }
        }
    }
}
