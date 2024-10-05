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
use PSX\Schema\Generator\Normalizer\DefaultNormalizer;
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface as TypeGeneratorInterface;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\CollectionPropertyType;
use PSX\Schema\Type\DefinitionTypeAbstract;
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

    private function generateStruct(string $className, StructDefinitionType $type): void
    {
        $properties = [];

        $extends = $type->getParent();
        if (!empty($extends)) {
            if ($this->supportsExtends()) {
                [$ns, $name] = TypeUtil::split($extends);
                if ($ns === DefinitionsInterface::SELF_NAMESPACE) {
                    $parent  = $this->definitions->getType($name);
                    $extends = $this->normalizer->class($extends);
                    if ($parent instanceof StructDefinitionType) {
                        $this->generateStruct($extends, $parent);
                    } else {
                        throw new GeneratorException('Extends must be of type struct');
                    }
                } else {
                    // in case we have an extern namespace we dont need to generate the type
                    $extends = $this->generator->getType((new ReferencePropertyType())->setTarget($extends));
                }
            } else {
                do {
                    $parent = $this->definitions->getType($extends);
                    if (!$parent instanceof StructDefinitionType) {
                        throw new GeneratorException('Extends must be of type struct');
                    }

                    $properties = array_merge($properties, $parent->getProperties());
                } while($extends = $parent->getParent());
            }
        }

        $className = new Code\Name($className, $className, $this->normalizer);
        $properties = array_merge($properties, $type->getProperties() ?? []);
        $generics = [];
        $mapping = $type->getAttribute(DefinitionTypeAbstract::ATTR_MAPPING) ?: [];

        $props = [];
        foreach ($properties as $raw => $property) {
            $mapped = $mapping[$raw] ?? $raw;
            $name = new Code\Name($raw, $mapped, $this->normalizer);

            $generic = $this->getGeneric($property);
            if ($generic instanceof GenericPropertyType) {
                $generics[] = $generic->getName();
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

        $code = $this->writeStruct($className, $props, $extends, $generics, $type);

        if (!empty($code)) {
            $this->chunks->append($className->getFile(), $this->wrap($code, $type, $className));
        }
    }

    private function generateMap(string $className, MapDefinitionType $type): void
    {
        $className = new Code\Name($className, $className, $this->normalizer);

        $code = $this->writeMap($className, $this->generator->getType($type->getSchema()), $type);
        if (!empty($code)) {
            $this->chunks->append($className->getFile(), $this->wrap($code, $type, $className));
        }
    }

    private function generateArray(string $className, ArrayDefinitionType $type): void
    {
        $className = new Code\Name($className, $className, $this->normalizer);

        $code = $this->writeArray($className, $this->generator->getType($type->getSchema()), $type);
        if (!empty($code)) {
            $this->chunks->append($className->getFile(), $this->wrap($code, $type, $className));
        }
    }

    private function getGeneric(PropertyTypeAbstract $type): ?GenericPropertyType
    {
        $schema = $type;
        if ($type instanceof CollectionPropertyType) {
            $schema = $type->getSchema();
        }

        return $schema instanceof GenericPropertyType ? $schema : null;
    }

    private function wrap(string $code, DefinitionTypeAbstract $type, Code\Name $className): string
    {
        return implode("\n", array_filter(array_map('trim', [
            $this->writeHeader($type, $className),
            $code,
            $this->writeFooter($type, $className)
        ]))) . "\n";
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

    abstract protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructDefinitionType $origin): string;

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
