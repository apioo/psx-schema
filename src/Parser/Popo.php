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

namespace PSX\Schema\Parser;

use Doctrine\Common\Annotations\Reader;
use InvalidArgumentException;
use PSX\Schema\Parser\Popo\ObjectReader;
use PSX\Schema\Parser\Popo\TypeParser;
use PSX\Schema\Parser\Popo\Annotation;
use PSX\Schema\ParserInterface;
use PSX\Schema\Property;
use PSX\Schema\PropertyAbstract;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertySimpleAbstract;
use PSX\Schema\PropertyType;
use PSX\Schema\Schema;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;

/**
 * Tries to import the data into a plain old php object
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Popo implements ParserInterface
{
    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    protected $reader;

    /**
     * Holds all parsed objects to reuse
     *
     * @var array
     */
    protected $objects;

    /**
     * Contains the current path to detect recursions
     *
     * @var array
     */
    protected $stack;

    /**
     * @param \Doctrine\Common\Annotations\Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    public function parse($className)
    {
        if (!is_string($className)) {
            throw new InvalidArgumentException('Class name must be a string');
        }

        $this->objects = [];

        $property = $this->parseClass($className);

        return new Schema($property);
    }

    protected function parseClass($className)
    {
        if (isset($this->objects[$className])) {
            return new Property\RecursionType($this->objects[$className]);
        }

        $class       = new ReflectionClass($className);
        $annotations = $this->reader->getClassAnnotations($class);
        $property    = new PropertyType();
        $property->setType('object');
        $property->setClass($class->getName());

        $this->objects[$className] = $property;

        $this->parseClassAnnotations($property, $annotations);

        $properties = ObjectReader::getProperties($this->reader, $class);
        foreach ($properties as $key => $reflection) {
            $annotations = $this->reader->getPropertyAnnotations($reflection);

            // check whether we have a ref annotation
            $ref = null;
            foreach ($annotations as $annotation) {
                if ($annotation instanceof Annotation\Ref) {
                    $ref = $annotation->getRef();
                }
            }

            if (!empty($ref)) {
                $prop = $this->parseClass($ref);
            } else {
                $prop = new PropertyType();
            }

            $this->parsePropertyAnnotations($prop, $annotations);

            $property->addProperty($key, $prop);
        }

        array_pop($this->objects);

        return $property;
    }

    protected function parseArray(array $data)
    {
        $property = new PropertyType();

        foreach ($data as $key => $value) {
            switch ($key) {
                case 'title': $property->setTitle($value); break;
                case 'description': $property->setDescription($value); break;
                case 'enum': $property->setEnum($value); break;
                case 'type': $property->setType($value); break;
                case 'allOf': $property->setAllOf($value); break;
                case 'anyOf': $property->setAnyOf($value); break;
                case 'oneOf': $property->setOneOf($value); break;
                case 'not': $property->setNot($value); break;

                // number
                case 'maximum': $property->setMaximum($value); break;
                case 'minimum': $property->setMinimum($value); break;
                case 'exclusiveMaximum': $property->setExclusiveMaximum($value); break;
                case 'exclusiveMinimum': $property->setExclusiveMinimum($value); break;
                case 'multipleOf': $property->setMultipleOf($value); break;

                // string
                case 'maxLength': $property->setMaxLength($value); break;
                case 'minLength': $property->setMinLength($value); break;
                case 'pattern': $property->setPattern($value); break;
                case 'format': $property->setFormat($value); break;

                // array
                case 'items': $property->setItems($value); break;
                case 'additionalItems': $property->setAdditionalItems($value); break;
                case 'uniqueItems': $property->setUniqueItems($value); break;
                case 'maxItems': $property->setMaxItems($value); break;
                case 'minItems': $property->setMinItems($value); break;
            }
        }

        return $property;
    }

    protected function parseClassAnnotations(PropertyType $property, array $annotations)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Title) {
                $property->setTitle($annotation->getTitle());
            } elseif ($annotation instanceof Annotation\Description) {
                $property->setDescription($annotation->getDescription());
            } elseif ($annotation instanceof Annotation\AdditionalProperties) {
                $property->setAdditionalProperties($this->parseRef($annotation->getAdditionalProperties(), true));
            } elseif ($annotation instanceof Annotation\PatternProperties) {
                $prop = $this->parseRef($annotation->getProperty());
                if ($prop !== null) {
                    $property->addPatternProperty($annotation->getPattern(), $prop);
                }
            } elseif ($annotation instanceof Annotation\MinProperties) {
                $property->setMinProperties($annotation->getMinProperties());
            } elseif ($annotation instanceof Annotation\MaxProperties) {
                $property->setMaxProperties($annotation->getMaxProperties());
            } elseif ($annotation instanceof Annotation\Required) {
                $property->setRequired($annotation->getRequired());
            } elseif ($annotation instanceof Annotation\Dependencies) {
                $property->addDependency($annotation->getProperty(), $annotation->getValue());
            }
        }
    }

    protected function parsePropertyAnnotations(PropertyType $property, array $annotations)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Title) {
                $property->setTitle($annotation->getTitle());
            } elseif ($annotation instanceof Annotation\Description) {
                $property->setDescription($annotation->getDescription());
            } elseif ($annotation instanceof Annotation\Enum) {
                $property->setEnum($annotation->getEnum());
            } elseif ($annotation instanceof Annotation\Type) {
                $property->setType($annotation->getType());
            } elseif ($annotation instanceof Annotation\AllOf) {
                $property->setAllOf($this->parseRefs($annotation->getProperties()));
            } elseif ($annotation instanceof Annotation\AnyOf) {
                $property->setAnyOf($this->parseRefs($annotation->getProperties()));
            } elseif ($annotation instanceof Annotation\OneOf) {
                $property->setOneOf($this->parseRefs($annotation->getProperties()));
            } elseif ($annotation instanceof Annotation\Not) {
                $property->setNot($this->parseRef($annotation->getProperty()));
            }

            // number
            if ($annotation instanceof Annotation\Minimum) {
                $property->setMinimum($annotation->getMinimum());
            } elseif ($annotation instanceof Annotation\Maximum) {
                $property->setMaximum($annotation->getMaximum());
            } elseif ($annotation instanceof Annotation\ExclusiveMinimum) {
                $property->setExclusiveMinimum($annotation->getExclusiveMinimum());
            } elseif ($annotation instanceof Annotation\ExclusiveMaximum) {
                $property->setExclusiveMaximum($annotation->getExclusiveMaximum());
            } elseif ($annotation instanceof Annotation\MultipleOf) {
                $property->setMultipleOf($annotation->getMultipleOf());
            }

            // string
            if ($annotation instanceof Annotation\MinLength) {
                $property->setMinLength($annotation->getMinLength());
            } elseif ($annotation instanceof Annotation\MaxLength) {
                $property->setMaxLength($annotation->getMaxLength());
            } elseif ($annotation instanceof Annotation\Pattern) {
                $property->setPattern($annotation->getPattern());
            } elseif ($annotation instanceof Annotation\Format) {
                $property->setFormat($annotation->getFormat());
            }
            
            // array
            if ($annotation instanceof Annotation\Items) {
                $property->setItems($this->parseRef($annotation->getItems()));
            } elseif ($annotation instanceof Annotation\AdditionalItems) {
                $property->setAdditionalItems($annotation->getAdditionalItems());
            } elseif ($annotation instanceof Annotation\MinItems) {
                $property->setMinItems($annotation->getMinItems());
            } elseif ($annotation instanceof Annotation\MaxItems) {
                $property->setMaxItems($annotation->getMaxItems());
            } elseif ($annotation instanceof Annotation\UniqueItems) {
                $property->setUniqueItems($annotation->getUniqueItems());
            }
        }
    }

    protected function parseRefs($values)
    {
        if (!is_array($values)) {
            $values = [$values];
        }

        $result = [];
        foreach ($values as $value) {
            $result[] = $this->parseRef($value);
        }

        return $result;
    }

    protected function parseRef($value, $allowBoolean = false)
    {
        if ($value instanceof Annotation\Ref) {
            return $this->parseClass($value->getRef());
        } elseif ($value instanceof Annotation\Schema) {
            return $this->parseArray($this->resolveValues($value->getValues()));
        } elseif ($allowBoolean && is_bool($value)) {
            return $value;
        }

        return null;
    }

    protected function resolveValues(array $values)
    {
        $result = [];
        foreach ($values as $key => $row) {
            if ($row instanceof Annotation\Ref || $row instanceof Annotation\Schema) {
                $result[$key] = $this->parseRef($row);
            } elseif (is_array($row)) {
                $result[$key] = $this->resolveValues($row);
            } else {
                $result[$key] = $row;
            }
        }

        return $result;
    }
}
