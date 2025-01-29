<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\DateTime\LocalDate;
use PSX\DateTime\LocalDateTime;
use PSX\DateTime\LocalTime;
use PSX\Schema\Exception\TraverserException;
use PSX\Schema\Exception\TypeNotFoundException;
use PSX\Schema\Exception\ValidationException;
use PSX\Schema\Type\AnyPropertyType;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\ArrayTypeInterface;
use PSX\Schema\Type\BooleanPropertyType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\GenericPropertyType;
use PSX\Schema\Type\IntegerPropertyType;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\MapPropertyType;
use PSX\Schema\Type\MapTypeInterface;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\ScalarPropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;
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
    private bool $ignoreUnknown;

    public function __construct(bool $assertConstraints = true, bool $ignoreUnknown = true)
    {
        $this->assertConstraints = $assertConstraints;
        $this->ignoreUnknown = $ignoreUnknown;
    }

    /**
     * Traverses through the data and validates it according to the provided
     * schema. Calls also the visitor methods for each type
     *
     * @throws TraverserException
     */
    public function traverse(mixed $data, SchemaInterface $schema, ?VisitorInterface $visitor = null): mixed
    {
        $this->pathStack = [];

        if ($visitor === null) {
            $visitor = new NullVisitor();
        }

        try {
            $type = $schema->getDefinitions()->getType($schema->getRoot() ?? throw new TraverserException('Provided schema has no root configured'));

            return $this->traverseDefinition($data, $type, $schema->getDefinitions(), $visitor, []);
        } catch (TypeNotFoundException|ValidationException $e) {
            throw new TraverserException($e->getMessage(), previous: $e);
        }
    }

    /**
     * @throws ValidationException
     * @throws TypeNotFoundException
     */
    protected function traverseDefinition(mixed $data, DefinitionTypeAbstract $type, DefinitionsInterface $definitions, VisitorInterface $visitor, array $context): mixed
    {
        if ($type instanceof StructDefinitionType) {
            if ($this->assertConstraints) {
                $this->assertObject($data);
            }

            return $this->traverseStruct($data, $type, $definitions, $visitor, $context);
        } elseif ($type instanceof MapDefinitionType) {
            if ($this->assertConstraints) {
                $this->assertObject($data);
            }

            return $this->traverseMap($data, $type, $definitions, $visitor, $context);
        } elseif ($type instanceof ArrayDefinitionType) {
            if ($this->assertConstraints) {
                $this->assertArray($data);
            }

            return $this->traverseArray($data, $type, $definitions, $visitor, $context);
        } else {
            return null;
        }
    }

    /**
     * @throws ValidationException
     * @throws TypeNotFoundException
     */
    protected function traverseStruct(\stdClass $data, StructDefinitionType $type, DefinitionsInterface $definitions, VisitorInterface $visitor, array $context): object
    {
        $result = new \stdClass();
        $properties = [];

        $discriminator = $type->getDiscriminator();
        if (!empty($discriminator)) {
            $discriminatorValue = $data->{$discriminator} ?? null;
            if (empty($discriminatorValue) || !is_string($discriminatorValue)) {
                throw new TraverserException('Configured discriminator property "' . $discriminator . '" is invalid');
            }

            $mapping = $type->getMapping() ?? [];
            $mappingType = array_search($discriminatorValue, $mapping);
            if ($mappingType === false) {
                throw new TraverserException('Provided discriminator type is invalid, possible values are: ' . implode(', ', $mapping));
            }

            return $this->traverseDefinition($data, $definitions->getType($mappingType), $definitions, $visitor, $context);
        }

        $parent = $type->getParent();
        while ($parent instanceof ReferencePropertyType) {
            $parentType = $definitions->getType($parent->getTarget());
            if (!$parentType instanceof StructDefinitionType) {
                break;
            }

            $template = $parent->getTemplate();
            if (!empty($template)) {
                foreach ($template as $templateName => $templateType) {
                    $context[$templateName] = $templateType;
                }
            }

            $properties = array_merge($properties, $parentType->getProperties() ?? []);
            $parent = $parentType->getParent();
        }

        $properties = array_merge($properties, $type->getProperties() ?? []);
        if (!empty($properties)) {
            $data = (array) $data;
            foreach ($properties as $key => $subType) {
                array_push($this->pathStack, $key);

                if (isset($data[$key])) {
                    $result->{$key} = $this->traverseProperty($data[$key], $subType, $definitions, $visitor, $context);
                }

                array_pop($this->pathStack);
            }

            if ($this->ignoreUnknown === false) {
                foreach ($data as $key => $value) {
                    if (!array_key_exists($key, $properties)) {
                        throw new ValidationException($this->getCurrentPath() . ' property "' . $key . '" is unknown', 'properties', $this->pathStack);
                    }
                }
            }
        }

        return $visitor->visitStruct($result, $type, $this->getCurrentPath());
    }

    /**
     * @throws ValidationException
     * @throws TypeNotFoundException
     */
    protected function traverseMap(\stdClass $data, MapTypeInterface $type, DefinitionsInterface $definitions, VisitorInterface $visitor, array $context): object
    {
        $data = (array) $data;
        $result = new \stdClass();

        $schema = $type->getSchema();
        if ($schema instanceof PropertyTypeAbstract) {
            foreach ($data as $key => $value) {
                array_push($this->pathStack, $key);

                $result->{$key} = $this->traverseProperty($data[$key], $schema, $definitions, $visitor, $context);

                array_pop($this->pathStack);
            }
        }

        return $visitor->visitMap($result, $type, $this->getCurrentPath());
    }

    /**
     * @throws ValidationException
     * @throws TypeNotFoundException
     */
    protected function traverseProperty(mixed $data, PropertyTypeAbstract $type, DefinitionsInterface $definitions, VisitorInterface $visitor, array $context)
    {
        if ($type instanceof MapPropertyType) {
            if ($this->assertConstraints) {
                $this->assertObject($data);
            }

            return $data instanceof \stdClass ? $this->traverseMap($data, $type, $definitions, $visitor, $context) : null;
        } elseif ($type instanceof ArrayPropertyType) {
            if ($this->assertConstraints) {
                $this->assertArray($data);
            }

            return is_array($data) ? $this->traverseArray($data, $type, $definitions, $visitor, $context) : null;
        } elseif ($type instanceof StringPropertyType) {
            if ($this->assertConstraints) {
                $this->assertString($data);
                $this->assertScalarConstraints($data, $type);
            }

            return is_string($data) ? $this->traverseString($data, $type, $visitor) : null;
        } elseif ($type instanceof IntegerPropertyType) {
            if ($this->assertConstraints) {
                $this->assertNumber($data, $type);
                $this->assertScalarConstraints($data, $type);
            }

            return is_int($data) ? $visitor->visitInteger($data, $type, $this->getCurrentPath()) : null;
        } elseif ($type instanceof NumberPropertyType) {
            if ($this->assertConstraints) {
                $this->assertNumber($data, $type);
                $this->assertScalarConstraints($data, $type);
            }

            return is_int($data) || is_float($data) ? $visitor->visitNumber($data, $type, $this->getCurrentPath()) : null;
        } elseif ($type instanceof BooleanPropertyType) {
            if ($this->assertConstraints) {
                $this->assertBoolean($data);
            }

            return is_bool($data) ? $visitor->visitBoolean($data, $type, $this->getCurrentPath()) : null;
        } elseif ($type instanceof ReferencePropertyType) {
            $targetType = $definitions->getType($type->getTarget());

            $result = $this->traverseDefinition($data, $targetType, $definitions, $visitor, $context);
        } elseif ($type instanceof GenericPropertyType) {
            if (!isset($context[$type->getName()])) {
                throw new TraverserException('Could not resolve generic type from context');
            }

            $subType = $definitions->getType($context[$type->getName()]);
            $result = $this->traverseDefinition($data, $subType, $definitions, $visitor, $context);
        } elseif ($type instanceof AnyPropertyType) {
            $result = $data;
        } else {
            $result = null;
        }

        return $result;
    }

    /**
     * @throws ValidationException
     * @throws TypeNotFoundException
     */
    protected function traverseArray(array $data, ArrayTypeInterface $type, DefinitionsInterface $definitions, VisitorInterface $visitor, array $context): mixed
    {
        $result = [];

        $schema = $type->getSchema();
        if ($schema instanceof PropertyTypeAbstract) {
            foreach ($data as $index => $value) {
                array_push($this->pathStack, $index);

                $result[] = $this->traverseProperty($value, $schema, $definitions, $visitor, $context);

                array_pop($this->pathStack);
            }
        }

        return $visitor->visitArray($result, $type, $this->getCurrentPath());
    }

    protected function traverseString(string $data, StringPropertyType $type, VisitorInterface $visitor): mixed
    {
        $format = $type->getFormat();
        if ($format === Format::DATE) {
            return $visitor->visitDate($data, $type, $this->getCurrentPath());
        } elseif ($format === Format::DATETIME) {
            return $visitor->visitDateTime($data, $type, $this->getCurrentPath());
        } elseif ($format === Format::TIME) {
            return $visitor->visitTime($data, $type, $this->getCurrentPath());
        } else {
            return $visitor->visitString($data, $type, $this->getCurrentPath());
        }
    }

    /**
     * @throws ValidationException
     */
    protected function assertScalarConstraints($data, ScalarPropertyType $type): void
    {
        if (!is_scalar($data)) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type scalar', 'type', $this->pathStack);
        }

        $format = $type->getFormat();
        if ($format !== null) {
            if ($type instanceof StringPropertyType && is_string($data)) {
                $this->validateFormatString($format, $data);
            }
        }
    }

    /**
     * @throws ValidationException
     */
    protected function assertObject($data): void
    {
        if (!$data instanceof \stdClass) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type object', 'type', $this->pathStack);
        }
    }

    /**
     * @throws ValidationException
     */
    protected function assertArray($data): void
    {
        if (!is_array($data)) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type array', 'type', $this->pathStack);
        }
    }

    /**
     * @throws ValidationException
     */
    protected function assertNumber($data, NumberPropertyType $property): void
    {
        if ($property instanceof IntegerPropertyType) {
            if (!is_int($data)) {
                throw new ValidationException($this->getCurrentPath() . ' must be of type integer', 'type', $this->pathStack);
            }
        } else {
            if (!is_float($data) && !is_int($data)) {
                throw new ValidationException($this->getCurrentPath() . ' must be of type float', 'type', $this->pathStack);
            }
        }
    }

    /**
     * @throws ValidationException
     */
    protected function assertBoolean($data): void
    {
        if (!is_bool($data)) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type boolean', 'type', $this->pathStack);
        }
    }

    /**
     * @throws ValidationException
     */
    protected function assertString($data): void
    {
        if (!is_string($data)) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type string', 'type', $this->pathStack);
        }
    }

    private function getCurrentPath(): string
    {
        return '/' . implode('/', $this->pathStack);
    }

    private function validateFormatString(Format $format, string $data): void
    {
        switch ($format) {
            case Format::DATE:
                if (!preg_match('/^' . LocalDate::getPattern() . '$/', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid full-date format [RFC3339]', 'format', $this->pathStack);
                }
                break;
            case Format::DATETIME:
                if (!preg_match('/^' . LocalDateTime::getPattern() . '$/', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid date-time format [RFC3339]', 'format', $this->pathStack);
                }
                break;
            case Format::TIME:
                if (!preg_match('/^' . LocalTime::getPattern() . '$/', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid full-time format [RFC3339]', 'format', $this->pathStack);
                }
                break;
        }
    }
}
