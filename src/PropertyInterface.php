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
 * PropertyInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
interface PropertyInterface
{
    /**
     * @return string|array
     */
    public function getType();

    /**
     * @param string|array $type
     * @return \PSX\Schema\PropertyInterface
     */
    public function setType($type);

    /**
     * @return array
     */
    public function getProperties();

    /**
     * @param array $properties
     * @return \PSX\Schema\PropertyInterface
     */
    public function setProperties(array $properties);

    /**
     * @param string $name
     * @param \PSX\Schema\PropertyInterface $property
     * @return \PSX\Schema\PropertyInterface
     */
    public function addProperty($name, PropertyInterface $property);

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function getProperty($name);

    /**
     * @param string $name
     * @return boolean
     */
    public function hasProperty($name);

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function removeProperty($name);

    /**
     * @return array
     */
    public function getPatternProperties();

    /**
     * @param array $patternProperties
     * @return \PSX\Schema\PropertyInterface
     */
    public function setPatternProperties(array $patternProperties);

    /**
     * @param string $pattern
     * @param \PSX\Schema\PropertyInterface $property
     * @return \PSX\Schema\PropertyInterface
     */
    public function addPatternProperty($pattern, PropertyInterface $property);

    /**
     * @param string $pattern
     * @return \PSX\Schema\PropertyInterface
     */
    public function getPatternProperty($pattern);

    /**
     * @param string $pattern
     * @return \PSX\Schema\PropertyInterface
     */
    public function removePatternProperty($pattern);

    /**
     * @return bool|PropertyInterface
     */
    public function getAdditionalProperties();

    /**
     * @param bool|PropertyInterface $additionalProperties
     * @return \PSX\Schema\PropertyInterface
     */
    public function setAdditionalProperties($additionalProperties);

    /**
     * @return int
     */
    public function getMinProperties();

    /**
     * @param int $minProperties
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMinProperties($minProperties);

    /**
     * @return int
     */
    public function getMaxProperties();

    /**
     * @param int $maxProperties
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMaxProperties($maxProperties);

    /**
     * @return array|PropertyInterface
     */
    public function getItems();

    /**
     * @param array|PropertyInterface $items
     * @return \PSX\Schema\PropertyInterface
     */
    public function setItems($items);

    /**
     * @return bool|PropertyInterface
     */
    public function getAdditionalItems();

    /**
     * @param bool|PropertyInterface $additionalItems
     * @return \PSX\Schema\PropertyInterface
     */
    public function setAdditionalItems($additionalItems);

    /**
     * @return array
     */
    public function getRequired();

    /**
     * @param array $required
     * @return \PSX\Schema\PropertyInterface
     */
    public function setRequired(array $required);

    /**
     * @return array|string
     */
    public function getDependencies();

    /**
     * @param array $dependencies
     * @return \PSX\Schema\PropertyInterface
     */
    public function setDependencies(array $dependencies);

    /**
     * @param string $name
     * @param array|PropertyInterface $value
     * @return \PSX\Schema\PropertyInterface
     */
    public function addDependency($name, $value);

    /**
     * @return int|float
     */
    public function getMinimum();

    /**
     * @param int|float $minimum
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMinimum($minimum);

    /**
     * @return int|float
     */
    public function getMaximum();

    /**
     * @param int|float $maximum
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMaximum($maximum);

    /**
     * @return boolean
     */
    public function getExclusiveMinimum();

    /**
     * @param boolean $exclusiveMinimum
     * @return \PSX\Schema\PropertyInterface
     */
    public function setExclusiveMinimum($exclusiveMinimum);

    /**
     * @return boolean
     */
    public function getExclusiveMaximum();

    /**
     * @param boolean $exclusiveMaximum
     * @return \PSX\Schema\PropertyInterface
     */
    public function setExclusiveMaximum($exclusiveMaximum);

    /**
     * @return int
     */
    public function getMinItems();

    /**
     * @param int $minItems
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMinItems($minItems);

    /**
     * @return int
     */
    public function getMaxItems();

    /**
     * @param int $maxItems
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMaxItems($maxItems);

    /**
     * @return boolean
     */
    public function getUniqueItems();

    /**
     * @param boolean $uniqueItems
     * @return \PSX\Schema\PropertyInterface
     */
    public function setUniqueItems($uniqueItems);

    /**
     * @return string
     */
    public function getPattern();

    /**
     * @param string $pattern
     * @return \PSX\Schema\PropertyInterface
     */
    public function setPattern($pattern);

    /**
     * @return int
     */
    public function getMinLength();

    /**
     * @param int $minLength
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMinLength($minLength);

    /**
     * @return int
     */
    public function getMaxLength();

    /**
     * @param int $maxLength
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMaxLength($maxLength);

    /**
     * @return array
     */
    public function getEnum();

    /**
     * @param array $enum
     * @return \PSX\Schema\PropertyInterface
     */
    public function setEnum(array $enum);

    /**
     * @return mixed
     */
    public function getConst();

    /**
     * @param mixed $const
     * @return \PSX\Schema\PropertyInterface
     */
    public function setConst($const);

    /**
     * @return string
     */
    public function getDefault();

    /**
     * @param string $default
     * @return \PSX\Schema\PropertyInterface
     */
    public function setDefault($default);

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     * @return \PSX\Schema\PropertyInterface
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     * @return \PSX\Schema\PropertyInterface
     */
    public function setDescription($description);

    /**
     * @return string
     */
    public function getFormat();

    /**
     * @param string $format
     * @return \PSX\Schema\PropertyInterface
     */
    public function setFormat($format);

    /**
     * @return int|float
     */
    public function getMultipleOf();

    /**
     * @param int|float $multipleOf
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMultipleOf($multipleOf);

    /**
     * @return array
     */
    public function getAllOf();

    /**
     * @param array $allOf
     * @return \PSX\Schema\PropertyInterface
     */
    public function setAllOf(array $allOf);

    /**
     * @return array
     */
    public function getAnyOf();

    /**
     * @param array $anyOf
     * @return \PSX\Schema\PropertyInterface
     */
    public function setAnyOf(array $anyOf);

    /**
     * @return array
     */
    public function getOneOf();

    /**
     * @param array $oneOf
     * @return \PSX\Schema\PropertyInterface
     */
    public function setOneOf(array $oneOf);

    /**
     * @return array
     */
    public function getNot();

    /**
     * @param \PSX\Schema\PropertyInterface $not
     * @return \PSX\Schema\PropertyInterface
     */
    public function setNot(PropertyInterface $not);

    /**
     * @return string
     * @deprecated use getTitle instead
     */
    public function getName();

    /**
     * @return string
     */
    public function getRef();

    /**
     * @param string $ref
     * @return \PSX\Schema\PropertyInterface
     */
    public function setRef($ref);

    /**
     * @return string
     */
    public function getClass();

    /**
     * @param string $class
     * @return \PSX\Schema\PropertyInterface
     */
    public function setClass($class);

    /**
     * Returns whether a property has constraints. If no constraints are
     * available every data is allowed
     *
     * @return boolean
     */
    public function hasConstraints();

    /**
     * Returns a unique id which represents the available constraints.
     * Properties with the same constraints produce also the same id
     *
     * @return string
     */
    public function getConstraintId();

    /**
     * @return array
     */
    public function toArray();
}
