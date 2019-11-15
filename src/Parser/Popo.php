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

namespace PSX\Schema\Parser;

use Doctrine\Common\Annotations\Reader;
use InvalidArgumentException;
use PSX\Schema\Parser\Popo\Annotation;
use PSX\Schema\Parser\Popo\ObjectReader;
use PSX\Schema\ParserInterface;
use PSX\Schema\Property;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
use PSX\Schema\Schema;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
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

    protected function parseClass(string $className)
    {
        if (isset($this->objects[$className])) {
            return $this->objects[$className];
        }

        $class = new ReflectionClass($className);
        $annotations = $this->reader->getClassAnnotations($class);

        $annotation = $this->getAnnotation($annotations, Annotation\AdditionalProperties::class);
        if ($annotation instanceof Annotation\AdditionalProperties && $annotation->getAdditionalProperties() !== false) {
            $property = Property::getMap();
            $this->objects[$className] = $property;

            $this->parseCommonAnnotations($annotations, $property);
            $this->parseMapAnnotations($annotations, $property);
        } else {
            $property = Property::getStruct();
            $this->objects[$className] = $property;

            $this->parseCommonAnnotations($annotations, $property);
            $this->parseStructAnnotations($annotations, $property);
            $this->parseProperties($class, $property);
        }

        $property->setAttribute(PropertyType::ATTR_CLASS, $class->getName());

        return $property;
    }

    private function parseProperties(ReflectionClass $class, StructType $property)
    {
        $properties = ObjectReader::getProperties($this->reader, $class);
        $mapping    = [];

        foreach ($properties as $key => $reflection) {
            $annotations = $this->reader->getPropertyAnnotations($reflection);

            if ($key != $reflection->getName()) {
                $mapping[$key] = $reflection->getName();
            }

            $prop = $this->parsePropertyAnnotations($annotations);
            if ($prop !== null) {
                $property->addProperty($key, $prop);
            }
        }

        if (!empty($mapping)) {
            $property->setAttribute(PropertyType::ATTR_MAPPING, $mapping);
        }
    }

    private function parsePropertyAnnotations(array $annotations): ?PropertyInterface
    {
        $type     = $this->getTypeByAnnotation($annotations);
        $property = null;

        if ($type === 'array') {
            $property = Property::getArray();
            $this->parseCommonAnnotations($annotations, $property);
            $this->parseArrayAnnotations($annotations, $property);
        } elseif ($type === 'string') {
            $property = Property::getString();
            $this->parseCommonAnnotations($annotations, $property);
            $this->parseScalarAnnotations($annotations, $property);
            $this->parseStringAnnotations($annotations, $property);
        } elseif ($type === 'number') {
            $property = Property::getNumber();
            $this->parseCommonAnnotations($annotations, $property);
            $this->parseScalarAnnotations($annotations, $property);
            $this->parseNumberAnnotations($annotations, $property);
        } elseif ($type === 'integer') {
            $property = Property::getInteger();
            $this->parseCommonAnnotations($annotations, $property);
            $this->parseScalarAnnotations($annotations, $property);
            $this->parseNumberAnnotations($annotations, $property);
        } elseif ($type === 'boolean') {
            $property = Property::getBoolean();
            $this->parseCommonAnnotations($annotations, $property);
        } elseif ($annotation = $this->getAnnotation($annotations, Annotation\AllOf::class)) {
            $property = Property::getIntersection();
            $property->setAllOf($this->parseRefs($annotation->getProperties()));
        } elseif ($annotation = $this->getAnnotation($annotations, Annotation\OneOf::class)) {
            $property = Property::getUnion();
            $property->setOneOf($this->parseRefs($annotation->getProperties()));
        } elseif ($annotation = $this->getAnnotation($annotations, Annotation\Ref::class)) {
            $property = $this->parseClass($annotation->getRef());
        }

        return $property;
    }

    private function parseRefs($values)
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

    private function parseRef($value, $allowBoolean = false)
    {
        if ($value instanceof Annotation\Ref) {
            return $this->parseClass($value->getRef());
        } elseif ($value instanceof Annotation\Schema) {
            return $this->parsePropertyAnnotations($value->getAnnotations());
        } elseif ($allowBoolean && is_bool($value)) {
            return $value;
        }

        return null;
    }

    private function parseCommonAnnotations(array $annotations, PropertyType $property)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Title) {
                $property->setTitle($annotation->getTitle());
            } elseif ($annotation instanceof Annotation\Description) {
                $property->setDescription($annotation->getDescription());
            } elseif ($annotation instanceof Annotation\Nullable) {
                $property->setNullable($annotation->isNullable());
            } elseif ($annotation instanceof Annotation\Deprecated) {
                $property->setDeprecated($annotation->isDeprecated());
            } elseif ($annotation instanceof Annotation\Readonly) {
                $property->setReadonly($annotation->isReadonly());
            }
        }
    }

    private function parseScalarAnnotations(array $annotations, ScalarType $property)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Format) {
                $property->setFormat($annotation->getFormat());
            } elseif ($annotation instanceof Annotation\Enum) {
                $property->setEnum($annotation->getEnum());
            }
        }
    }

    private function parseStructAnnotations(array $annotations, StructType $property)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Required) {
                $property->setRequired($annotation->getRequired());
            }
        }
    }

    private function parseMapAnnotations(array $annotations, MapType $property)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\AdditionalProperties) {
                $property->setAdditionalProperties($this->parseRef($annotation->getAdditionalProperties(), true));
            } elseif ($annotation instanceof Annotation\MinProperties) {
                $property->setMinProperties($annotation->getMinProperties());
            } elseif ($annotation instanceof Annotation\MaxProperties) {
                $property->setMaxProperties($annotation->getMaxProperties());
            }
        }
    }

    private function parseArrayAnnotations(array $annotations, ArrayType $property)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Items) {
                $property->setItems($this->parseRef($annotation->getItems()));
            } elseif ($annotation instanceof Annotation\MinItems) {
                $property->setMinItems($annotation->getMinItems());
            } elseif ($annotation instanceof Annotation\MaxItems) {
                $property->setMaxItems($annotation->getMaxItems());
            } elseif ($annotation instanceof Annotation\UniqueItems) {
                $property->setUniqueItems($annotation->getUniqueItems());
            }
        }
    }

    private function parseStringAnnotations(array $annotations, StringType $property)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\MinLength) {
                $property->setMinLength($annotation->getMinLength());
            } elseif ($annotation instanceof Annotation\MaxLength) {
                $property->setMaxLength($annotation->getMaxLength());
            } elseif ($annotation instanceof Annotation\Pattern) {
                $property->setPattern($annotation->getPattern());
            } elseif ($annotation instanceof Annotation\Format) {
                $property->setFormat($annotation->getFormat());
            }
        }
    }

    private function parseNumberAnnotations(array $annotations, NumberType $property)
    {
        foreach ($annotations as $annotation) {
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
        }
    }

    private function getTypeByAnnotation(array $annotations): ?string
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Type) {
                return $annotation->getType();
            }
        }

        return null;
    }

    private function getAnnotation(array $annotations, string $class)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof $class) {
                return $annotation;
            }
        }

        return null;
    }
}
