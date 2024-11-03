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

namespace PSX\Schema\Generator;

use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Exception\GeneratorException;
use PSX\Schema\Exception\TypeNotFoundException;
use PSX\Schema\Generator\Normalizer\DefaultNormalizer;
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface as TypeGeneratorInterface;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\CollectionPropertyType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\Factory\PropertyTypeFactory;
use PSX\Schema\Type\GenericPropertyType;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\TypeUtil;

/**
 * CodeGeneratorAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class CodeGeneratorAbstract implements GeneratorInterface, TypeAwareInterface, FileAwareInterface, NormalizerAwareInterface
{
    protected TypeGeneratorInterface $generator;
    protected NormalizerInterface $normalizer;
    protected ?string $namespace;
    protected string $indent;
    protected array $mapping;
    protected DefinitionsInterface $definitions;
    private Code\Chunks $chunks;

    public function __construct(?Config $config = null)
    {
        $mapping = (array) $config?->get(Config::MAPPING);

        $this->normalizer = $this->newNormalizer();
        $this->generator  = $this->newTypeGenerator($mapping);
        $this->namespace  = $config?->get(Config::NAMESPACE);
        $this->mapping    = $mapping;
        $this->indent     = str_repeat(' ', $this->getIndent());
    }

    public function generate(SchemaInterface $schema): Code\Chunks|string
    {
        $this->chunks = new Code\Chunks($this->namespace);
        $this->definitions = $schema->getDefinitions();

        $types = $this->definitions->getTypes(DefinitionsInterface::SELF_NAMESPACE);
        foreach ($types as $name => $type) {
            $this->generateDefinition($name, $type);
        }

        return $this->chunks;
    }

    public function getTypeGenerator(): Type\GeneratorInterface
    {
        return $this->generator;
    }

    public function getFileContent(string $code): string
    {
        return $code;
    }

    public function getNormalizer(): NormalizerInterface
    {
        return $this->normalizer;
    }

    /**
     * @throws TypeNotFoundException
     * @throws GeneratorException
     */
    private function generateDefinition(string $name, DefinitionTypeAbstract $type): void
    {
        if ($type instanceof StructDefinitionType) {
            $this->generateStruct($name, $type);
        } elseif ($type instanceof MapDefinitionType) {
            $this->generateMap($name, $type);
        } elseif ($type instanceof ArrayDefinitionType) {
            $this->generateArray($name, $type);
        }
    }

    /**
     * @throws TypeNotFoundException
     * @throws GeneratorException
     */
    private function generateStruct(string $className, StructDefinitionType $type): void
    {
        $properties = [];

        $parent = null;
        $templates = null;
        $parentType = $type->getParent();
        if ($parentType instanceof ReferencePropertyType) {
            $parent = $this->getParent($parentType, $properties);
            $templates = $parentType->getTemplate();
        }

        $className = new Code\Name($className, $className, $this->normalizer);
        $properties = array_merge($properties, $type->getProperties() ?? []);
        $generics = [];
        $mapping = $type->getAttribute(DefinitionTypeAbstract::ATTR_MAPPING) ?: [];

        $props = [];
        foreach ($properties as $raw => $property) {
            $mapped = $mapping[$raw] ?? $raw;
            $name = new Code\Name($raw, $mapped, $this->normalizer);

            if ($this->supportsExtends() || empty($templates)) {
                $generic = $this->getGeneric($property);
                if ($generic instanceof GenericPropertyType) {
                    $generics[] = $generic->getName();
                }
            } else {
                $property = $this->replaceGeneric($property, $templates);
            }

            // in case the generator does not support custom map or array implementations we transform them to properties
            if ($property instanceof ReferencePropertyType) {
                $targetType = $this->definitions->getType($property->getTarget());
                if ($targetType instanceof MapDefinitionType && !$this->supportsMap($name, $targetType)) {
                    $property = PropertyTypeFactory::getMap($targetType->getSchema());
                } elseif ($targetType instanceof ArrayDefinitionType && !$this->supportsArray($name, $targetType)) {
                    $property = PropertyTypeFactory::getArray($targetType->getSchema());
                }
            }

            $props[] = new Code\Property(
                $name,
                $this->generator->getType($property),
                $this->generator->getDocType($property),
                $property
            );
        }

        if (!$this->supportsExtends()) {
            $type->setProperties($properties);
        }

        $code = $this->writeStruct($className, $props, $parent, $generics, $templates, $type);

        if (!empty($code)) {
            $this->chunks->append($className->getFile(), $this->wrap($code, $type, $className));
        }
    }

    private function generateMap(string $className, MapDefinitionType $type): void
    {
        $className = new Code\Name($className, $className, $this->normalizer);

        $code = $this->writeMap($className, $this->generator->getType($type->getSchema() ?? PropertyTypeFactory::getAny()), $type);
        if (!empty($code)) {
            $this->chunks->append($className->getFile(), $this->wrap($code, $type, $className));
        }
    }

    private function generateArray(string $className, ArrayDefinitionType $type): void
    {
        $className = new Code\Name($className, $className, $this->normalizer);

        $code = $this->writeArray($className, $this->generator->getType($type->getSchema() ?? PropertyTypeFactory::getAny()), $type);
        if (!empty($code)) {
            $this->chunks->append($className->getFile(), $this->wrap($code, $type, $className));
        }
    }

    /**
     * @throws TypeNotFoundException
     * @throws GeneratorException
     */
    private function getParent(ReferencePropertyType $parent, array &$properties): ?string
    {
        if ($this->supportsExtends()) {
            [$ns, $name] = TypeUtil::split($parent->getTarget());
            if ($ns === DefinitionsInterface::SELF_NAMESPACE) {
                $parentType = $this->definitions->getType($parent->getTarget());
                if ($parentType instanceof StructDefinitionType) {
                    $this->generateStruct($parent->getTarget(), $parentType);
                }
            }

            return $this->generator->getType($parent);
        } else {
            do {
                $parentType = $this->definitions->getType($parent->getTarget());
                if (!$parentType instanceof StructDefinitionType) {
                    throw new GeneratorException('Parent must be of type struct');
                }

                $properties = array_merge($properties, $parentType->getProperties());
            } while($parent = $parentType->getParent());
        }

        return null;
    }

    private function getGeneric(PropertyTypeAbstract $type): ?GenericPropertyType
    {
        $schema = $type;
        if ($type instanceof CollectionPropertyType) {
            $schema = $type->getSchema();
        }

        return $schema instanceof GenericPropertyType ? $schema : null;
    }

    /**
     * @throws GeneratorException
     */
    private function replaceGeneric(PropertyTypeAbstract $type, array $templates): ?PropertyTypeAbstract
    {
        if ($type instanceof GenericPropertyType) {
            return PropertyTypeFactory::getReference($templates[$type->getName()] ?? throw new GeneratorException('Configured generic "' . $type->getName() . '" not found'));
        } elseif ($type instanceof CollectionPropertyType) {
            $schema = $type->getSchema();
            if ($schema instanceof GenericPropertyType) {
                $newType = clone $type;
                $newType->setSchema(PropertyTypeFactory::getReference($templates[$schema->getName()] ?? throw new GeneratorException('Configured generic "' . $schema->getName() . '" not found')));
                return $newType;
            }
        }

        return $type;
    }

    private function wrap(string $code, DefinitionTypeAbstract $type, Code\Name $className): string
    {
        return implode("\n", array_filter([
            $this->writeHeader($type, $className),
            $code,
            $this->writeFooter($type, $className)
        ])) . "\n";
    }

    abstract protected function newTypeGenerator(array $mapping): TypeGeneratorInterface;

    protected function newNormalizer(): NormalizerInterface
    {
        return new DefaultNormalizer();
    }

    /**
     * Some programming languages might not be able to create classes which extend other classes, in this case you
     * could deactivate the extends feature through this method, then the "writeStruct" method receives all properties
     * merged from all parents
     */
    protected function supportsExtends(): bool
    {
        return true;
    }

    private function supportsMap(Code\Name $name, MapDefinitionType $type): bool
    {
        $schema = $type->getSchema();
        if (!$schema instanceof PropertyTypeAbstract) {
            return false;
        }

        return !!$this->writeMap($name, $this->generator->getType($schema), $type);
    }

    private function supportsArray(Code\Name $name, ArrayDefinitionType $type): bool
    {
        $schema = $type->getSchema();
        if (!$schema instanceof PropertyTypeAbstract) {
            return false;
        }

        return !!$this->writeArray($name, $this->generator->getType($schema), $type);
    }

    abstract protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, ?array $templates, StructDefinitionType $origin): string;

    protected function writeMap(Code\Name $name, string $type, MapDefinitionType $origin): string
    {
        return '';
    }

    protected function writeArray(Code\Name $name, string $type, ArrayDefinitionType $origin): string
    {
        return '';
    }

    protected function writeHeader(DefinitionTypeAbstract $origin, Code\Name $className): string
    {
        return '';
    }

    protected function writeFooter(DefinitionTypeAbstract $origin, Code\Name $className): string
    {
        return '';
    }

    protected function getIndent(): int
    {
        return 4;
    }
}
