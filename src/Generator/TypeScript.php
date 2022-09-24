<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            // we must use the raw property name since in typescript we dont have a JsonGetter annotation like in Java
            // where we can describe a different JSON key so we must use the original name
            $propertyName = $property->getName()->getRaw();
            if ($this->needsQuoting($propertyName)) {
                $propertyName = '"' . $propertyName . '"';
            }

            $code.= $this->indent . $propertyName . ($property->isRequired() ? '' : '?') . ': ' . $property->getType() . "\n";
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

    protected function writeHeader(TypeAbstract $origin): string
    {
        $code = '';

        $imports = $this->getImports($origin);
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

    private function getImports(TypeInterface $origin): array
    {
        $refs = [];
        TypeUtil::walk($origin, function(TypeInterface $type) use (&$refs){
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
            $imports[] = 'import {' . $this->normalizer->class($name) . '} from "./' . $this->normalizer->file($name) . '";';
        }

        return $imports;
    }

    private function needsQuoting(string $propertyName): bool
    {
        return !preg_match('/^[a-zA-Z0-9$_]+$/', $propertyName);
    }
}
