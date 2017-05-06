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

namespace PSX\Schema\Parser;

use Doctrine\Common\Annotations\Reader;
use InvalidArgumentException;
use PSX\Schema\Parser\Popo\Annotation;
use PSX\Schema\Parser\Popo\ObjectReader;
use PSX\Schema\ParserInterface;
use PSX\Schema\PropertyType;
use PSX\Schema\Schema;
use ReflectionClass;

/**
 * Tries to import the data into a plain old php object
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
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
            return $this->objects[$className];
        }

        $class       = new ReflectionClass($className);
        $annotations = $this->reader->getClassAnnotations($class);
        $property    = new PropertyType();
        $property->setType('object');
        $property->setRef('urn:phpsx.org:schema:class:' . strtolower($className));
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
            $property = new PropertyType();
            $this->parsePropertyAnnotations($property, $value->getAnnotations());
            return $property;
        } elseif ($allowBoolean && is_bool($value)) {
            return $value;
        }

        return null;
    }
}
