<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\DateTime\Duration;
use PSX\DateTime\LocalDate;
use PSX\DateTime\LocalDateTime;
use PSX\DateTime\LocalTime;
use PSX\DateTime\Period;
use PSX\Schema\Exception\TraverserException;
use PSX\Schema\Exception\TypeNotFoundException;
use PSX\Schema\Exception\ValidationException;
use PSX\Schema\Type\AnyType;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\GenericType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\UnionType;
use PSX\Schema\Visitor\NullVisitor;

/**
 * SchemaTraverser
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class SchemaTraverser
{
    private array $pathStack = [];
    private bool $assertConstraints;

    public function __construct(bool $assertConstraints = true)
    {
        $this->assertConstraints = $assertConstraints;
    }

    /**
     * Traverses through the data and validates it according to the provided
     * schema. Calls also the visitor methods for each type
     *
     * @return mixed
     * @throws ValidationException
     * @throws TraverserException
     */
    public function traverse($data, SchemaInterface $schema, VisitorInterface $visitor = null)
    {
        $this->pathStack = [];

        if ($visitor === null) {
            $visitor = new NullVisitor();
        }

        return $this->recTraverse($data, $schema->getType(), $schema->getDefinitions(), $visitor);
    }

    /**
     * @throws TypeNotFoundException
     * @throws ValidationException
     * @throws TraverserException
     */
    protected function recTraverse($data, TypeInterface $type, DefinitionsInterface $definitions, VisitorInterface $visitor, array $context = [])
    {
        if ($type instanceof StructType) {
            if ($this->assertConstraints) {
                $this->assertStructConstraints($data, $type);
            }

            if ($data instanceof \stdClass) {
                $result = $this->traverseStruct($data, $type, $definitions, $visitor, $context);
            } else {
                $result = null;
            }
        } elseif ($type instanceof MapType) {
            if ($this->assertConstraints) {
                $this->assertMapConstraints($data, $type);
            }

            if ($data instanceof \stdClass) {
                $result = $this->traverseMap($data, $type, $definitions, $visitor, $context);
            } else {
                $result = null;
            }
        } elseif ($type instanceof ArrayType) {
            if ($this->assertConstraints) {
                $this->assertArrayConstraints($data, $type);
            }

            if (is_array($data)) {
                $result = $this->traverseArray($data, $type, $definitions, $visitor, $context);
            } else {
                $result = null;
            }
        } elseif ($type instanceof StringType) {
            if ($this->assertConstraints) {
                $this->assertStringConstraints($data, $type);
                $this->assertScalarConstraints($data, $type);
            }

            if (is_string($data)) {
                $result = $this->traverseString($data, $type, $visitor);
            } else {
                $result = null;
            }
        } elseif ($type instanceof IntegerType) {
            if ($this->assertConstraints) {
                $this->assertNumberConstraints($data, $type);
                $this->assertScalarConstraints($data, $type);
            }

            if (is_int($data)) {
                $result = $visitor->visitInteger($data, $type, $this->getCurrentPath());
            } else {
                $result = null;
            }
        } elseif ($type instanceof NumberType) {
            if ($this->assertConstraints) {
                $this->assertNumberConstraints($data, $type);
                $this->assertScalarConstraints($data, $type);
            }

            if (is_int($data) || is_float($data)) {
                $result = $visitor->visitNumber($data, $type, $this->getCurrentPath());
            } else {
                $result = null;
            }
        } elseif ($type instanceof BooleanType) {
            if ($this->assertConstraints) {
                $this->assertBooleanConstraints($data, $type);
            }

            if (is_bool($data)) {
                $result = $visitor->visitBoolean($data, $type, $this->getCurrentPath());
            } else {
                $result = null;
            }
        } elseif ($type instanceof IntersectionType) {
            $result = $this->traverseIntersection($data, $type, $definitions, $visitor, $context);
        } elseif ($type instanceof UnionType) {
            $result = $this->traverseUnion($data, $type, $definitions, $visitor, $context);
        } elseif ($type instanceof ReferenceType) {
            $subType = $definitions->getType($type->getRef());

            // in case a reference has a concrete class we inherit this class to the sub type
            $class = $type->getAttribute(TypeAbstract::ATTR_CLASS);
            if ($subType instanceof TypeAbstract && !empty($class)) {
                $subType->setAttribute(TypeAbstract::ATTR_CLASS, $class);
            }

            $result = $this->recTraverse($data, $subType, $definitions, $visitor, $type->getTemplate() ?: []);
        } elseif ($type instanceof GenericType) {
            if (!isset($context[$type->getGeneric()])) {
                throw new TraverserException('Could not resolve generic type from context');
            }

            $subType = $definitions->getType($context[$type->getGeneric()]);
            $result = $this->recTraverse($data, $subType, $definitions, $visitor, $context);
        } elseif ($type instanceof AnyType) {
            $result = $data;
        } else {
            $result = null;
        }

        return $result;
    }

    protected function traverseStruct(\stdClass $data, StructType $type, DefinitionsInterface $definitions, VisitorInterface $visitor, array $context)
    {
        $result = new \stdClass();
        $properties = [];

        $extends = $type->getExtends();
        while (!empty($extends)) {
            $parent = $definitions->getType($extends);
            if (!$parent instanceof StructType) {
                break;
            }

            $properties = array_merge($properties, $parent->getProperties() ?? []);
            $extends = $parent->getExtends();
        }

        $properties = array_merge($properties, $type->getProperties() ?? []);
        if (!empty($properties)) {
            $data = (array) $data;
            foreach ($properties as $key => $subType) {
                array_push($this->pathStack, $key);

                if (array_key_exists($key, $data)) {
                    $result->{$key} = $this->recTraverse($data[$key], $subType, $definitions, $visitor, $context);
                }

                array_pop($this->pathStack);
            }
        }

        return $visitor->visitStruct($result, $type, $this->getCurrentPath());
    }

    protected function traverseMap(\stdClass $data, MapType $type, DefinitionsInterface $definitions, VisitorInterface $visitor, array $context)
    {
        $data   = (array) $data;
        $result = new \stdClass();

        $additionalProperties = $type->getAdditionalProperties();
        if (is_bool($additionalProperties)) {
            if ($additionalProperties === true) {
                $result = (object) $data;
            }
        } elseif ($additionalProperties instanceof TypeInterface) {
            foreach ($data as $key => $value) {
                array_push($this->pathStack, $key);

                $result->{$key} = $this->recTraverse($data[$key], $additionalProperties, $definitions, $visitor, $context);

                array_pop($this->pathStack);
            }
        }

        return $visitor->visitMap($result, $type, $this->getCurrentPath());
    }

    protected function traverseArray(array $data, ArrayType $type, DefinitionsInterface $definitions, VisitorInterface $visitor, array $context)
    {
        $result = [];

        $items = $type->getItems();
        if ($items instanceof TypeInterface) {
            foreach ($data as $index => $value) {
                array_push($this->pathStack, $index);

                $result[] = $this->recTraverse($value, $items, $definitions, $visitor, $context);

                array_pop($this->pathStack);
            }
        }

        return $visitor->visitArray($result, $type, $this->getCurrentPath());
    }

    protected function traverseString($data, StringType $type, VisitorInterface $visitor)
    {
        $format = $type->getFormat();
        if ($format === TypeAbstract::FORMAT_BINARY) {
            return $visitor->visitBinary($data, $type, $this->getCurrentPath());
        } elseif ($format === TypeAbstract::FORMAT_DATETIME) {
            return $visitor->visitDateTime($data, $type, $this->getCurrentPath());
        } elseif ($format === TypeAbstract::FORMAT_DATE) {
            return $visitor->visitDate($data, $type, $this->getCurrentPath());
        } elseif ($format === TypeAbstract::FORMAT_DURATION) {
            return $visitor->visitDuration($data, $type, $this->getCurrentPath());
        } elseif ($format === TypeAbstract::FORMAT_PERIOD) {
            return $visitor->visitPeriod($data, $type, $this->getCurrentPath());
        } elseif ($format === TypeAbstract::FORMAT_TIME) {
            return $visitor->visitTime($data, $type, $this->getCurrentPath());
        } elseif ($format === TypeAbstract::FORMAT_URI) {
            return $visitor->visitUri($data, $type, $this->getCurrentPath());
        } else {
            return $visitor->visitString($data, $type, $this->getCurrentPath());
        }
    }

    /**
     * @throws ValidationException
     * @throws TypeNotFoundException
     * @throws Exception\InvalidSchemaException
     */
    protected function traverseIntersection($data, IntersectionType $type, DefinitionsInterface $definitions, VisitorInterface $visitor, array $context)
    {
        $items = $type->getAllOf();
        $count = count($items);
        $match = 0;

        $newType = new StructType();
        foreach ($items as $index => $item) {
            $assertConstraints = $this->assertConstraints;

            try {
                $this->assertConstraints = true;

                if ($item instanceof ReferenceType) {
                    $item = $definitions->getType($item->getRef());
                }

                if ($item instanceof StructType) {
                    foreach ($item->getProperties() as $name => $subType) {
                        $newType->addProperty($name, $subType);
                    }
                } else {
                    throw new ValidationException($this->getCurrentPath() . ' must only contain struct types', 'allOf', $this->pathStack);
                }

                $match++;
            } catch (ValidationException $e) {
            } finally {
                $this->assertConstraints = $assertConstraints;
            }
        }

        if ($this->assertConstraints && $count !== $match) {
            throw new ValidationException($this->getCurrentPath() . ' must match all required schemas (matched only ' . $match . ' out of ' . $count . ')', 'allOf', $this->pathStack);
        }

        return $this->recTraverse($data, $newType, $definitions, $visitor, $context);
    }

    /**
     * @throws ValidationException
     * @throws TypeNotFoundException
     */
    protected function traverseUnion($data, UnionType $type, DefinitionsInterface $definitions, VisitorInterface $visitor, array $context)
    {
        $propertyName = $type->getPropertyName();
        if (!empty($propertyName)) {
            return $this->traverseDiscriminatedUnion($data, $type, $definitions, $visitor, $context);
        }

        $items = $type->getOneOf();
        $match = 0;

        $result = null;
        foreach ($items as $index => $item) {
            $assertConstraints = $this->assertConstraints;

            try {
                $this->assertConstraints = true;

                $result = $this->recTraverse($data, $item, $definitions, $visitor, $context);

                $match++;
            } catch (ValidationException $e) {
            } finally {
                $this->assertConstraints = $assertConstraints;
            }
        }

        if ($this->assertConstraints && $match !== 1) {
            throw new ValidationException($this->getCurrentPath() . ' must match one required schema', 'oneOf', $this->pathStack);
        }

        return $result;
    }

    /**
     * @throws ValidationException
     * @throws TypeNotFoundException
     */
    private function traverseDiscriminatedUnion($data, UnionType $type, DefinitionsInterface $definitions, VisitorInterface $visitor, array $context)
    {
        if (!$data instanceof \stdClass) {
            throw new ValidationException($this->getCurrentPath() . ' discriminated union provided value must be an object', 'oneOf', $this->pathStack);
        }

        $key = $type->getPropertyName();
        if (!isset($data->{$key})) {
            throw new ValidationException($this->getCurrentPath() . ' discriminated union object must have the property "' . $key . '"', 'oneOf', $this->pathStack);
        }

        $mapping = $type->getMapping();
        if (!empty($mapping)) {
            if (!isset($mapping[$data->{$key}])) {
                throw new ValidationException($this->getCurrentPath() . ' discriminated union provided type "' . $data->{$key} . '" not available, use one of ' . implode(', ', array_keys($mapping)), 'oneOf', $this->pathStack);
            }

            $ref = $mapping[$data->{$key}];
        } else {
            $ref = $data->{$key};
        }

        $items = $type->getOneOf();
        foreach ($items as $item) {
            if (!$item instanceof ReferenceType) {
                // must be a reference type
                continue;
            }

            if ($item->getRef() === $ref) {
                return $this->recTraverse($data, $item, $definitions, $visitor, $context);
            }
        }

        throw new ValidationException($this->getCurrentPath() . ' discriminated union could not match fitting type', 'oneOf', $this->pathStack);
    }

    /**
     * @throws ValidationException
     */
    protected function assertScalarConstraints($data, ScalarType $type): void
    {
        if (!is_scalar($data)) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type scalar', 'type', $this->pathStack);
        }

        $format = $type->getFormat();
        if ($format !== null && is_string($data)) {
            if ($format === TypeAbstract::FORMAT_BINARY) {
                if (!preg_match('~^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?$~', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid Base64 encoded string [RFC4648]', 'format', $this->pathStack);
                }
            } elseif ($format === TypeAbstract::FORMAT_DATETIME) {
                if (!preg_match('/^' . LocalDateTime::getPattern() . '$/', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid date-time format [RFC3339]', 'format', $this->pathStack);
                }
            } elseif ($format === TypeAbstract::FORMAT_DATE) {
                if (!preg_match('/^' . LocalDate::getPattern() . '$/', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid full-date format [RFC3339]', 'format', $this->pathStack);
                }
            } elseif ($format === TypeAbstract::FORMAT_PERIOD) {
                if (!preg_match('/^' . Period::getPattern() . '$/', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid period format [ISO8601]', 'format', $this->pathStack);
                }
            } elseif ($format === TypeAbstract::FORMAT_DURATION) {
                if (!preg_match('/^' . Duration::getPattern() . '$/', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid duration format [ISO8601]', 'format', $this->pathStack);
                }
            } elseif ($format === TypeAbstract::FORMAT_TIME) {
                if (!preg_match('/^' . LocalTime::getPattern() . '$/', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid full-time format [RFC3339]', 'format', $this->pathStack);
                }
            } elseif ($format === 'email') {
                if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
                    throw new ValidationException($this->getCurrentPath() . ' must contain a valid email address', 'format', $this->pathStack);
                }
            } elseif ($format === 'ipv4') {
                if (!filter_var($data, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    throw new ValidationException($this->getCurrentPath() . ' must contain a valid IPv4 address', 'format', $this->pathStack);
                }
            } elseif ($format === 'ipv6') {
                if (!filter_var($data, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    throw new ValidationException($this->getCurrentPath() . ' must contain a valid IPv6 address', 'format', $this->pathStack);
                }
            }
        }

        $enum = $type->getEnum();
        if ($enum !== null) {
            if (!in_array($data, $enum, true)) {
                throw new ValidationException($this->getCurrentPath() . ' is not in enumeration ' . json_encode($enum), 'enum', $this->pathStack);
            }
        }

        $const = $type->getConst();
        if ($const !== null) {
            if ($const !== $data) {
                throw new ValidationException($this->getCurrentPath() . ' must contain the constant value ' . json_encode($const), 'const', $this->pathStack);
            }
        }
    }

    /**
     * @throws ValidationException
     */
    protected function assertStructConstraints($data, StructType $type): void
    {
        if (!$data instanceof \stdClass) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type object', 'type', $this->pathStack);
        }

        $keys = array_keys(get_object_vars($data));

        $required = $type->getRequired();
        if ($required !== null) {
            $diff = array_diff($required, $keys);
            if (count($diff) > 0) {
                throw new ValidationException($this->getCurrentPath() . ' the following properties are required: ' . implode(', ', $diff), 'required', $this->pathStack);
            }
        }
    }

    /**
     * @throws ValidationException
     */
    protected function assertMapConstraints($data, MapType $type): void
    {
        if (!$data instanceof \stdClass) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type object', 'type', $this->pathStack);
        }

        $keys = array_keys(get_object_vars($data));

        $minProperties = $type->getMinProperties();
        if ($minProperties !== null) {
            if (count($keys) < $minProperties) {
                throw new ValidationException($this->getCurrentPath() . ' must contain more or equal than ' . $minProperties . ' properties', 'minProperties', $this->pathStack);
            }
        }

        $maxProperties = $type->getMaxProperties();
        if ($maxProperties !== null) {
            if (count($keys) > $maxProperties) {
                throw new ValidationException($this->getCurrentPath() . ' must contain less or equal than ' . $maxProperties . ' properties', 'maxProperties', $this->pathStack);
            }
        }
    }

    /**
     * @throws ValidationException
     */
    protected function assertArrayConstraints($data, ArrayType $type): void
    {
        if (!is_array($data)) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type array', 'type', $this->pathStack);
        }

        $minItems = $type->getMinItems();
        if ($minItems !== null) {
            if (count($data) < $minItems) {
                throw new ValidationException($this->getCurrentPath() . ' must contain more or equal than ' . $minItems . ' items', 'minItems', $this->pathStack);
            }
        }

        $maxItems = $type->getMaxItems();
        if ($maxItems !== null) {
            if (count($data) > $maxItems) {
                throw new ValidationException($this->getCurrentPath() . ' must contain less or equal than ' . $maxItems . ' items', 'maxItems', $this->pathStack);
            }
        }
    }

    /**
     * @throws ValidationException
     */
    protected function assertNumberConstraints($data, NumberType $property): void
    {
        if ($property instanceof IntegerType) {
            if (!is_int($data)) {
                throw new ValidationException($this->getCurrentPath() . ' must be of type integer', 'type', $this->pathStack);
            }
        } else {
            if (!is_float($data) && !is_int($data)) {
                throw new ValidationException($this->getCurrentPath() . ' must be of type float', 'type', $this->pathStack);
            }
        }

        $maximum = $property->getMaximum();
        if ($maximum !== null) {
            if ($property->getExclusiveMaximum()) {
                if ($data >= $maximum) {
                    throw new ValidationException($this->getCurrentPath() . ' must be lower than ' . $maximum, 'maximum', $this->pathStack);
                }
            } else {
                if ($data > $maximum) {
                    throw new ValidationException($this->getCurrentPath() . ' must be lower or equal than ' . $maximum, 'maximum', $this->pathStack);
                }
            }
        }

        $minimum = $property->getMinimum();
        if ($minimum !== null) {
            if ($property->getExclusiveMinimum()) {
                if ($data <= $minimum) {
                    throw new ValidationException($this->getCurrentPath() . ' must be greater than ' . $minimum, 'minimum', $this->pathStack);
                }
            } else {
                if ($data < $minimum) {
                    throw new ValidationException($this->getCurrentPath() . ' must be greater or equal than ' . $minimum, 'minimum', $this->pathStack);
                }
            }
        }

        $multipleOf = $property->getMultipleOf();
        if ($multipleOf !== null) {
            $result = $data / $multipleOf;
            $base   = (int) $result;

            // its important to make a loose comparison
            if ($data > 0 && $result - $base != 0) {
                throw new ValidationException($this->getCurrentPath() . ' must be a multiple of ' . $multipleOf, 'multipleOf', $this->pathStack);
            }
        }
    }

    /**
     * @throws ValidationException
     */
    protected function assertBooleanConstraints($data, BooleanType $type): void
    {
        if (!is_bool($data)) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type boolean', 'type', $this->pathStack);
        }
    }

    /**
     * @throws ValidationException
     */
    protected function assertStringConstraints($data, StringType $property): void
    {
        if (!is_string($data)) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type string', 'type', $this->pathStack);
        }

        $minLength = $property->getMinLength();
        if ($minLength !== null) {
            if (strlen($data) < $minLength) {
                throw new ValidationException($this->getCurrentPath() . ' must contain more or equal than ' . $minLength . ' characters', 'minLength', $this->pathStack);
            }
        }

        $maxLength = $property->getMaxLength();
        if ($maxLength !== null) {
            if (strlen($data) > $maxLength) {
                throw new ValidationException($this->getCurrentPath() . ' must contain less or equal than ' . $maxLength . ' characters', 'maxLength', $this->pathStack);
            }
        }

        $pattern = $property->getPattern();
        if ($pattern !== null) {
            $result = preg_match('/' . $pattern . '/', $data);
            if (!$result) {
                throw new ValidationException($this->getCurrentPath() . ' does not match pattern [' . $pattern . ']', 'pattern', $this->pathStack);
            }
        }
    }

    private function getCurrentPath(): string
    {
        return '/' . implode('/', $this->pathStack);
    }
}
