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

namespace PSX\Schema;

use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;

/**
 * Builder to create an object type with specific constraints
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Builder
{
    /**
     * @var \PSX\Schema\TypeInterface
     */
    protected $type;

    public function __construct($name)
    {
        $this->type = new StructType();
        $this->type->setTitle($name);
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->type->setDescription($description);

        return $this;
    }

    /**
     * @param array $required
     * @return $this
     */
    public function setRequired(array $required)
    {
        $this->type->setRequired($required);

        return $this;
    }

    /**
     * @param boolean|\PSX\Schema\TypeInterface $value
     * @return $this
     */
    public function setAdditionalProperties($value)
    {
        $this->type->setAdditionalProperties($value);

        return $this;
    }

    /**
     * @param integer $minProperties
     * @return $this
     */
    public function setMinProperties($minProperties)
    {
        $this->type->setMinProperties($minProperties);

        return $this;
    }

    /**
     * @param integer $maxProperties
     * @return $this
     */
    public function setMaxProperties($maxProperties)
    {
        $this->type->setMaxProperties($maxProperties);

        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        $this->type->setAttribute($key, $value);

        return $this;
    }

    /**
     * @param string $name
     * @param \PSX\Schema\TypeInterface $type
     * @return $this
     */
    public function add($name, TypeInterface $type)
    {
        $this->type->addProperty($name, $type);

        return $this;
    }

    /**
     * @param string $name
     * @param TypeInterface $type
     * @return \PSX\Schema\TypeInterface
     */
    public function property($name, TypeInterface $type): TypeInterface
    {
        $this->add($name, $type);

        return $type;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\TypeInterface
     */
    public function arrayType($name)
    {
        return $this->property($name, new ArrayType());
    }

    /**
     * @param string $name
     * @return \PSX\Schema\TypeInterface
     */
    public function binary($name)
    {
        return $this->property($name, new StringType())
            ->setFormat(PropertyType::FORMAT_BINARY);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\TypeInterface
     */
    public function boolean($name)
    {
        return $this->property($name, new BooleanType());
    }

    /**
     * @param string $name
     * @param \PSX\Schema\TypeInterface $template
     * @return \PSX\Schema\TypeInterface
     */
    public function structType($name, TypeInterface $template = null)
    {
        if ($template !== null) {
            return $this->property($name, clone $template);
        } else {
            return $this->property($name, new StructType());
        }
    }

    /**
     * @param string $name
     * @param \PSX\Schema\TypeInterface $template
     * @return \PSX\Schema\TypeInterface
     */
    public function mapType($name, TypeInterface $template = null)
    {
        if ($template !== null) {
            return $this->property($name, clone $template);
        } else {
            return $this->property($name, new MapType());
        }
    }

    /**
     * @param string $name
     * @return \PSX\Schema\TypeInterface
     */
    public function date($name)
    {
        return $this->property($name, new StringType())
            ->setFormat(PropertyType::FORMAT_DATE);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\TypeInterface
     */
    public function dateTime($name)
    {
        return $this->property($name, new StringType())
            ->setFormat(PropertyType::FORMAT_DATETIME);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\TypeInterface
     */
    public function duration($name)
    {
        return $this->property($name, new StringType())
            ->setFormat(PropertyType::FORMAT_DURATION);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\TypeInterface
     */
    public function number($name)
    {
        return $this->property($name, new NumberType());
    }

    /**
     * @param string $name
     * @return \PSX\Schema\TypeInterface
     */
    public function integer($name)
    {
        return $this->property($name, new IntegerType());
    }

    /**
     * @param string $name
     * @return \PSX\Schema\TypeInterface
     */
    public function string($name)
    {
        return $this->property($name, new StringType());
    }

    /**
     * @param string $name
     * @return \PSX\Schema\TypeInterface
     */
    public function time($name)
    {
        return $this->property($name, new StringType())
            ->setFormat(PropertyType::FORMAT_TIME);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\TypeInterface
     */
    public function uri($name)
    {
        return $this->property($name, new StringType())
            ->setFormat(PropertyType::FORMAT_URI);
    }

    /**
     * @return \PSX\Schema\TypeInterface
     */
    public function getType()
    {
        return $this->type;
    }
}
