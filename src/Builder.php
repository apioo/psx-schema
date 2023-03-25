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

namespace PSX\Schema;

use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\UnionType;

/**
 * Builder to create a struct type with specific properties
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Builder
{
    private StructType $type;

    public function __construct()
    {
        $this->type = TypeFactory::getStruct();
    }

    public function setDescription(string $description): Builder
    {
        $this->type->setDescription($description);

        return $this;
    }

    public function setRequired(array $required): Builder
    {
        $this->type->setRequired($required);

        return $this;
    }

    public function setExtends(string $ref): Builder
    {
        $this->type->setExtends($ref);

        return $this;
    }

    public function setClass(string $class): Builder
    {
        $this->type->setAttribute(TypeAbstract::ATTR_CLASS, $class);

        return $this;
    }

    public function setAttribute(string $key, mixed $value): Builder
    {
        $this->type->setAttribute($key, $value);

        return $this;
    }

    /**
     * @template T of TypeInterface
     * @param string $name
     * @param T $type
     * @return T
     * @throws Exception\InvalidSchemaException
     */
    public function add(string $name, TypeInterface $type): TypeInterface
    {
        $this->type->addProperty($name, $type);

        return $type;
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addArray(string $name, TypeInterface $items): ArrayType
    {
        return $this->add($name, TypeFactory::getArray($items));
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addBoolean(string $name): BooleanType
    {
        return $this->add($name, TypeFactory::getBoolean());
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addInteger(string $name): IntegerType
    {
        return $this->add($name, TypeFactory::getInteger());
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addIntersection(string $name, array $types): IntersectionType
    {
        return $this->add($name, TypeFactory::getIntersection($types));
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addNumber(string $name): NumberType
    {
        return $this->add($name, TypeFactory::getNumber());
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addReference(string $name, string $ref): ReferenceType
    {
        return $this->add($name, TypeFactory::getReference($ref));
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addString(string $name): StringType
    {
        return $this->add($name, TypeFactory::getString());
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addUnion(string $name, array $types): UnionType
    {
        return $this->add($name, TypeFactory::getUnion($types));
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addBinary(string $name): StringType
    {
        return $this->add($name, TypeFactory::getBinary());
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addDateTime(string $name): StringType
    {
        return $this->add($name, TypeFactory::getDateTime());
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addDate(string $name): StringType
    {
        return $this->add($name, TypeFactory::getDate());
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addPeriod(string $name): StringType
    {
        return $this->add($name, TypeFactory::getPeriod());
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addDuration(string $name): StringType
    {
        return $this->add($name, TypeFactory::getDuration());
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addTime(string $name): StringType
    {
        return $this->add($name, TypeFactory::getTime());
    }

    /**
     * @throws Exception\InvalidSchemaException
     */
    public function addUri(string $name): StringType
    {
        return $this->add($name, TypeFactory::getUri());
    }

    public function getType(): StructType
    {
        return $this->type;
    }
}
