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

/**
 * StructDefinitionType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class StructDefinitionType extends DefinitionTypeAbstract
{
    protected ?string $parent = null;
    protected ?bool $base = null;
    protected ?array $properties = null;
    protected ?string $discriminator = null;
    protected ?array $mapping = null;
    protected ?array $template = null;

    protected function getType(): string
    {
        return 'struct';
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }

    public function setParent(string $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getBase(): ?bool
    {
        return $this->base;
    }

    public function setBase(?bool $base): self
    {
        $this->base = $base;

        return $this;
    }

    public function getProperties(): ?array
    {
        return $this->properties;
    }

    public function setProperties(array $properties): self
    {
        $this->properties = [];
        foreach ($properties as $name => $property) {
            $this->addProperty($name, $property);
        }

        return $this;
    }

    public function addProperty(string $name, PropertyTypeAbstract $property): self
    {
        $this->properties[$name] = $property;

        return $this;
    }

    public function getProperty(string $name): ?PropertyTypeAbstract
    {
        return $this->properties[$name] ?? null;
    }

    public function hasProperty(string $name): bool
    {
        return isset($this->properties[$name]);
    }

    public function removeProperty(string $name): self
    {
        if (isset($this->properties[$name])) {
            unset($this->properties[$name]);
        }

        return $this;
    }

    public function getDiscriminator(): ?string
    {
        return $this->discriminator;
    }

    public function setDiscriminator(?string $discriminator): self
    {
        $this->discriminator = $discriminator;

        return $this;
    }

    public function getMapping(): ?array
    {
        return $this->mapping;
    }

    public function setMapping(?array $mapping): self
    {
        $this->mapping = $mapping;

        return $this;
    }

    public function getTemplate(): ?array
    {
        return $this->template;
    }

    public function setTemplate(?array $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), array_filter([
            'parent' => $this->parent,
            'base' => $this->base,
            'properties' => $this->properties,
            'discriminator' => $this->discriminator,
            'mapping' => $this->mapping,
            'template' => $this->template,
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
