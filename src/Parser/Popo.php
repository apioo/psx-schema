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

namespace PSX\Schema\Parser;

use PSX\Schema\Attribute;
use PSX\Schema\Definitions;
use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\Exception\TypeNotFoundException;
use PSX\Schema\Format;
use PSX\Schema\Parser\Context\NamespaceContext;
use PSX\Schema\Parser\Popo\ReflectionReader;
use PSX\Schema\Parser\Popo\TypeNameBuilder;
use PSX\Schema\ParserInterface;
use PSX\Schema\Schema;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\CollectionPropertyType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\Factory\PropertyTypeFactory;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\ScalarPropertyType;
use PSX\Schema\Type\StructDefinitionType;
use ReflectionClass;

/**
 * Tries to import the data into a plain old php object
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Popo implements ParserInterface
{
    private ReflectionReader $reader;
    private TypeNameBuilder $typeNameBuilder;

    public function __construct()
    {
        $this->reader = new ReflectionReader();
        $this->typeNameBuilder = new TypeNameBuilder();
    }

    /**
     * @inheritDoc
     */
    public function parse(string $schema, ?ContextInterface $context = null): SchemaInterface
    {
        $className = str_replace('.', '\\', $schema);
        $definitions = new Definitions();

        try {
            $this->parseClass($className, $definitions, $context, $typeName);
        } catch (\ReflectionException|TypeNotFoundException $e) {
            throw new ParserException('Could not parse class: ' . $className, previous: $e);
        }

        return new Schema($definitions, $typeName);
    }

    /**
     * @throws \ReflectionException
     * @throws TypeNotFoundException
     */
    private function parseClass(string $className, DefinitionsInterface $definitions, ?ContextInterface $context = null, ?string &$typeName = null): DefinitionTypeAbstract
    {
        $class = new ReflectionClass($className);

        $typeName = $this->getTypeName($class, $context);
        if ($definitions->hasType($typeName)) {
            return $definitions->getType($typeName);
        }

        $type = $this->reader->buildDefinition($class);

        $annotations = [];
        foreach ($class->getAttributes() as $attribute) {
            $annotations[] = $attribute->newInstance();
        }

        $definitions->addType($typeName, $type);

        $this->parseDefinitionAnnotations($annotations, $type);

        if ($type instanceof StructDefinitionType) {
            $parentClass = $class->getParentClass();
            if ($parentClass instanceof \ReflectionClass) {
                $this->parseClass($parentClass->getName(), $definitions, $context, $parentName);
            }

            $this->parseStructAnnotations($annotations, $type);

            $parent = $type->getParent();
            if ($parent instanceof ReferencePropertyType) {
                $this->parseClass($parent->getTarget(), $definitions, $context, $parentTypeName);
                $parent->setTarget($parentTypeName);

                $template = $parent->getTemplate();
                if (!empty($template)) {
                    $result = [];
                    foreach ($template as $key => $className) {
                        $this->parseClass($className, $definitions, $context, $templateTypeName);
                        $result[$key] = $templateTypeName;
                    }

                    $parent->setTemplate($result);
                }
            }

            $mapping = $type->getMapping();
            if (!empty($mapping)) {
                $result = [];
                foreach ($mapping as $className => $typeValue) {
                    $this->parseClass($className, $definitions, $context, $mappingTypeName);
                    $result[$mappingTypeName] = $typeValue;
                }

                $type->setMapping($result);
            }

            $this->parseProperties($class, $type, $definitions, $context);
        } elseif ($type instanceof MapDefinitionType || $type instanceof ArrayDefinitionType) {
            $schema = $type->getSchema();
            if ($schema instanceof ReferencePropertyType) {
                $this->parseClass($schema->getTarget(), $definitions, $context, $schemaTypeName);
                $schema->setTarget($schemaTypeName);
            }
        } else {
            throw new ParserException('Could not determine class type');
        }

        $type->setAttribute(DefinitionTypeAbstract::ATTR_CLASS, $class->getName());

        return $type;
    }

    /**
     * @throws \ReflectionException
     * @throws TypeNotFoundException
     */
    private function parseProperties(ReflectionClass $class, StructDefinitionType $property, DefinitionsInterface $definitions, ?ContextInterface $context): void
    {
        $properties = $this->reader->getProperties($class);
        $mapping = [];

        foreach ($properties as $key => $reflection) {
            if ($reflection->getDeclaringClass()->getName() !== $class->getName()) {
                // skip properties from inherited classes
                continue;
            }

            if ($key != $reflection->getName()) {
                $mapping[$key] = $reflection->getName();
            }

            $type = $this->parseProperty($reflection);
            if ($type instanceof PropertyTypeAbstract) {
                $property->addProperty($key, $this->transform($type, $definitions, $context));
            }
        }

        if (!empty($mapping)) {
            $property->setAttribute(DefinitionTypeAbstract::ATTR_MAPPING, $mapping);
        }
    }

    private function parseProperty(\ReflectionProperty $reflection): ?PropertyTypeAbstract
    {
        $type = $this->reader->buildProperty($reflection);

        $annotations = [];
        foreach ($reflection->getAttributes() as $attribute) {
            $annotations[] = $attribute->newInstance();
        }

        if ($type instanceof PropertyTypeAbstract) {
            $this->parsePropertyAnnotations($annotations, $type);
        }

        if ($type instanceof ScalarPropertyType) {
            $this->parseScalarAnnotations($annotations, $type);
        }

        return $type;
    }

    private function parseDefinitionAnnotations(array $annotations, DefinitionTypeAbstract $type): void
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Attribute\Description) {
                $type->setDescription($annotation->description);
            } elseif ($annotation instanceof Attribute\Deprecated) {
                $type->setDeprecated($annotation->deprecated);
            }
        }
    }

    private function parseStructAnnotations(array $annotations, StructDefinitionType $type): void
    {
        $mapping = [];
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Attribute\Discriminator) {
                $type->setDiscriminator($annotation->property);
            } elseif ($annotation instanceof Attribute\DerivedType) {
                $mapping[$annotation->class] = $annotation->type;
            }
        }

        $type->setMapping($mapping);
    }

    private function parsePropertyAnnotations(array $annotations, PropertyTypeAbstract $type): void
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Attribute\Description) {
                $type->setDescription($annotation->description);
            } elseif ($annotation instanceof Attribute\Deprecated) {
                $type->setDeprecated($annotation->deprecated);
            } elseif ($annotation instanceof Attribute\Nullable) {
                $type->setNullable($annotation->nullable);
            }
        }
    }

    private function parseScalarAnnotations(array $annotations, ScalarPropertyType $type): void
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Attribute\Format) {
                $format = Format::tryFrom($annotation->format);
                if ($format !== null) {
                    $type->setFormat($format);
                }
            }
        }
    }

    /**
     * @throws \ReflectionException
     * @throws TypeNotFoundException
     */
    private function transform(PropertyTypeAbstract $type, DefinitionsInterface $definitions, ?ContextInterface $context): PropertyTypeAbstract
    {
        if ($type instanceof ReferencePropertyType) {
            $this->parseClass($type->getTarget(), $definitions, $context, $typeName);

            return PropertyTypeFactory::getReference($typeName);
        } elseif ($type instanceof CollectionPropertyType) {
            $type->setSchema($this->transform($type->getSchema(), $definitions, $context));
        }

        return $type;
    }

    private function getTypeName(ReflectionClass $reflection, ?ContextInterface $context): string
    {
        $level = 1;
        if ($context instanceof NamespaceContext) {
            $level = $context->getLevel();
        }

        return $this->typeNameBuilder->build($reflection, $level);
    }
}
