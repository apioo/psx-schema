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
        $this->stack   = [];

        $object = new Property\ComplexType('record');
        $object->setReference($className);

        $this->parseComplexType($object);

        return new Schema($object);
    }

    /**
     * @param string $type
     * @param string $key
     * @param ReflectionProperty $reflection
     * @param array $annotations
     * @return \PSX\Schema\PropertyInterface
     */
    protected function getProperty($type, $key, ReflectionProperty $reflection, array $annotations = null)
    {
        if (empty($type)) {
            $type = 'string';
        }

        if (($property = $this->findProperty($type, $reflection)) !== null) {
            return $property;
        }

        $typeObject = TypeParser::parse($type);

        switch ($typeObject->getBaseType()) {
            case 'any':
            case 'map':
                $property = new Property\AnyType($key);
                $subTypes = $typeObject->getSubTypes();

                if (!empty($subTypes)) {
                    $prop = $this->getProperty(reset($subTypes), null, $reflection);
                    $property->setPrototype($prop);
                } else {
                    throw new RuntimeException('Any type must have a sub type');
                }
                break;

            case 'array':
                $property = new Property\ArrayType($key);
                $subTypes = $typeObject->getSubTypes();

                if (!empty($subTypes)) {
                    $prop = $this->getProperty(reset($subTypes), null, $reflection);
                    $property->setPrototype($prop);
                } else {
                    throw new RuntimeException('Array type must have a sub type');
                }
                break;

            case 'binary':
                $property = new Property\BinaryType($key);
                break;

            case 'bool':
            case 'boolean':
                $property = new Property\BooleanType($key);
                break;

            case 'choice':
                $property = new Property\ChoiceType($key);
                $subTypes = $typeObject->getSubTypes();

                if (!empty($subTypes)) {
                    foreach ($subTypes as $name => $complexType) {
                        $prop = $this->getProperty($complexType, $name, $reflection);
                        $prop->setName($name);

                        $property->add($prop);
                    }
                } else {
                    throw new RuntimeException('Choice type must have a sub type');
                }
                break;

            case 'complex':
                $property = new Property\ComplexType($key);
                $property->setReference($typeObject->getTypeHint());

                $this->addObjectCache($type, $reflection, $property);
                $this->pushProperty($type, $reflection, $property);

                $this->parseComplexType($property);

                $this->popProperty();
                break;

            case 'datetime':
                $property = new Property\DateTimeType($key);
                $subTypes = $typeObject->getSubTypes();
                $subType  = reset($subTypes);

                if (!empty($subType)) {
                    $property->setPattern($this->getDateTimePattern($subType));
                }
                break;

            case 'date':
                $property = new Property\DateType($key);
                break;

            case 'duration':
                $property = new Property\DurationType($key);
                break;

            case 'float':
                $property = new Property\FloatType($key);
                break;

            case 'int':
            case 'integer':
                $property = new Property\IntegerType($key);
                break;
            
            case 'time':
                $property = new Property\TimeType($key);
                break;

            case 'uri':
                $property = new Property\UriType($key);
                break;

            case 'string':
            default:
                $property = new Property\StringType($key);
                break;
        }

        // set type hint if available
        $typeHint = $typeObject->getTypeHint();
        if (!empty($typeHint)) {
            $property->setReference($typeHint);
        }

        if (!empty($annotations)) {
            $this->parseProperties($property, $annotations);

            if ($property instanceof Property\ArrayType) {
                $this->parseArrayProperties($property, $annotations);
            } elseif ($property instanceof Property\DecimalType) {
                $this->parseDecimalProperties($property, $annotations);
            } elseif ($property instanceof Property\StringType) {
                $this->parseStringProperties($property, $annotations);
            }

            if ($property instanceof PropertySimpleAbstract) {
                $this->parseSimpleProperties($property, $annotations);
            }
        }

        return $property;
    }

    protected function parseComplexType(Property\ComplexType $property)
    {
        $class       = new ReflectionClass($property->getReference());
        $annotations = $this->reader->getClassAnnotations($class);

        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Title) {
                $property->setName($annotation->getTitle());
            } elseif ($annotation instanceof Annotation\Description) {
                $property->setDescription($annotation->getDescription());
            } elseif ($annotation instanceof Annotation\AdditionalProperties) {
                $property->setAdditionalProperties($annotation->hasAdditionalProperties());
            }
        }

        $properties = ObjectReader::getProperties($this->reader, $class);
        foreach ($properties as $key => $reflection) {
            $annotations = $this->reader->getPropertyAnnotations($reflection);
            $type        = $this->getTypeForProperty($reflection, $annotations);
            $prop        = $this->getProperty($type, $key, $reflection, $annotations);

            if ($prop instanceof PropertyInterface) {
                $property->add($prop);
            }
        }
    }

    protected function parseArrayProperties(Property\ArrayType $property, array $annotations)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\MinLength) {
                $property->setMinLength($annotation->getMinLength());
            } elseif ($annotation instanceof Annotation\MaxLength) {
                $property->setMaxLength($annotation->getMaxLength());
            }
        }
    }

    protected function parseDecimalProperties(Property\DecimalType $property, array $annotations)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Minimum) {
                $property->setMin($annotation->getMin());
            } elseif ($annotation instanceof Annotation\Maximum) {
                $property->setMax($annotation->getMax());
            }
        }
    }

    protected function parseStringProperties(Property\StringType $property, array $annotations)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\MinLength) {
                $property->setMinLength($annotation->getMinLength());
            } elseif ($annotation instanceof Annotation\MaxLength) {
                $property->setMaxLength($annotation->getMaxLength());
            }
        }
    }

    protected function parseSimpleProperties(PropertySimpleAbstract $property, array $annotations)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Pattern) {
                $property->setPattern($annotation->getPattern());
            } elseif ($annotation instanceof Annotation\Enum) {
                $property->setEnumeration($annotation->getEnum());
            }
        }
    }

    protected function parseProperties(PropertyAbstract $property, array $annotations)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Key) {
                $property->setName($annotation->getKey());
            } elseif ($annotation instanceof Annotation\Required) {
                $property->setRequired(true);
            } elseif ($annotation instanceof Annotation\Description) {
                $property->setDescription($annotation->getDescription());
            }
        }
    }

    protected function getTypeForProperty(ReflectionProperty $property, array $annotations)
    {
        $type = null;
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Type) {
                $type = $annotation->getType();
            }
        }

        if ($type === null) {
            // as fallback we try to read the @var annotation
            preg_match('/\* @var (.*)\\s/imsU', $property->getDocComment(), $matches);
            if (isset($matches[1])) {
                $type = $matches[1];
            } else {
                $type = null;
            }
        }

        return $type;
    }

    /**
     * This method returns the datetime pattern of a specific name. This format
     * gets written into the pattern property. Since these format are no valid
     * regexp it would be great to convert the formats to the fitting regexp and
     * in the validation visitor back to the date time format so that we would
     * produce valid JSON schema patterns
     *
     * @param string $typeHint
     * @return string
     */
    protected function getDateTimePattern($typeHint)
    {
        switch ($typeHint) {
            case 'COOKIE':
                return \DateTime::COOKIE;
                break;

            case 'ISO8601':
                return \DateTime::ISO8601;
                break;

            case 'RFC822':
            case 'RFC1036':
            case 'RFC1123':
            case 'RFC2822':
                return \DateTime::RFC2822;
                break;

            case 'RFC850':
                return \DateTime::RFC850;
                break;

            case 'RSS':
                return \DateTime::RSS;
                break;

            case 'ATOM':
            case 'RFC3339':
            case 'W3C':
            default:
                return \DateTime::W3C;
                break;
        }
    }

    protected function findProperty($type, ReflectionProperty $reflection)
    {
        $id = $reflection->getDeclaringClass()->getName() . '::' . $reflection->getName() . '{' . $type . '}';

        if (isset($this->stack[$id])) {
            return new Property\RecursionType($this->stack[$id]);
        }

        if (isset($this->objects[$id])) {
            return $this->objects[$id];
        }

        return null;
    }

    protected function addObjectCache($type, ReflectionProperty $reflection, PropertyInterface $property)
    {
        $this->objects[$reflection->getDeclaringClass()->getName() . '::' . $reflection->getName() . '{' . $type . '}'] = $property;
    }

    protected function pushProperty($type, ReflectionProperty $reflection, PropertyInterface $property)
    {
        $this->stack[$reflection->getDeclaringClass()->getName() . '::' . $reflection->getName() . '{' . $type . '}'] = $property;
    }

    protected function popProperty()
    {
        array_pop($this->stack);
    }
}
