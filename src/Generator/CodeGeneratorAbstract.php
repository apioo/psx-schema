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

namespace PSX\Schema\Generator;

use PSX\Schema\DefinitionsInterface;
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

/**
 * CodeGeneratorAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
abstract class CodeGeneratorAbstract implements GeneratorInterface, TypeAwareInterface
{
    /**
     * @var TypeGeneratorInterface
     */
    protected $generator;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $indent;

    /**
     * @var DefinitionsInterface
     */
    protected $definitions;

    /**
     * @var Code\Chunks
     */
    private $chunks;

    /**
     * @param string $namespace
     * @param int $indent
     */
    public function __construct(?string $namespace = null, int $indent = 4)
    {
        $this->generator = $this->newTypeGenerator();
        $this->namespace = $namespace;
        $this->indent    = str_repeat(' ', $indent);
    }

    /**
     * @inheritDoc
     */
    public function generate(SchemaInterface $schema)
    {
        $this->chunks      = new Code\Chunks($this->namespace);
        $this->definitions = $schema->getDefinitions();

        $types = $this->definitions->getAllTypes();
        foreach ($types as $name => $type) {
            $this->generateDefinition($name, $type);
        }

        $type = $schema->getType();
        if ($type instanceof TypeInterface) {
            $this->generateRoot($type);
        }

        return $this->chunks;
    }

    /**
     * @inheritDoc
     */
    public function getType(TypeInterface $type): string
    {
        return $this->generator->getType($type);
    }

    /**
     * @inheritDoc
     */
    public function getDocType(TypeInterface $type): string
    {
        return $this->generator->getDocType($type);
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

    private function generateStruct(string $className, StructType $type)
    {
        $extends = $type->getExtends();
        if (!empty($extends)) {
            $parent  = $this->definitions->getType($extends);
            $extends = $this->normalizeClassName($extends);
            if ($parent instanceof StructType) {
                $this->generateStruct($extends, $parent);
            } else {
                throw new \RuntimeException('Extends must be of type struct');
            }
        }

        $className  = $this->normalizeClassName($className);
        $properties = $type->getProperties();
        $generics   = [];
        $required   = $type->getRequired() ?: [];
        $mapping    = $type->getAttribute(TypeAbstract::ATTR_MAPPING) ?: [];

        $props = [];
        foreach ($properties as $name => $property) {
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

            $key = isset($mapping[$name]) ? $mapping[$name] : $name;
            $key = $this->normalizePropertyName($key);

            $props[$key] = new Code\Property(
                $name,
                $this->generator->getType($property),
                $this->generator->getDocType($property),
                in_array($name, $required),
                $property
            );
        }

        $code = $this->writeStruct($className, $props, $extends, $generics, $type);

        if (!empty($code)) {
            $this->chunks->append($className, $code);
        }
    }

    private function generateMap(string $className, MapType $type)
    {
        $code = $this->writeMap($className, $this->generator->getType($type), $type);
        if (!empty($code)) {
            $this->chunks->append($className, $code);
        }
    }

    private function generateArray(string $className, ArrayType $type)
    {
        $code = $this->writeArray($className, $this->generator->getType($type), $type);
        if (!empty($code)) {
            $this->chunks->append($className, $code);
        }
    }

    private function generateUnion(string $className, UnionType $type)
    {
        $code = $this->writeUnion($className, $this->generator->getType($type), $type);
        if (!empty($code)) {
            $this->chunks->append($className, $code);
        }
    }

    private function generateIntersection(string $className, IntersectionType $type)
    {
        $code = $this->writeIntersection($className, $this->generator->getType($type), $type);
        if (!empty($code)) {
            $this->chunks->append($className, $code);
        }
    }

    private function generateReference(string $className, ReferenceType $type)
    {
        $code = $this->writeReference($className, $this->generator->getType($type), $type);
        if (!empty($code)) {
            $this->chunks->append($className, $code);
        }
    }

    private function supportsWrite(string $name, TypeInterface $type)
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

    /**
     * @param string $name
     * @return string
     */
    protected function normalizePropertyName(string $name)
    {
        $name = str_replace(['-', '_'], ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);

        return preg_replace('/[^A-Za-z0-9]/', '', lcfirst($name));
    }

    /**
     * @param string $name
     * @return string
     */
    protected function normalizeClassName(string $name)
    {
        $name = str_replace(['-', '_'], ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);

        return preg_replace('/[^A-Za-z0-9]/', '', ucfirst($name));
    }

    /**
     * @return \PSX\Schema\Generator\Type\GeneratorInterface
     */
    abstract protected function newTypeGenerator(): TypeGeneratorInterface;

    /**
     * @param string $name
     * @param array $properties
     * @param string|null $extends
     * @param array|null $generics
     * @return string
     */
    abstract protected function writeStruct(string $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string;

    protected function writeMap(string $name, string $type, MapType $origin): string
    {
        return '';
    }

    protected function writeArray(string $name, string $type, ArrayType $origin): string
    {
        return '';
    }

    protected function writeUnion(string $name, string $type, UnionType $origin): string
    {
        return '';
    }

    protected function writeIntersection(string $name, string $type, IntersectionType $origin): string
    {
        return '';
    }

    protected function writeReference(string $name, string $type, ReferenceType $origin): string
    {
        return '';
    }
}
