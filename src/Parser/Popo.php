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
use PSX\Schema\Definitions;
use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Parser\Popo\Annotation;
use PSX\Schema\Parser\Popo\ObjectReader;
use PSX\Schema\Parser\Popo\Resolver\Composite;
use PSX\Schema\ParserInterface;
use PSX\Schema\Property;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
use PSX\Schema\Schema;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\UnionType;
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
     * @var \PSX\Schema\Parser\Popo\Resolver\Composite
     */
    protected $resolver;

    /**
     * @param \Doctrine\Common\Annotations\Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader   = $reader;
        $this->resolver = new Popo\Resolver\Composite(
            new Popo\Resolver\Native(),
            new Popo\Resolver\Documentor(),
            new Popo\Resolver\Annotation($reader)
        );
    }

    public function parse($className)
    {
        if (!is_string($className)) {
            throw new InvalidArgumentException('Class name must be a string');
        }

        $definitions = new Definitions();
        $property    = $this->parseClass($className, $definitions);

        return new Schema($property, $definitions);
    }

    protected function parseClass(string $className, DefinitionsInterface $definitions)
    {
        $class = new ReflectionClass($className);

        $property    = $this->resolver->resolveClass($class);
        $annotations = $this->reader->getClassAnnotations($class);

        $property->setTitle($class->getShortName());

        if ($property instanceof PropertyType) {
            $this->parseCommonAnnotations($annotations, $property);
        }

        if ($property instanceof MapType) {
            $additionalProperties = $property->getAdditionalProperties();
            if ($additionalProperties instanceof ReferenceType) {
                $property->setAdditionalProperties($this->parseClass($additionalProperties->getRef()));
            }

            $this->parseMapAnnotations($annotations, $property);
        } elseif ($property instanceof StructType) {
            $this->parseStructAnnotations($annotations, $property);
            $this->parseProperties($class, $property);
        } else {
            throw new \RuntimeException('Could not determine class type');
        }

        $property->setAttribute(PropertyType::ATTR_CLASS, $class->getName());

        return $property;
    }

    private function parseProperties(ReflectionClass $class, StructType $property)
    {
        $properties = ObjectReader::getProperties($this->reader, $class);
        $mapping    = [];

        foreach ($properties as $key => $reflection) {
            if ($key != $reflection->getName()) {
                $mapping[$key] = $reflection->getName();
            }

            $prop = $this->parseProperty($reflection);
            if ($prop !== null) {
                $property->addProperty($key, $prop);
            }
        }

        if (!empty($mapping)) {
            $property->setAttribute(PropertyType::ATTR_MAPPING, $mapping);
        }
    }

    private function parseProperty(\ReflectionProperty $reflection): ?PropertyInterface
    {
        $property    = $this->resolver->resolveProperty($reflection);
        $annotations = $this->reader->getPropertyAnnotations($reflection);

        if ($property instanceof ReferenceType) {
            $type = $this->parseClass($property->getRef());
            $this->definitions->addType(DefinitionsInterface::SELF_NAMESPACE, $property->getRef(), $type);
        }

        if ($property instanceof PropertyType) {
            $this->parseCommonAnnotations($annotations, $property);
        }

        if ($property instanceof ScalarType) {
            $this->parseScalarAnnotations($annotations, $property);
        }

        if ($property instanceof ArrayType) {
            $items = $property->getItems();
            if ($items instanceof ReferenceType) {
                $type = $this->parseClass($items->getRef());
                $this->definitions->addType(DefinitionsInterface::SELF_NAMESPACE, $items->getRef(), $type);
            }

            $this->parseArrayAnnotations($annotations, $property);
        } elseif ($property instanceof StringType) {
            $this->parseStringAnnotations($annotations, $property);
        } elseif ($property instanceof NumberType) {
            $this->parseNumberAnnotations($annotations, $property);
        }

        if ($property instanceof UnionType) {
            $oneOf = $property->getOneOf();
            foreach ($oneOf as $prop) {
                if ($prop instanceof ReferenceType) {
                    $type = $this->parseClass($prop->getRef());
                    $this->definitions->addType(DefinitionsInterface::SELF_NAMESPACE, $prop->getRef(), $type);
                }
            }
        } elseif ($property instanceof IntersectionType) {
            $allOf = $property->getAllOf();
            foreach ($allOf as $prop) {
                if ($prop instanceof ReferenceType) {
                    $type = $this->parseClass($prop->getRef());
                    $this->definitions->addType(DefinitionsInterface::SELF_NAMESPACE, $prop->getRef(), $type);
                }
            }
        }

        return $property;
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
            if ($annotation instanceof Annotation\MinProperties) {
                $property->setMinProperties($annotation->getMinProperties());
            } elseif ($annotation instanceof Annotation\MaxProperties) {
                $property->setMaxProperties($annotation->getMaxProperties());
            }
        }
    }

    private function parseArrayAnnotations(array $annotations, ArrayType $property)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\MinItems) {
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
}
