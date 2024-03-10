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

namespace PSX\Schema\Generator;

use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Exception\GeneratorException;
use PSX\Schema\Generator\Normalizer\DefaultNormalizer;
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface as TypeGeneratorInterface;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\GenericType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeInterface;
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

    public function generate(SchemaInterface $schema)
    {
        $this->chunks      = new Code\Chunks($this->namespace);
        $this->definitions = $schema->getDefinitions();

        $types = $this->definitions->getTypes(DefinitionsInterface::SELF_NAMESPACE);
        foreach ($types as $name => $type) {
            $this->generateDefinition($name, $type);
        }

        $this->generateRoot($schema->getType());

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

    private function generateRoot(TypeInterface $type)
    {
        if ($type instanceof StructType) {
            // for the root schema we need to use the title as class name
            $this->generateStruct($type->getTitle() ?: 'RootSchema', $type);
        }
    }

    private function generateDefinition(string $name, TypeInterface $type)
    {
        if ($type instanceof StructType) {
            $this->generateStruct($name, $type);
        } elseif ($type instanceof MapType) {
            $this->generateMap($name, $type);
        } elseif ($type instanceof ArrayType) {
            $this->generateArray($name, $type);
        } elseif ($type instanceof UnionType) {
            $this->generateUnion($name, $type);
        } elseif ($type instanceof IntersectionType) {
            $this->generateIntersection($name, $type);
        } elseif ($type instanceof ReferenceType) {
            $this->generateReference($name, $type);
        }
    }

    private function generateStruct(string $className, StructType $type): void
    {
        $properties = [];

        $extends = $type->getExtends();
        if (!empty($extends)) {
            if ($this->supportsExtends()) {
                [$ns, $name] = TypeUtil::split($extends);
                if ($ns === DefinitionsInterface::SELF_NAMESPACE) {
                    $parent  = $this->definitions->getType($name);
                    $extends = $this->normalizer->class($extends);
                    if ($parent instanceof StructType) {
                        $this->generateStruct($extends, $parent);
                    } else {
                        throw new GeneratorException('Extends must be of type struct');
                    }
                } else {
                    // in case we have an extern namespace we dont need to generate the type
                    $extends = $this->generator->getType((new ReferenceType())->setRef($extends));
                }
            } else {
                do {
                    $parent = $this->definitions->getType($extends);
                    if (!$parent instanceof StructType) {
                        throw new GeneratorException('Extends must be of type struct');
                    }
                    $properties = array_merge($properties, $parent->getProperties());
                } while($extends = $parent->getExtends());
            }
        }

        $className  = new Code\Name($className, $className, $this->normalizer);
        $properties = array_merge($properties, $type->getProperties() ?? []);
        $generics   = [];
        $required   = $type->getRequired() ?: [];
        $mapping    = $type->getAttribute(TypeAbstract::ATTR_MAPPING) ?: [];

        $props = [];
        foreach ($properties as $raw => $property) {
            $mapped = $mapping[$raw] ?? $raw;
            $name = new Code\Name($raw, $mapped, $this->normalizer);

            /** @var TypeInterface $property */
            if ($property instanceof ReferenceType) {
                $resolved = $this->definitions->getType($property->getRef());
                if (!$this->supportsWrite($name, $resolved)) {
                    // in case the generator produces output for this type we
                    // can also reference the type otherwise we need to define
                    // the type inline
                    $property = $resolved;
                }
            }

            $generic = $this->getGeneric($property);
            if ($generic instanceof GenericType) {
                $generics[] = $generic->getGeneric();
            }

            $props[] = new Code\Property(
                $name,
                $this->generator->getType($property),
                $this->generator->getDocType($property),
                in_array($name->getRaw(), $required),
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

    private function generateMap(string $className, MapType $type): void
    {
        $className = new Code\Name($className, $className, $this->normalizer);

        $code = $this->writeMap($className, $this->generator->getType($type), $type);
        if (!empty($code)) {
            $this->chunks->append($className->getFile(), $this->wrap($code, $type, $className));
        }
    }

    private function generateArray(string $className, ArrayType $type): void
    {
        $className = new Code\Name($className, $className, $this->normalizer);

        $code = $this->writeArray($className, $this->generator->getType($type), $type);
        if (!empty($code)) {
            $this->chunks->append($className->getFile(), $this->wrap($code, $type, $className));
        }
    }

    private function generateUnion(string $className, UnionType $type): void
    {
        $className = new Code\Name($className, $className, $this->normalizer);

        $code = $this->writeUnion($className, $this->generator->getType($type), $type);
        if (!empty($code)) {
            $this->chunks->append($className->getFile(), $this->wrap($code, $type, $className));
        }
    }

    private function generateIntersection(string $className, IntersectionType $type): void
    {
        $className = new Code\Name($className, $className, $this->normalizer);

        $code = $this->writeIntersection($className, $this->generator->getType($type), $type);
        if (!empty($code)) {
            $this->chunks->append($className->getFile(), $this->wrap($code, $type, $className));
        }
    }

    private function generateReference(string $className, ReferenceType $type): void
    {
        $className = new Code\Name($className, $className, $this->normalizer);

        $code = $this->writeReference($className, $this->generator->getType($type), $type);
        if (!empty($code)) {
            $this->chunks->append($className->getFile(), $this->wrap($code, $type, $className));
        }
    }

    private function supportsWrite(Code\Name $name, TypeInterface $type): bool
    {
        if ($type instanceof StructType) {
            return true;
        } elseif ($type instanceof MapType) {
            return !!$this->writeMap($name, $this->generator->getType($type), $type);
        } elseif ($type instanceof ArrayType) {
            return !!$this->writeArray($name, $this->generator->getType($type), $type);
        } elseif ($type instanceof UnionType) {
            return !!$this->writeUnion($name, $this->generator->getType($type), $type);
        } elseif ($type instanceof IntersectionType) {
            return !!$this->writeIntersection($name, $this->generator->getType($type), $type);
        } elseif ($type instanceof ReferenceType) {
            return !!$this->writeReference($name, $this->generator->getType($type), $type);
        }

        return false;
    }

    private function getGeneric(TypeInterface $type): ?GenericType
    {
        $item = $type;
        if ($type instanceof MapType) {
            $item = $type->getAdditionalProperties();
        } elseif ($type instanceof ArrayType) {
            $item = $type->getItems();
        }

        if ($item instanceof GenericType) {
            return $item;
        } else {
            return null;
        }
    }

    private function wrap(string $code, TypeAbstract $type, Code\Name $className): string
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

    abstract protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string;

    protected function writeMap(Code\Name $name, string $type, MapType $origin): string
    {
        return '';
    }

    protected function writeArray(Code\Name $name, string $type, ArrayType $origin): string
    {
        return '';
    }

    protected function writeUnion(Code\Name $name, string $type, UnionType $origin): string
    {
        return '';
    }

    protected function writeIntersection(Code\Name $name, string $type, IntersectionType $origin): string
    {
        return '';
    }

    protected function writeReference(Code\Name $name, string $type, ReferenceType $origin): string
    {
        return '';
    }

    protected function writeHeader(TypeAbstract $origin, Code\Name $className): string
    {
        return '';
    }

    protected function writeFooter(TypeAbstract $origin, Code\Name $className): string
    {
        return '';
    }

    protected function getIndent(): int
    {
        return 4;
    }
}
