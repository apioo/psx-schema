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
 * @link    http://phpsx.org
 */
class Builder
{
    /**
     * @var StructType
     */
    protected $type;

    public function __construct()
    {
        $this->type = TypeFactory::getStruct();
    }

    /**
     * @param string $description
     * @return Builder
     */
    public function setDescription(string $description): Builder
    {
        $this->type->setDescription($description);

        return $this;
    }

    /**
     * @param array $required
     * @return Builder
     */
    public function setRequired(array $required): Builder
    {
        $this->type->setRequired($required);

        return $this;
    }

    /**
     * @param string $ref
     * @return Builder
     */
    public function setExtends(string $ref): Builder
    {
        $this->type->setExtends($ref);

        return $this;
    }

    /**
     * @param string $class
     * @return Builder
     */
    public function setClass(string $class): Builder
    {
        $this->type->setAttribute(TypeAbstract::ATTR_CLASS, $class);

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return Builder
     */
    public function setAttribute(string $key, $value): Builder
    {
        $this->type->setAttribute($key, $value);

        return $this;
    }

    /**
     * @param string $name
     * @param \PSX\Schema\TypeInterface $type
     * @return TypeInterface
     */
    public function add(string $name, TypeInterface $type): TypeInterface
    {
        $this->type->addProperty($name, $type);

        return $type;
    }

    /**
     * @param string $name
     * @param \PSX\Schema\TypeInterface $items
     * @return ArrayType
     */
    public function addArray(string $name, TypeInterface $items): ArrayType
    {
        return $this->add($name, TypeFactory::getArray($items));
    }

    /**
     * @param string $name
     * @return BooleanType
     */
    public function addBoolean(string $name): BooleanType
    {
        return $this->add($name, TypeFactory::getBoolean());
    }

    /**
     * @param string $name
     * @return IntegerType
     */
    public function addInteger(string $name): IntegerType
    {
        return $this->add($name, TypeFactory::getInteger());
    }

    /**
     * @param string $name
     * @param array $types
     * @return IntersectionType
     */
    public function addIntersection(string $name, array $types): IntersectionType
    {
        return $this->add($name, TypeFactory::getIntersection($types));
    }

    /**
     * @param string $name
     * @return NumberType
     */
    public function addNumber(string $name): NumberType
    {
        return $this->add($name, TypeFactory::getNumber());
    }

    /**
     * @param string $name
     * @param string $ref
     * @return ReferenceType
     */
    public function addReference(string $name, string $ref): ReferenceType
    {
        return $this->add($name, TypeFactory::getReference($ref));
    }

    /**
     * @param string $name
     * @return StringType
     */
    public function addString(string $name): StringType
    {
        return $this->add($name, TypeFactory::getString());
    }

    /**
     * @param string $name
     * @param array $types
     * @return UnionType
     */
    public function addUnion(string $name, array $types): UnionType
    {
        return $this->add($name, TypeFactory::getUnion($types));
    }

    /**
     * @param string $name
     * @return StringType
     */
    public function addBinary(string $name): StringType
    {
        return $this->add($name, TypeFactory::getBinary());
    }

    /**
     * @param string $name
     * @return StringType
     */
    public function addDateTime(string $name): StringType
    {
        return $this->add($name, TypeFactory::getDateTime());
    }

    /**
     * @param string $name
     * @return StringType
     */
    public function addDate(string $name): StringType
    {
        return $this->add($name, TypeFactory::getDate());
    }

    /**
     * @param string $name
     * @return StringType
     */
    public function addDuration(string $name): StringType
    {
        return $this->add($name, TypeFactory::getDuration());
    }

    /**
     * @param string $name
     * @return StringType
     */
    public function addTime(string $name): StringType
    {
        return $this->add($name, TypeFactory::getTime());
    }

    /**
     * @param string $name
     * @return StringType
     */
    public function addUri(string $name): StringType
    {
        return $this->add($name, TypeFactory::getUri());
    }

    /**
     * @return StructType
     */
    public function getType(): StructType
    {
        return $this->type;
    }
}
