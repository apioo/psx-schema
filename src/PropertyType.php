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

use InvalidArgumentException;

/**
 * PropertyType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class PropertyType implements PropertyInterface
{
    const TYPE_NULL = 'null';
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_OBJECT = 'object';
    const TYPE_ARRAY = 'array';
    const TYPE_NUMBER = 'number';
    const TYPE_INTEGER = 'integer';
    const TYPE_STRING = 'string';

    const FORMAT_INT32 = 'int32';
    const FORMAT_INT64 = 'int64';
    const FORMAT_BINARY = 'base64';
    const FORMAT_DATETIME = 'date-time';
    const FORMAT_DATE = 'date';
    const FORMAT_DURATION = 'duration';
    const FORMAT_TIME = 'time';
    const FORMAT_URI = 'uri';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $properties;

    /**
     * @var array
     */
    protected $patternProperties;

    /**
     * @var boolean|PropertyInterface
     */
    protected $additionalProperties;

    /**
     * @var integer
     */
    protected $minProperties;

    /**
     * @var integer
     */
    protected $maxProperties;

    /**
     * @var array
     */
    protected $required;

    /**
     * @var array
     */
    protected $dependencies;

    /**
     * @var array|PropertyInterface
     */
    protected $items;

    /**
     * @var boolean|PropertyInterface
     */
    protected $additionalItems;

    /**
     * @var boolean
     */
    protected $uniqueItems;

    /**
     * @var integer|float
     */
    protected $minimum;

    /**
     * @var integer|float
     */
    protected $maximum;

    /**
     * @var boolean
     */
    protected $exclusiveMinimum;

    /**
     * @var boolean
     */
    protected $exclusiveMaximum;

    /**
     * @var integer
     */
    protected $minItems;

    /**
     * @var integer
     */
    protected $maxItems;

    /**
     * @var string
     */
    protected $pattern;

    /**
     * @var integer
     */
    protected $minLength;

    /**
     * @var integer
     */
    protected $maxLength;

    /**
     * @var array
     */
    protected $enum;

    /**
     * @var mixed
     */
    protected $const;

    /**
     * @var string
     */
    protected $default;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var integer
     */
    protected $multipleOf;

    /**
     * @var array
     */
    protected $allOf;

    /**
     * @var array
     */
    protected $anyOf;

    /**
     * @var array
     */
    protected $oneOf;

    /**
     * @var PropertyInterface
     */
    protected $not;

    /**
     * @var string
     */
    protected $ref;

    /**
     * @var string
     */
    protected $class;

    /**
     * @return string|array
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string|array $type
     * @return \PSX\Schema\PropertyInterface
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param array $properties
     * @return \PSX\Schema\PropertyInterface
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;

        return $this;
    }

    /**
     * @param string $name
     * @param \PSX\Schema\PropertyInterface $property
     * @return \PSX\Schema\PropertyInterface
     */
    public function addProperty($name, PropertyInterface $property)
    {
        $this->properties[$name] = $property;

        return $this;
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     * @return \PSX\Schema\PropertyInterface
     */
    public function getProperty($name)
    {
        return isset($this->properties[$name]) ? $this->properties[$name] : null;
    }

    /**
     * @param string $name
     * @return boolean
     */
    public function hasProperty($name)
    {
        return isset($this->properties[$name]);
    }

    /**
     * @param string $name
     * @return \PSX\Schema\PropertyInterface
     */
    public function removeProperty($name)
    {
        if (isset($this->properties[$name])) {
            unset($this->properties[$name]);
        }
        
        return $this;
    }

    /**
     * @return array
     */
    public function getPatternProperties()
    {
        return $this->patternProperties;
    }

    /**
     * @param array $patternProperties
     * @return \PSX\Schema\PropertyInterface
     */
    public function setPatternProperties(array $patternProperties)
    {
        $this->patternProperties = $patternProperties;

        return $this;
    }

    /**
     * @param string $pattern
     * @param \PSX\Schema\PropertyInterface $property
     * @return \PSX\Schema\PropertyInterface
     */
    public function addPatternProperty($pattern, PropertyInterface $property)
    {
        $this->patternProperties[$pattern] = $property;

        return $this;
    }

    /**
     * @param string $pattern
     * @return \PSX\Schema\PropertyInterface
     */
    public function getPatternProperty($pattern)
    {
        return isset($this->patternProperties[$pattern]) ? $this->patternProperties[$pattern] : null;
    }

    /**
     * @param string $pattern
     * @return \PSX\Schema\PropertyInterface
     */
    public function removePatternProperty($pattern)
    {
        if (isset($this->patternProperties[$pattern])) {
            unset($this->patternProperties[$pattern]);
        }

        return $this;
    }

    /**
     * @return bool|PropertyInterface
     */
    public function getAdditionalProperties()
    {
        return $this->additionalProperties;
    }

    /**
     * @param bool|PropertyInterface $additionalProperties
     * @return \PSX\Schema\PropertyInterface
     */
    public function setAdditionalProperties($additionalProperties)
    {
        if (!is_bool($additionalProperties) && !$additionalProperties instanceof PropertyInterface) {
            throw new InvalidArgumentException('Additional properties must be either a boolean or PropertyInterface');
        }

        $this->additionalProperties = $additionalProperties;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinProperties()
    {
        return $this->minProperties;
    }

    /**
     * @param int $minProperties
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMinProperties($minProperties)
    {
        $this->minProperties = $minProperties;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxProperties()
    {
        return $this->maxProperties;
    }

    /**
     * @param int $maxProperties
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMaxProperties($maxProperties)
    {
        $this->maxProperties = $maxProperties;

        return $this;
    }

    /**
     * @return array
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param array $required
     * @return \PSX\Schema\PropertyInterface
     */
    public function setRequired(array $required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return array|string
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * @param array $dependencies
     * @return \PSX\Schema\PropertyInterface
     */
    public function setDependencies(array $dependencies)
    {
        $this->dependencies = $dependencies;

        return $this;
    }

    /**
     * @param string $name
     * @param array|PropertyInterface $value
     * @return \PSX\Schema\PropertyInterface
     */
    public function addDependency($name, $value)
    {
        $this->dependencies[$name] = $value;

        return $this;
    }

    /**
     * @return array|PropertyInterface
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param array|PropertyInterface $items
     * @return \PSX\Schema\PropertyInterface
     */
    public function setItems($items)
    {
        if ($items !== null && !is_array($items) && !$items instanceof PropertyInterface) {
            throw new InvalidArgumentException('Items must be either an array or PropertyInterface');
        }

        $this->items = $items;
        
        return $this;
    }

    /**
     * @return bool|PropertyInterface
     */
    public function getAdditionalItems()
    {
        return $this->additionalItems;
    }

    /**
     * @param bool|PropertyInterface $additionalItems
     * @return \PSX\Schema\PropertyInterface
     */
    public function setAdditionalItems($additionalItems)
    {
        if ($additionalItems !== null && !is_bool($additionalItems) && !$additionalItems instanceof PropertyInterface) {
            throw new InvalidArgumentException('Additional items must be either a boolean or PropertyInterface');
        }

        $this->additionalItems = $additionalItems;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getUniqueItems()
    {
        return $this->uniqueItems;
    }

    /**
     * @param boolean $uniqueItems
     * @return \PSX\Schema\PropertyInterface
     */
    public function setUniqueItems($uniqueItems)
    {
        $this->uniqueItems = $uniqueItems;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinimum()
    {
        return $this->minimum;
    }

    /**
     * @param int|float $minimum
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMinimum($minimum)
    {
        if ($minimum !== null && !is_int($minimum) && !is_float($minimum)) {
            throw new InvalidArgumentException('Minimum must be either an integer or float');
        }

        $this->minimum = $minimum;

        return $this;
    }

    /**
     * @return int|float
     */
    public function getMaximum()
    {
        return $this->maximum;
    }

    /**
     * @param int|float $maximum
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMaximum($maximum)
    {
        if ($maximum !== null && !is_int($maximum) && !is_float($maximum)) {
            throw new InvalidArgumentException('Maximum must be either an integer or float');
        }

        $this->maximum = $maximum;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getExclusiveMinimum()
    {
        return $this->exclusiveMinimum;
    }

    /**
     * @param boolean $exclusiveMinimum
     * @return \PSX\Schema\PropertyInterface
     */
    public function setExclusiveMinimum($exclusiveMinimum)
    {
        $this->exclusiveMinimum = $exclusiveMinimum;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getExclusiveMaximum()
    {
        return $this->exclusiveMaximum;
    }

    /**
     * @param boolean $exclusiveMaximum
     * @return \PSX\Schema\PropertyInterface
     */
    public function setExclusiveMaximum($exclusiveMaximum)
    {
        $this->exclusiveMaximum = $exclusiveMaximum;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinItems()
    {
        return $this->minItems;
    }

    /**
     * @param int $minItems
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMinItems($minItems)
    {
        $this->minItems = $minItems;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxItems()
    {
        return $this->maxItems;
    }

    /**
     * @param int $maxItems
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMaxItems($maxItems)
    {
        $this->maxItems = $maxItems;

        return $this;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     * @return \PSX\Schema\PropertyInterface
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinLength()
    {
        return $this->minLength;
    }

    /**
     * @param int $minLength
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMinLength($minLength)
    {
        $this->minLength = $minLength;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * @param int $maxLength
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMaxLength($maxLength)
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * @return array
     */
    public function getEnum()
    {
        return $this->enum;
    }

    /**
     * @param array $enum
     * @return \PSX\Schema\PropertyInterface
     */
    public function setEnum(array $enum)
    {
        $this->enum = $enum;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getConst()
    {
        return $this->const;
    }

    /**
     * @param mixed $const
     * @return \PSX\Schema\PropertyInterface
     */
    public function setConst($const)
    {
        $this->const = $const;

        return $this;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param string $default
     * @return \PSX\Schema\PropertyInterface
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return \PSX\Schema\PropertyInterface
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return \PSX\Schema\PropertyInterface
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return \PSX\Schema\PropertyInterface
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @return int|float
     */
    public function getMultipleOf()
    {
        return $this->multipleOf;
    }

    /**
     * @param int|float $multipleOf
     * @return \PSX\Schema\PropertyInterface
     */
    public function setMultipleOf($multipleOf)
    {
        $this->multipleOf = $multipleOf;

        return $this;
    }

    /**
     * @return array
     */
    public function getAllOf()
    {
        return $this->allOf;
    }

    /**
     * @param array $allOf
     * @return \PSX\Schema\PropertyInterface
     */
    public function setAllOf(array $allOf)
    {
        $this->allOf = $allOf;

        return $this;
    }

    /**
     * @return array
     */
    public function getAnyOf()
    {
        return $this->anyOf;
    }

    /**
     * @param array $anyOf
     * @return \PSX\Schema\PropertyInterface
     */
    public function setAnyOf(array $anyOf)
    {
        $this->anyOf = $anyOf;

        return $this;
    }

    /**
     * @return array
     */
    public function getOneOf()
    {
        return $this->oneOf;
    }

    /**
     * @param array $oneOf
     * @return \PSX\Schema\PropertyInterface
     */
    public function setOneOf(array $oneOf)
    {
        $this->oneOf = $oneOf;

        return $this;
    }

    /**
     * @return \PSX\Schema\PropertyInterface
     */
    public function getNot()
    {
        return $this->not;
    }

    /**
     * @param \PSX\Schema\PropertyInterface $not
     * @return \PSX\Schema\PropertyInterface
     */
    public function setNot(PropertyInterface $not)
    {
        $this->not = $not;

        return $this;
    }

    /**
     * @return string
     * @deprecated
     */
    public function getName()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     * @return string
     */
    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param string $class
     * @return string
     */
    public function setClass($class)
    {
        $this->class = $class;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasConstraints()
    {
        if ($this->type !== null || $this->enum !== null || $this->allOf !== null || $this->anyOf !== null || $this->oneOf !== null || $this->not !== null) {
            return true;
        } elseif ($this->properties !== null || $this->patternProperties !== null || $this->additionalProperties !== null || $this->maxProperties !== null || $this->minProperties !== null || $this->dependencies !== null) {
            // object constraints
            return true;
        } elseif ($this->items !== null || $this->additionalItems !== null || $this->maxItems !== null || $this->minItems !== null || $this->uniqueItems !== null) {
            // array constraints
            return true;
        } elseif ($this->maximum !== null || $this->minimum !== null || $this->multipleOf !== null) {
            // number constraints
            return true;
        } elseif ($this->maxLength !== null || $this->minLength !== null || $this->format !== null || $this->pattern !== null) {
            // string constraints
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getConstraintId()
    {
        $hash = '';
        $hash.= (is_array($this->type) ? json_encode($this->type) : $this->type) . json_encode($this->enum) . "\n";
        $hash.= $this->minProperties . $this->maxProperties . json_encode($this->required) . "\n";
        $hash.= $this->minItems . $this->maxItems . $this->uniqueItems . "\n";
        $hash.= $this->minimum . $this->maximum . $this->exclusiveMinimum . $this->exclusiveMaximum . $this->multipleOf . "\n";
        $hash.= $this->pattern . $this->minLength . $this->maxLength . $this->format . "\n";

        if ($this->allOf !== null) {
            foreach ($this->allOf as $property) {
                $hash.= spl_object_hash($property) . "\n";
            }
        }

        if ($this->anyOf !== null) {
            foreach ($this->anyOf as $property) {
                $hash.= spl_object_hash($property) . "\n";
            }
        }

        if ($this->oneOf !== null) {
            foreach ($this->oneOf as $property) {
                $hash.= spl_object_hash($property) . "\n";
            }
        }

        if ($this->not !== null) {
            $hash.= spl_object_hash($this->not) . "\n";
        }

        if ($this->properties !== null) {
            foreach ($this->properties as $name => $property) {
                $hash.= $name . "\n";
                $hash.= spl_object_hash($property) . "\n";
            }
        }

        if ($this->patternProperties !== null) {
            foreach ($this->patternProperties as $pattern => $property) {
                $hash.= $pattern . "\n";
                $hash.= spl_object_hash($property) . "\n";
            }
        }

        if (is_bool($this->additionalProperties)) {
            $hash.= $this->additionalProperties . "\n";
        } elseif ($this->additionalProperties instanceof PropertyInterface) {
            $hash.= spl_object_hash($this->additionalProperties) . "\n";
        }

        if ($this->items instanceof PropertyInterface) {
            $hash.= spl_object_hash($this->items) . "\n";
        } elseif (is_array($this->items)) {
            foreach ($this->items as $index => $property) {
                $hash.= $index . "\n";
                $hash.= spl_object_hash($property) . "\n";
            }
        }

        if (is_bool($this->additionalItems)) {
            $hash.= $this->additionalItems . "\n";
        } elseif ($this->additionalItems instanceof PropertyInterface) {
            $hash.= spl_object_hash($this->additionalItems) . "\n";
        }

        return md5($hash);
    }

    public function toArray()
    {
        $map = [
            'type' => $this->type,
            'enum' => $this->enum,
            'const' => $this->const,
            'title' => $this->title,
            'description' => $this->description,
            'default' => $this->default,
            'allOf' => $this->allOf,
            'anyOf' => $this->anyOf,
            'oneOf' => $this->oneOf,
            'not' => $this->not,

            // object
            'properties' => $this->properties,
            'patternProperties' => $this->patternProperties,
            'additionalProperties' => $this->additionalProperties,
            'minProperties' => $this->minProperties,
            'maxProperties' => $this->maxProperties,
            'required' => $this->required,
            'dependencies' => $this->dependencies,

            // array
            'items' => $this->items,
            'additionalItems' => $this->additionalItems,
            'minItems' => $this->minItems,
            'maxItems' => $this->maxItems,
            'uniqueItems' => $this->uniqueItems,

            // number
            'minimum' => $this->minimum,
            'maximum' => $this->maximum,
            'exclusiveMinimum' => $this->exclusiveMinimum,
            'exclusiveMaximum' => $this->exclusiveMaximum,
            'multipleOf' => $this->multipleOf,

            // string
            'pattern' => $this->pattern,
            'minLength' => $this->minLength,
            'maxLength' => $this->maxLength,
            'format' => $this->format,
        ];

        $map = array_filter($map, function ($value) {
            return $value !== null;
        });

        return $map;
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

        if ($this->patternProperties !== null) {
            $patternProperties = $this->patternProperties;
            $this->patternProperties = [];

            foreach ($patternProperties as $pattern => $property) {
                $this->patternProperties[$pattern] = clone $patternProperties[$pattern];
            }
        }

        if ($this->additionalProperties !== null) {
            $additionalProperties = $this->additionalProperties;
            if ($additionalProperties instanceof PropertyInterface) {
                $this->additionalProperties = clone $additionalProperties;
            }
        }

        if ($this->items !== null) {
            $items = $this->items;
            
            if ($items instanceof PropertyInterface) {
                $this->items = clone $items;
            } elseif (is_array($items)) {
                $this->items = [];
                foreach ($items as $property) {
                    $this->items[] = clone $property;
                }
            }
        }

        if ($this->additionalItems !== null) {
            $additionalItems = $this->additionalItems;
            if ($additionalItems instanceof PropertyInterface) {
                $this->additionalItems = clone $additionalItems;
            }
        }

        if ($this->allOf !== null) {
            $allOf = $this->allOf;
            $this->allOf = [];

            foreach ($allOf as $property) {
                $this->allOf[] = clone $property;
            }
        }

        if ($this->anyOf !== null) {
            $anyOf = $this->anyOf;
            $this->anyOf = [];

            foreach ($anyOf as $property) {
                $this->anyOf[] = clone $property;
            }
        }

        if ($this->oneOf !== null) {
            $oneOf = $this->oneOf;
            $this->oneOf = [];

            foreach ($oneOf as $property) {
                $this->oneOf[] = clone $property;
            }
        }
    }
}
