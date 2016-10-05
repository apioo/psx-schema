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
        $this->stack   = [];

        $object = new Property\ComplexType('record');
        $object->setReference($className);

        $key = $className . null . $className;

        $this->addProperty($key, $object);

        $this->parseComplexType($object);

        return new Schema($object);
    }

    /**
     * @param \PSX\Schema\PropertyInterface $property
     * @param \PSX\Schema\Parser\Popo\TypeParser $typeObject
     * @param array $annotations
     */
    protected function parseProperty(PropertyInterface $property, TypeParser $typeObject, array $annotations, $className, $propertyName)
    {
        // set type hint if available
        $typeHint = $typeObject->getTypeHint();
        if (!empty($typeHint)) {
            $property->setReference($typeHint);
        }

        // parse annotations
        if ($property instanceof PropertyAbstract) {
            $this->parseProperties($property, $annotations);
        }

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

        if ($property instanceof Property\ArrayType) {
            $this->parseArrayType($property, $typeObject);
        } elseif ($property instanceof Property\ChoiceType) {
            $this->parseChoiceType($property, $typeObject);
        } elseif ($property instanceof Property\ComplexType) {
            $key       = $className . $propertyName . $typeObject->getTypeHint();
            $foundProp = $this->findProperty($key);

            if ($foundProp !== null) {
                return $foundProp;
            }

            $this->addProperty($key, $property);
            $this->pushProperty($key, $property);
            
            $this->parseComplexType($property);
            
            $this->popProperty();
        } elseif ($property instanceof Property\DateTimeType) {
            $subTypes = $typeObject->getSubTypes();
            $subType  = reset($subTypes);

            if (!empty($subType)) {
                $property->setPattern($this->getDateTimePattern($subType));
            }
        }

        return $property;
    }

    protected function parseArrayType(Property\ArrayType $property, TypeParser $typeObject)
    {
        $subTypes = $typeObject->getSubTypes();
        $subType  = reset($subTypes);

        if (!empty($subType)) {
            $property->setPrototype($this->getPropertyForType($subType));
        } else {
            throw new RuntimeException('Array type must have a sub type');
        }
    }
    
    protected function parseChoiceType(Property\ChoiceType $property, TypeParser $typeObject)
    {
        $subTypes = $typeObject->getSubTypes();

        if (!empty($subTypes)) {
            foreach ($subTypes as $name => $subType) {
                $property->add($this->getPropertyForType($subType));
            }
        } else {
            throw new RuntimeException('Choice type must have a sub type');
        }
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
                $additionalProperties = $annotation->getAdditionalProperties();
                if (is_bool($additionalProperties)) {
                    $property->setAdditionalProperties($additionalProperties);
                } elseif (is_string($additionalProperties)) {
                    $property->setAdditionalProperties($this->getPropertyForType($additionalProperties));
                }
            } elseif ($annotation instanceof Annotation\PatternProperty) {
                $property->addPatternProperty(
                    $annotation->getPattern(), 
                    $this->getPropertyForType($annotation->getType())
                );
            } elseif ($annotation instanceof Annotation\MinProperties) {
                $property->setMinProperties($annotation->getMinProperties());
            } elseif ($annotation instanceof Annotation\MaxProperties) {
                $property->setMaxProperties($annotation->getMaxProperties());
            }
        }

        $className  = $class->getName();
        $properties = ObjectReader::getProperties($this->reader, $class);
        foreach ($properties as $key => $reflection) {
            $annotations = $this->reader->getPropertyAnnotations($reflection);

            $type = $this->getTypeForProperty($reflection->getDocComment(), $annotations);
            if (empty($type)) {
                $type = 'string';
            }

            $typeObject = TypeParser::parse($type);

            $prop = $this->getPropertyType($typeObject->getBaseType(), $key);
            $prop = $this->parseProperty($prop, $typeObject, $annotations, $className, $reflection->getName());

            $property->add($key, $prop);
        }
    }

    protected function parseArrayProperties(Property\ArrayType $property, array $annotations)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\MinItems) {
                $property->setMinItems($annotation->getMinItems());
            } elseif ($annotation instanceof Annotation\MaxItems) {
                $property->setMaxItems($annotation->getMaxItems());
            }

            // the MinLength and MaxLength annotations are deprecated for an
            // array property
            if ($annotation instanceof Annotation\MinLength) {
                trigger_error("The MinLength annotation is deprecated for array properties use instead the MinItems annotation", E_USER_DEPRECATED);

                $property->setMinItems($annotation->getMinLength());
            } elseif ($annotation instanceof Annotation\MaxLength) {
                trigger_error("The MaxLength annotation is deprecated for array properties use instead the MaxItems annotation", E_USER_DEPRECATED);

                $property->setMaxItems($annotation->getMaxLength());
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

    protected function getTypeForProperty($docComment, array $annotations)
    {
        $type = null;
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Type) {
                $type = $annotation->getType();
            }
        }

        if ($type === null) {
            // as fallback we try to read the @var annotation
            preg_match('/\* @var (.*)\\s/imsU', $docComment, $matches);
            if (isset($matches[1])) {
                $type = $matches[1];
            } else {
                $type = null;
            }
        }

        return $type;
    }

    protected function getPropertyType($type, $key)
    {
        switch ($type) {
            case 'array':
                return new Property\ArrayType($key);
                break;

            case 'binary':
                return new Property\BinaryType($key);
                break;

            case 'bool':
            case 'boolean':
            return new Property\BooleanType($key);
                break;

            case 'choice':
                return new Property\ChoiceType($key);
                break;

            case 'complex':
                return new Property\ComplexType($key);
                break;

            case 'datetime':
                return new Property\DateTimeType($key);
                break;

            case 'date':
                return new Property\DateType($key);
                break;

            case 'duration':
                return new Property\DurationType($key);
                break;

            case 'float':
                return new Property\FloatType($key);
                break;

            case 'int':
            case 'integer':
                return new Property\IntegerType($key);
                break;

            case 'time':
                return new Property\TimeType($key);
                break;

            case 'uri':
                return new Property\UriType($key);
                break;

            case 'string':
            default:
                return new Property\StringType($key);
                break;
        }
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

    protected function getPropertyForType($type)
    {
        $typeObject = TypeParser::parse($type);
        $property   = $this->getPropertyType($typeObject->getBaseType(), null);

        return $this->parseProperty($property, $typeObject, [], $typeObject->getTypeHint(), null);
    }
    
    protected function findProperty($key)
    {
        if (isset($this->stack[$key])) {
            return new Property\RecursionType($this->stack[$key]);
        }

        if (isset($this->objects[$key])) {
            return $this->objects[$key];
        }

        return null;
    }

    protected function addProperty($key, PropertyInterface $property)
    {
        $this->objects[$key] = $property;
    }

    protected function pushProperty($key, PropertyInterface $property)
    {
        $this->stack[$key] = $property;
    }

    protected function popProperty()
    {
        array_pop($this->stack);
    }
}
