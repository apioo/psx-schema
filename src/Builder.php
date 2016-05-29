<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

/**
 * Builder
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Builder
{
    /**
     * @var \PSX\Schema\Property\ComplexType
     */
    protected $property;

    public function __construct($name)
    {
        $this->property = Property::getComplex();
        $this->property->setName($name);
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->property->setDescription($description);

        return $this;
    }

    /**
     * @param boolean $required
     * @return $this
     */
    public function setRequired($required)
    {
        $this->property->setRequired($required);

        return $this;
    }

    /**
     * @param string $pattern
     * @param \PSX\Schema\PropertyInterface $property
     * @return $this
     */
    public function addPatternProperty($pattern, PropertyInterface $property)
    {
        $this->property->addPatternProperty($pattern, $property);

        return $this;
    }

    /**
     * @param boolean|\PSX\Schema\PropertyInterface $value
     * @return $this
     */
    public function setAdditionalProperties($value)
    {
        $this->property->setAdditionalProperties($value);

        return $this;
    }

    /**
     * @param integer $minProperties
     * @return $this
     */
    public function setMinProperties($minProperties)
    {
        $this->property->setMinProperties($minProperties);

        return $this;
    }

    /**
     * @param integer $maxProperties
     * @return $this
     */
    public function setMaxProperties($maxProperties)
    {
        $this->property->setMaxProperties($maxProperties);

        return $this;
    }

    /**
     * @param string $reference
     * @return $this
     */
    public function setReference($reference)
    {
        $this->property->setReference($reference);

        return $this;
    }

    /**
     * @param \PSX\Schema\PropertyInterface $property
     * @return $this
     */
    public function add($name, PropertyInterface $property = null)
    {
        $this->property->add($name, $property);

        return $this;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\AnyType
     * @deprecated
     */
    public function anyType($name, Property\AnyType $type = null)
    {
        if ($type !== null) {
            $this->add($name, $property = clone $type);
        } else {
            $this->add($name, $property = Property::getAny());
        }

        return $property;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\ArrayType
     */
    public function arrayType($name, Property\ArrayType $type = null)
    {
        if ($type !== null) {
            $this->add($name, $property = clone $type);
        } else {
            $this->add($name, $property = Property::getArray());
        }

        return $property;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\BinaryType
     */
    public function binary($name)
    {
        $this->add($name, $property = Property::getBinary());

        return $property;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\BooleanType
     */
    public function boolean($name)
    {
        $this->add($name, $property = Property::getBoolean());

        return $property;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\ChoiceType
     */
    public function choiceType($name, Property\ChoiceType $type = null)
    {
        if ($type !== null) {
            $this->add($name, $property = clone $type);
        } else {
            $this->add($name, $property = Property::getChoice());
        }

        return $property;
    }

    /**
     * @param string $name
     * @param \PSX\Schema\Property\ComplexType $template
     * @return \PSX\Schema\Property\ComplexType
     */
    public function complexType($name, Property\ComplexType $type = null)
    {
        if ($type !== null) {
            $this->add($name, $property = clone $type);
        } else {
            $this->add($name, $property = Property::getComplex());
        }

        return $property;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\DateType
     */
    public function date($name)
    {
        $this->add($name, $property = Property::getDate());

        return $property;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\DateTimeType
     */
    public function dateTime($name)
    {
        $this->add($name, $property = Property::getDateTime());

        return $property;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\DurationType
     */
    public function duration($name)
    {
        $this->add($name, $property = Property::getDuration());

        return $property;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\FloatType
     */
    public function float($name)
    {
        $this->add($name, $property = Property::getFloat());

        return $property;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\IntegerType
     */
    public function integer($name)
    {
        $this->add($name, $property = Property::getInteger());

        return $property;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\StringType
     */
    public function string($name)
    {
        $this->add($name, $property = Property::getString());

        return $property;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\TimeType
     */
    public function time($name)
    {
        $this->add($name, $property = Property::getTime());

        return $property;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\Property\UriType
     */
    public function uri($name)
    {
        $this->add($name, $property = Property::getUri());

        return $property;
    }

    /**
     * @return \PSX\Schema\Property\ComplexType
     */
    public function getProperty()
    {
        return $this->property;
    }
}
