<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * Builder to create an object type with specific constraints
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Builder
{
    /**
     * @var \PSX\Schema\PropertyInterface
     */
    protected $property;

    public function __construct($name)
    {
        $this->property = new PropertyType();
        $this->property->setType(PropertyType::TYPE_OBJECT);
        $this->property->setTitle($name);
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
     * @param array $required
     * @return $this
     */
    public function setRequired(array $required)
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
     * @param string $class
     * @return $this
     */
    public function setClass($class)
    {
        $this->property->setClass($class);

        return $this;
    }

    /**
     * @param string $name
     * @param \PSX\Schema\PropertyInterface $property
     * @return $this
     */
    public function add($name, PropertyInterface $property = null)
    {
        $this->property->addProperty($name, $property);

        return $this;
    }

    /**
     * @param string $name
     * @param PropertyInterface $template
     * @return \PSX\Schema\PropertyInterface
     */
    public function property($name, PropertyInterface $template = null)
    {
        if ($template !== null) {
            $this->add($name, $property = clone $template);
        } else {
            $this->add($name, $property = new PropertyType());
        }

        return $property;
    }

    /**
     * @param string $name
     * @param PropertyInterface $template
     * @return \PSX\Schema\PropertyInterface
     */
    public function arrayType($name, PropertyInterface $template = null)
    {
        return $this->property($name, $template)
            ->setType(PropertyType::TYPE_ARRAY);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function binary($name)
    {
        return $this->property($name)
            ->setType(PropertyType::TYPE_STRING)
            ->setFormat(PropertyType::FORMAT_BINARY);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function boolean($name)
    {
        return $this->property($name)
            ->setType(PropertyType::TYPE_BOOLEAN);
    }

    /**
     * @param string $name
     * @param \PSX\Schema\PropertyInterface $template
     * @return \PSX\Schema\PropertyInterface
     */
    public function objectType($name, PropertyInterface $template = null)
    {
        return $this->property($name, $template)
            ->setType(PropertyType::TYPE_OBJECT);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function date($name)
    {
        return $this->property($name)
            ->setType(PropertyType::TYPE_STRING)
            ->setFormat(PropertyType::FORMAT_DATE);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function dateTime($name)
    {
        return $this->property($name)
            ->setType(PropertyType::TYPE_STRING)
            ->setFormat(PropertyType::FORMAT_DATETIME);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function duration($name)
    {
        return $this->property($name)
            ->setType(PropertyType::TYPE_STRING)
            ->setFormat(PropertyType::FORMAT_DURATION);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function number($name)
    {
        return $this->property($name)
            ->setType(PropertyType::TYPE_NUMBER);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function integer($name)
    {
        return $this->property($name)
            ->setType(PropertyType::TYPE_INTEGER);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function string($name)
    {
        return $this->property($name)
            ->setType(PropertyType::TYPE_STRING);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function time($name)
    {
        return $this->property($name)
            ->setType(PropertyType::TYPE_STRING)
            ->setFormat(PropertyType::FORMAT_TIME);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function uri($name)
    {
        return $this->property($name)
            ->setType(PropertyType::TYPE_STRING)
            ->setFormat(PropertyType::FORMAT_URI);
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public function getProperty()
    {
        return $this->property;
    }
}
