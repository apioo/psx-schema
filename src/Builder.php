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

namespace PSX\Schema;

use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\BooleanPropertyType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\Factory\DefinitionTypeFactory;
use PSX\Schema\Type\Factory\PropertyTypeFactory;
use PSX\Schema\Type\IntegerPropertyType;
use PSX\Schema\Type\MapPropertyType;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;

/**
 * Builder to create a struct type with specific properties
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Builder
{
    private StructDefinitionType $type;

    public function __construct()
    {
        $this->type = DefinitionTypeFactory::getStruct();
    }

    public function setDescription(string $description): Builder
    {
        $this->type->setDescription($description);

        return $this;
    }

    public function setParent(string $parent): Builder
    {
        $this->type->setParent($parent);

        return $this;
    }

    public function setBase(bool $base): Builder
    {
        $this->type->setBase($base);

        return $this;
    }

    public function setDiscriminator(string $discriminator): Builder
    {
        $this->type->setDiscriminator($discriminator);

        return $this;
    }

    public function setMapping(array $mapping): Builder
    {
        $this->type->setMapping($mapping);

        return $this;
    }

    public function setTemplate(array $template): Builder
    {
        $this->type->setTemplate($template);

        return $this;
    }

    public function setClass(string $class): Builder
    {
        $this->type->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, $class);

        return $this;
    }

    public function setAttribute(string $key, mixed $value): Builder
    {
        $this->type->setAttribute($key, $value);

        return $this;
    }

    /**
     * @template T of PropertyTypeAbstract
     * @param T $type
     * @return T
     */
    public function add(string $name, PropertyTypeAbstract $type): PropertyTypeAbstract
    {
        $this->type->addProperty($name, $type);

        return $type;
    }

    public function addArray(string $name, PropertyTypeAbstract $schema): ArrayPropertyType
    {
        return $this->add($name, PropertyTypeFactory::getArray($schema));
    }

    public function addMap(string $name, PropertyTypeAbstract $schema): MapPropertyType
    {
        return $this->add($name, PropertyTypeFactory::getMap($schema));
    }

    public function addBoolean(string $name): BooleanPropertyType
    {
        return $this->add($name, PropertyTypeFactory::getBoolean());
    }

    public function addInteger(string $name): IntegerPropertyType
    {
        return $this->add($name, PropertyTypeFactory::getInteger());
    }

    public function addNumber(string $name): NumberPropertyType
    {
        return $this->add($name, PropertyTypeFactory::getNumber());
    }

    public function addReference(string $name, string $target): ReferencePropertyType
    {
        return $this->add($name, PropertyTypeFactory::getReference($target));
    }

    public function addString(string $name): StringPropertyType
    {
        return $this->add($name, PropertyTypeFactory::getString());
    }

    public function addDateTime(string $name): StringPropertyType
    {
        return $this->add($name, PropertyTypeFactory::getDateTime());
    }

    public function addDate(string $name): StringPropertyType
    {
        return $this->add($name, PropertyTypeFactory::getDate());
    }

    public function addTime(string $name): StringPropertyType
    {
        return $this->add($name, PropertyTypeFactory::getTime());
    }

    public function getType(): StructDefinitionType
    {
        return $this->type;
    }
}
