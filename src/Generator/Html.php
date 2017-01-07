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

namespace PSX\Schema\Generator;

use PSX\Schema\GeneratorInterface;
use PSX\Schema\Property;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
use PSX\Schema\SchemaInterface;

/**
 * Generates html tables containing all informations from the provided schema
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Html implements GeneratorInterface
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
        $description     = $property->getDescription();
        $properties      = $property->getProperties();
        $patternProps    = $property->getPatternProperties();
        $additionalProps = $property->getAdditionalProperties();
        $required        = $property->getRequired() ?: [];

        if (empty($description) && empty($properties) && empty($patternProps) && empty($additionalProps)) {
            return '';
        }

        $response = '<div id="' . $this->getIdForProperty($property) . '" class="psx-object">';
        $response.= '<h1>' . (htmlspecialchars($property->getTitle()) ?: 'Object') . '</h1>';

        if (!empty($description)) {
            $response.= '<div class="psx-object-description">' . htmlspecialchars($description) . '</div>';
        }

        $json = null;
        $prop = null;

        if (!empty($properties) || !empty($patternProps) || !empty($additionalProps)) {
            $prop = '<table class="table psx-object-properties">';
            $prop.= '<colgroup>';
            $prop.= '<col width="30%" />';
            $prop.= '<col width="70%" />';
            $prop.= '</colgroup>';
            $prop.= '<thead>';
            $prop.= '<tr>';
            $prop.= '<th>Field</th>';
            $prop.= '<th>Description</th>';
            $prop.= '</tr>';
            $prop.= '</thead>';
            $prop.= '<tbody>';

            $json = '<span class="psx-object-json-pun">{</span>' . "\n";

            if (!empty($properties)) {
                foreach ($properties as $name => $property) {
                    list($type, $constraints) = $this->getValueDescription($property);

                    $prop.= '<tr>';
                    $prop.= '<td><span class="psx-property-name ' . (in_array($name, $required) ? 'psx-property-required' : 'psx-property-optional') . '">' . $name . '</span></td>';
                    $prop.= '<td>';
                    $prop.= '<span class="psx-property-type">' . $type . '</span><br />';
                    $prop.= '<div class="psx-property-description">' . htmlspecialchars($property->getDescription()) . '</div>';
                    $prop.= $constraints;
                    $prop.= '</td>';
                    $prop.= '</tr>';

                    $json.= '  ';
                    $json.= '<span class="psx-object-json-key">"' . $name . '"</span>';
                    $json.= '<span class="psx-object-json-pun">: </span>';
                    $json.= $type;
                    $json.= '<span class="psx-object-json-pun">,</span>';
                    $json.= "\n";
                }
            }

            if (!empty($patternProps)) {
                foreach ($patternProps as $pattern => $property) {
                    list($type, $constraints) = $this->getValueDescription($property);

                    $prop.= '<tr>';
                    $prop.= '<td><span class="psx-property-name psx-property-optional">' . $pattern . '</span></td>';
                    $prop.= '<td>';
                    $prop.= '<span class="psx-property-type">' . $type . '</span><br />';
                    $prop.= '<div class="psx-property-description">' . htmlspecialchars($property->getDescription()) . '</div>';
                    $prop.= $constraints;
                    $prop.= '</td>';
                    $prop.= '</tr>';

                    $json.= '  ';
                    $json.= '<span class="psx-object-json-key">"' . $pattern . '"</span>';
                    $json.= '<span class="psx-object-json-pun">: </span>';
                    $json.= $type;
                    $json.= '<span class="psx-object-json-pun">,</span>';
                    $json.= "\n";
                }
            }

            if ($additionalProps === true) {
                $prop.= '<tr>';
                $prop.= '<td><span class="psx-property-name psx-property-optional">*</span></td>';
                $prop.= '<td><span class="psx-property-description">Additional properties are allowed</span></td>';
                $prop.= '</tr>';

                $json.= '  ';
                $json.= '<span class="psx-object-json-key">"*"</span>';
                $json.= '<span class="psx-object-json-pun">: </span>';
                $json.= '<span class="psx-property-type">Mixed</span>';
                $json.= '<span class="psx-object-json-pun">,</span>';
                $json.= "\n";
                
            } elseif ($additionalProps instanceof PropertyInterface) {
                list($type, $constraints) = $this->getValueDescription($additionalProps);

                $prop.= '<tr>';
                $prop.= '<td><span class="psx-property-name psx-property-optional">*</span></td>';
                $prop.= '<td>';
                $prop.= '<span class="psx-property-type">' . $type . '</span><br />';
                $prop.= '<div class="psx-property-description">' . htmlspecialchars($additionalProps->getDescription()) . '</div>';
                $prop.= $constraints;
                $prop.= '</td>';
                $prop.= '</tr>';

                $json.= '  ';
                $json.= '<span class="psx-object-json-key">"*"</span>';
                $json.= '<span class="psx-object-json-pun">: </span>';
                $json.= $type;
                $json.= '<span class="psx-object-json-pun">,</span>';
                $json.= "\n";
            }

            $json.= '<span class="psx-object-json-pun">}</span>';

            $prop.= '</tbody>';
            $prop.= '</table>';
        }

        $response.= '<pre class="psx-object-json">' . $json . '</pre>';
        $response.= $prop;
        $response.= '</div>';

        foreach ($this->references as $prop) {
            $response.= $this->generateType($prop);
        }

        return $response;
    }

    /**
     * Returns teh type and description column for a property
     *
     * @param PropertyInterface $property
     * @return array
     */
    protected function getValueDescription(PropertyInterface $property)
    {
        $type = $this->getRealType($property);

        if ($type === PropertyType::TYPE_ARRAY) {
            $constraints = array();

            $minItems = $property->getMinItems();
            if ($minItems !== null) {
                $constraints['minimum'] = '<span class="psx-constraint-minimum">' . $minItems . '</span>';
            }

            $maxItems = $property->getMaxItems();
            if ($maxItems !== null) {
                $constraints['maximum'] = '<span class="psx-constraint-maximum">' . $maxItems . '</span>';
            }

            $types      = [];
            $constraint = $this->constraintToString($constraints);
            $items      = $property->getItems();

            if ($items instanceof PropertyInterface) {
                $property = $this->getValueDescription($items);
                $types[] = $property[0];
            } elseif (is_array($items)) {
                foreach ($items as $item) {
                    $property = $this->getValueDescription($item);
                    $types[] = $property[0];
                }
            }

            $span = '<span class="psx-property-type psx-property-type-array">Array (' . implode(', ', $types) . ')</span>';

            return [$span, $constraint];
        } elseif ($type === PropertyType::TYPE_OBJECT) {
            $constraintId = $property->getConstraintId();
            
            if (!isset($this->types[$constraintId])) {
                $this->references[] = $property;
            }

            $span = '<span class="psx-property-type psx-property-type-object">Object (<a href="#' . $this->getIdForProperty($property) . '">' . ($property->getTitle() ?: 'Object') . '</a>)</span>';

            return [$span, null];
        } elseif (!empty($type)) {
            $typeName    = $this->getTypeName($property, $type);
            $constraints = array();

            $pattern = $property->getPattern();
            if ($pattern !== null) {
                $constraints['pattern'] = '<span class="psx-constraint-pattern">' . $pattern .'</span>';
            }

            $enum = $property->getEnum();
            if ($enum !== null) {
                $enumeration = '<ul class="psx-property-enumeration">';
                foreach ($enum as $enu) {
                    $enumeration.= '<li><span class="psx-constraint-enumeration-value">' . $enu . '</span></li>';
                }
                $enumeration.= '</ul>';

                $constraints['enumeration'] = '<span class="psx-constraint-enumeration">' . $enumeration .'</span>';
            }

            $minimum = $property->getMinimum();
            if ($minimum !== null) {
                $constraints['minimum'] = '<span class="psx-constraint-minimum">' . $minimum . '</span>';
            }

            $maximum = $property->getMaximum();
            if ($maximum !== null) {
                $constraints['maximum'] = '<span class="psx-constraint-maximum">' . $maximum . '</span>';
            }

            $multipleOf = $property->getMultipleOf();
            if ($multipleOf !== null) {
                $constraints['multipleOf'] = '<span class="psx-constraint-multipleof">' . $multipleOf . '</span>';
            }

            $minLength = $property->getMinLength();
            if ($minLength !== null) {
                $constraints['minimum'] = '<span class="psx-constraint-minimum">' . $minLength . '</span>';
            }

            $maxLength = $property->getMaxLength();
            if ($maxLength !== null) {
                $constraints['maximum'] = '<span class="psx-constraint-maximum">' . $maxLength . '</span>';
            }
            
            $constraint = $this->constraintToString($constraints);

            $span = '<span class="psx-property-type">' . $typeName . '</span>';

            return [$span, $constraint];
        } else {
            $allOf = $property->getAllOf();
            $anyOf = $property->getAnyOf();
            $oneOf = $property->getOneOf();

            if (!empty($allOf)) {
                return $this->combinationToString($allOf, 'AllOf');
            } elseif (!empty($anyOf)) {
                return $this->combinationToString($anyOf, 'AnyOf');
            } elseif (!empty($oneOf)) {
                return $this->combinationToString($oneOf, 'OneOf');
            }
        }

        return ['', ''];
    }

    protected function combinationToString(array $props, $title)
    {
        $data = [];
        foreach ($props as $prop) {
            $value = $this->getValueDescription($prop);
            $data[] = $value[0];
        }

        $span = '<span class="psx-property-type">' . $title . ' (' . implode(' | ', $data) . ')</span>';

        return [$span, ''];
    }
    
    protected function constraintToString(array $constraints)
    {
        $constraint = '';
        if (!empty($constraints)) {
            $constraint.= '<dl class="psx-property-constraint">';
            foreach ($constraints as $name => $con) {
                $constraint.= '<dt>' . ucfirst($name) . '</dt>';
                $constraint.= '<dd>' . $con . '</dd>';
            }
            $constraint.= '</dl>';
        }

        return $constraint;
    }

    protected function getTypeName(PropertyInterface $property, $type)
    {
        $typeName = !empty($type) ? ucfirst($type) : 'Unknown';
        $format   = $property->getFormat();

        if ($format === PropertyType::FORMAT_DATE) {
            $typeName = '<a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">Date</a>';
        } elseif ($format === PropertyType::FORMAT_DATETIME) {
            $typeName = '<a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">DateTime</a>';
        } elseif ($format === PropertyType::FORMAT_TIME) {
            $typeName = '<a href="http://tools.ietf.org/html/rfc3339#section-5.6" title="RFC3339">Time</a>';
        } elseif ($format === PropertyType::FORMAT_DURATION) {
            $typeName = '<a href="https://en.wikipedia.org/wiki/ISO_8601#Durations" title="ISO8601">Duration</a>';
        } elseif ($format === PropertyType::FORMAT_URI) {
            $typeName = '<a href="http://tools.ietf.org/html/rfc3986" title="RFC3339">URI</a>';
        } elseif ($format === PropertyType::FORMAT_BINARY) {
            $typeName = '<a href="http://tools.ietf.org/html/rfc4648" title="RFC4648">Base64</a>';
        }

        return $typeName;
    }

    protected function getIdForProperty(PropertyInterface $property)
    {
        return 'psx_model_' . $this->getIdentifierForProperty($property);
    }
}
