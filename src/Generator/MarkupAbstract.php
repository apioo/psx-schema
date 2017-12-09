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

namespace PSX\Schema\Generator;

use PSX\Schema\GeneratorInterface;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
use PSX\Schema\SchemaInterface;

/**
 * MarkupAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
abstract class MarkupAbstract implements GeneratorInterface
{
    use GeneratorTrait;

    /**
     * Contains all objects which are already rendered
     *
     * @var array
     */
    protected $types;

    /**
     * Contains properties which are referenced by an object and which we need
     * to render
     *
     * @var array
     */
    protected $references;

    /**
     * @var integer
     */
    protected $heading;

    /**
     * @param integer $heading
     */
    public function __construct($heading = 1)
    {
        $this->heading = $heading >= 1 && $heading <= 6 ? $heading : 1;
    }

    public function generate(SchemaInterface $schema)
    {
        $this->types = [];
        $this->references = [];

        return $this->generateType($schema->getDefinition());
    }

    protected function generateType(PropertyInterface $type)
    {
        $constraintId = $this->getIdentifierForProperty($type);

        if (isset($this->types[$constraintId])) {
            return '';
        }

        $this->types[$constraintId] = true;

        $response = $this->renderObject($type);
        
        return $response;
    }

    protected function renderObject(PropertyInterface $property)
    {
        $id          = $this->getIdForProperty($property);
        $title       = $property->getTitle() ?: 'Object';
        $description = $property->getDescription();

        $properties      = $property->getProperties();
        $patternProps    = $property->getPatternProperties();
        $additionalProps = $property->getAdditionalProperties();
        $required        = $property->getRequired() ?: [];

        if (empty($description) && empty($properties) && empty($patternProps) && empty($additionalProps)) {
            return '';
        }

        $result = [];
        if (!empty($properties) || !empty($patternProps) || !empty($additionalProps)) {
            if (!empty($properties)) {
                foreach ($properties as $name => $property) {
                    $result[$name] = $this->getRowFromProperty($property, in_array($name, $required));
                }
            }

            if (!empty($patternProps)) {
                foreach ($patternProps as $pattern => $property) {
                    $result[$pattern] = $this->getRowFromProperty($property, false);
                }
            }

            if ($additionalProps === true) {
                $result['*'] = new Text\Property(false, 'Mixed', $property->getDescription());
            } elseif ($additionalProps instanceof PropertyInterface) {
                $result['*'] = $this->getRowFromProperty($property, false);
            }
        }

        $response = '';
        if (!empty($result)) {
            $response.= $this->writeObject($id, $title, $description, $result);
        }

        foreach ($this->references as $prop) {
            $response.= $this->generateType($prop);
        }

        return $response;
    }

    protected function getRowFromProperty(PropertyInterface $property, $required)
    {
        return new Text\Property(
            $required,
            $this->getType($property),
            $property->getDescription(),
            $this->getConstraints($property)
        );
    }

    /**
     * @param \PSX\Schema\PropertyInterface $property
     * @return string
     */
    protected function getType(PropertyInterface $property)
    {
        $realType = $this->getRealType($property);

        if ($realType === PropertyType::TYPE_ARRAY) {
            $types = [];
            $items = $property->getItems();

            if ($items instanceof PropertyInterface) {
                $types[] = $this->getType($items);
            } elseif (is_array($items)) {
                foreach ($items as $item) {
                    $types[] = $this->getType($item);
                }
            }

            $type = 'Array (' . implode(', ', $types) . ')';
        } elseif ($realType === PropertyType::TYPE_OBJECT) {
            $constraintId = $property->getConstraintId();
            
            if (!isset($this->types[$constraintId])) {
                $this->references[] = $property;
            }

            $link = $this->writeLink($property->getTitle() ?: 'Object', '#' . $this->getIdForProperty($property));
            $type = 'Object (' . $link . ')';
        } else {
            $type = $this->getTypeName($property, $realType);
        }

        return $type;
    }

    /**
     * @param \PSX\Schema\PropertyInterface $property
     * @return array
     */
    protected function getConstraints(PropertyInterface $property)
    {
        $constraints = [];

        // array
        $minItems = $property->getMinItems();
        if ($minItems !== null) {
            $constraints['minItems'] = $minItems;
        }

        $maxItems = $property->getMaxItems();
        if ($maxItems !== null) {
            $constraints['maxItems'] = $maxItems;
        }

        // number
        $minimum = $property->getMinimum();
        if ($minimum !== null) {
            $constraints['minimum'] = $minimum;
        }

        $maximum = $property->getMaximum();
        if ($maximum !== null) {
            $constraints['maximum'] = $maximum;
        }

        $multipleOf = $property->getMultipleOf();
        if ($multipleOf !== null) {
            $constraints['multipleOf'] = $multipleOf;
        }

        // string
        $minLength = $property->getMinLength();
        if ($minLength !== null) {
            $constraints['minLength'] = $minLength;
        }

        $maxLength = $property->getMaxLength();
        if ($maxLength !== null) {
            $constraints['maxLength'] = $maxLength;
        }

        $pattern = $property->getPattern();
        if ($pattern !== null) {
            $constraints['pattern'] = $pattern;
        }

        $enum = $property->getEnum();
        if ($enum !== null) {
            $constraints['enum'] = $enum;
        }

        $const = $property->getConst();
        if ($const !== null) {
            $constraints['const'] = $const;
        }

        // combination
        $allOf = $property->getAllOf();
        $anyOf = $property->getAnyOf();
        $oneOf = $property->getOneOf();

        if (!empty($allOf)) {
            $constraints['allOf'] = $this->getCombination($allOf);
        } elseif (!empty($anyOf)) {
            $constraints['anyOf'] = $this->getCombination($anyOf);
        } elseif (!empty($oneOf)) {
            $constraints['oneOf'] = $this->getCombination($oneOf);
        }

        return $constraints;
    }

    protected function getCombination(array $props)
    {
        $combination = [];
        foreach ($props as $prop) {
            $combination[] = $this->getRowFromProperty($prop, false);
        }

        return $combination;
    }

    protected function getTypeName(PropertyInterface $property, $type)
    {
        if (empty($type)) {
            $typeName = 'Mixed';
        } elseif (is_array($type)) {
            $typeName = implode(' / ', array_map('ucfirst', $type));
        } elseif (is_string($type)) {
            $typeName = ucfirst($type);
        } else {
            $typeName = 'Mixed';
        }

        $format = $property->getFormat();
        if ($format === PropertyType::FORMAT_DATE) {
            $typeName = $this->writeLink('Date', 'http://tools.ietf.org/html/rfc3339#section-5.6');
        } elseif ($format === PropertyType::FORMAT_DATETIME) {
            $typeName = $this->writeLink('DateTime', 'http://tools.ietf.org/html/rfc3339#section-5.6');
        } elseif ($format === PropertyType::FORMAT_TIME) {
            $typeName = $this->writeLink('Time', 'http://tools.ietf.org/html/rfc3339#section-5.6');
        } elseif ($format === PropertyType::FORMAT_DURATION) {
            $typeName = $this->writeLink('Duration', 'https://en.wikipedia.org/wiki/ISO_8601#Durations');
        } elseif ($format === PropertyType::FORMAT_URI) {
            $typeName = $this->writeLink('URI', 'http://tools.ietf.org/html/rfc3986');
        } elseif ($format === PropertyType::FORMAT_BINARY) {
            $typeName = $this->writeLink('Base64', 'http://tools.ietf.org/html/rfc4648');
        }

        return $typeName;
    }

    protected function getIdForProperty(PropertyInterface $property)
    {
        return 'psx_model_' . $this->getIdentifierForProperty($property);
    }

    /**
     * @param string $id
     * @param string $title
     * @param string $description
     * @param \PSX\Schema\Generator\Text\Property[] $properties
     * @return string
     */
    abstract protected function writeObject($id, $title, $description, array $properties);

    /**
     * @param string $title
     * @param string $href
     * @return string
     */
    abstract protected function writeLink($title, $href);
}
