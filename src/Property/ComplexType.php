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

namespace PSX\Schema\Property;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use PSX\Schema\PropertyAbstract;
use PSX\Schema\PropertyInterface;

/**
 * ComplexType
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ComplexType extends PropertyAbstract implements IteratorAggregate, Countable
{
    /**
     * @var \PSX\Schema\PropertyInterface[]
     */
    protected $properties = array();

    /**
     * @var \PSX\Schema\PropertyInterface[]
     */
    protected $patternProperties = array();

    /**
     * @var boolean|\PSX\Schema\PropertyInterface
     */
    protected $additionalProperties = false;

    /**
     * @var integer
     */
    protected $minProperties;

    /**
     * @var integer
     */
    protected $maxProperties;

    /**
     * @param \PSX\Schema\PropertyInterface $property
     * @return $this
     */
    public function add($name, PropertyInterface $property = null)
    {
        // for BC reasons we allow also to pass a property as name. In this
        // case we use the name of the property as key
        if ($name instanceof PropertyInterface) {
            trigger_error('Using a property as first argument is deprecated. Use a string key instead and the property as second argument', E_USER_DEPRECATED);

            $property = $name;
            $name     = $property->getName();
        } elseif ($property === null) {
            throw new InvalidArgumentException('Property must be defined');
        }

        if (empty($name)) {
            throw new InvalidArgumentException('Empty names are not allowed');
        }

        $this->properties[$name] = $property;

        return $this;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function get($name)
    {
        return isset($this->properties[$name]) ? $this->properties[$name] : null;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function has($name)
    {
        return isset($this->properties[$name]);
    }

    public function remove($name)
    {
        if (isset($this->properties[$name])) {
            unset($this->properties[$name]);
        }
    }

    public function setProperties(array $properties)
    {
        $this->properties = $properties;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function addPatternProperty($pattern, PropertyInterface $prototype)
    {
        $this->patternProperties[$pattern] = $prototype;

        return $this;
    }

    public function setPatternProperties($patternProperties)
    {
        $this->patternProperties = $patternProperties;

        return $this;
    }

    public function getPatternProperties()
    {
        return $this->patternProperties;
    }

    public function setAdditionalProperties($value)
    {
        $this->additionalProperties = $value;

        return $this;
    }

    public function getAdditionalProperties()
    {
        return $this->additionalProperties;
    }

    /**
     * @return integer
     */
    public function getMinProperties()
    {
        return $this->minProperties;
    }

    /**
     * @param integer $minProperties
     */
    public function setMinProperties($minProperties)
    {
        $this->minProperties = $minProperties;
    }

    /**
     * @return integer
     */
    public function getMaxProperties()
    {
        return $this->maxProperties;
    }

    /**
     * @param integer $maxProperties
     */
    public function setMaxProperties($maxProperties)
    {
        $this->maxProperties = $maxProperties;
    }

    public function getId()
    {
        $result     = parent::getId();
        $properties = array_merge($this->properties, $this->patternProperties);

        ksort($properties);

        foreach ($properties as $name => $property) {
            $result.= $name . $property->getId();
        }

        if (is_bool($this->additionalProperties)) {
            $result.= $this->additionalProperties;
        } elseif ($this->additionalProperties instanceof PropertyInterface) {
            $result.= $this->additionalProperties->getId();
        }

        $result.= $this->minProperties;
        $result.= $this->maxProperties;

        return md5($result);
    }

    public function getIterator()
    {
        return new ArrayIterator($this->properties);
    }

    public function count()
    {
        return count($this->properties);
    }

    public function __clone()
    {
        $properties = $this->properties;
        $this->properties = [];

        foreach ($properties as $name => $property) {
            $this->properties[$name] = clone $properties[$name];
        }

        $patternProperties = $this->patternProperties;
        $this->patternProperties = [];

        foreach ($patternProperties as $pattern => $property) {
            $this->patternProperties[$pattern] = clone $patternProperties[$pattern];
        }

        $additionalProperties = $this->additionalProperties;
        if ($additionalProperties instanceof PropertyInterface) {
            $this->additionalProperties = clone $additionalProperties; 
        }
    }
}
