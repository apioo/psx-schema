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
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeInterface;
use PSX\Schema\TypeUtil;

/**
 * TypeScript
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TypeScript extends CodeGeneratorAbstract
{
    public function getFileName(string $file): string
    {
        return $file . '.ts';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\TypeScript($mapping, $this->normalizer);
    }

    protected function newNormalizer(): NormalizerInterface
    {
        return new Normalizer\TypeScript();
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = 'export interface ' . $name->getClass();

        if (!empty($generics)) {
            $code.= '<' . implode(', ', $generics) . '>';
        }

        if (!empty($extends)) {
            $code.= ' extends ' . $extends;
        }

        $code.= ' {' . "\n";

        $reservedClassNames = ['Array', 'Record'];
        $isReservedClassName = in_array($name->getClass(), $reservedClassNames);

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            // we must use the raw property name since in typescript we dont have a JsonGetter annotation like in Java
            // where we can describe a different JSON key so we must use the original name
            $propertyName = $property->getName()->getRaw();
            if ($this->needsQuoting($propertyName)) {
                $propertyName = '"' . $propertyName . '"';
            }

            $type = $property->getType();
            if ($isReservedClassName) {
                $type = $this->appendGlobalThis($type, $reservedClassNames);
            }

            $code.= $this->indent . $propertyName . ($property->isRequired() ? '' : '?') . ': ' . $type . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapType $origin): string
    {
        return 'export type ' . $name->getClass() . ' = ' . $type . ';' . "\n";
    }

    protected function writeArray(Code\Name $name, string $type, ArrayType $origin): string
    {
        return 'export type ' . $name->getClass() . ' = ' . $type . ';' . "\n";
    }

    protected function writeUnion(Code\Name $name, string $type, UnionType $origin): string
    {
        return 'export type ' . $name->getClass() . ' = ' . $type . ';' . "\n";
    }

    protected function writeIntersection(Code\Name $name, string $type, IntersectionType $origin): string
    {
        return 'export type ' . $name->getClass() . ' = ' . $type . ';' . "\n";
    }

    protected function writeReference(Code\Name $name, string $type, ReferenceType $origin): string
    {
        return 'export type ' . $name->getClass() . ' = ' . $type . ';' . "\n";
    }

    protected function writeHeader(TypeAbstract $origin, Code\Name $className): string
    {
        $code = '';

        $imports = $this->getImports($origin, $className);
        if (!empty($imports)) {
            $code.= "\n";
            $code.= implode("\n", $imports);
            $code.= "\n";
        }

        $code.= "\n";

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= '/**' . "\n";
            $code.= ' * ' . $comment . "\n";
            $code.= ' */' . "\n";
        }

        return $code;
    }

    private function getImports(TypeInterface $origin, Code\Name $className): array
    {
        $refs = [];
        TypeUtil::walk($origin, function(TypeInterface $type) use (&$refs, $className){
            if ($type instanceof ReferenceType) {
                $refs[$type->getRef()] = $type->getRef();
                if ($type->getTemplate()) {
                    foreach ($type->getTemplate() as $ref) {
                        $refs[$ref] = $ref;
                    }
                }
            } elseif ($type instanceof StructType && $type->getExtends()) {
                $refs[$type->getExtends()] = $type->getExtends();
            }
        });

        $imports = [];
        foreach ($refs as $ref) {
            [$ns, $name] = TypeUtil::split($ref);

            $typeName = $this->normalizer->class($name);
            if ($typeName === $className->getClass()) {
                // we dont need to include the same class
                continue;
            }

            if ($ns === DefinitionsInterface::SELF_NAMESPACE) {
                $file = $this->normalizer->import($name);
            } else {
                if (!isset($this->mapping[$ns])) {
                    throw new GeneratorException('Provided namespace "' . $ns . '" is not configured');
                }

                $file = $this->normalizer->import($name, $this->mapping[$ns]);
            }

            $imports[] = 'import {' . $typeName . '} from "./' . $file . '";';
        }

        return $imports;
    }

    private function needsQuoting(string $propertyName): bool
    {
        return !preg_match('/^[a-zA-Z0-9$_]+$/', $propertyName);
    }

    private function appendGlobalThis(string $type, array $reservedNames): string
    {
        foreach ($reservedNames as $reservedName) {
            if (str_starts_with($type, $reservedName)) {
                return 'globalThis.' . $type;
            }
        }

        return $type;
    }
}
