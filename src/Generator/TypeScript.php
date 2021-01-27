<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * @link    http://phpsx.org
 */
class TypeScript extends CodeGeneratorAbstract
{
    /**
     * @inheritDoc
     */
    public function getFileName(string $file): string
    {
        return $file . '.ts';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\TypeScript($mapping);
    }

    protected function writeStruct(string $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = $this->writeHeader($origin);
        $code.= 'export interface ' . $name;

        if (!empty($generics)) {
            $code.= '<' . implode(', ', $generics) . '>';
        }

        if (!empty($extends)) {
            $code.= ' extends ' . $extends;
        }

        $code.= ' {' . "\n";

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . $name . ($property->isRequired() ? '' : '?') . ': ' . $property->getType() . "\n";
        }

        $code.= '}' . "\n";
        $code.= $this->writerFooter();

        return $code;
    }

    protected function writeMap(string $name, string $type, MapType $origin): string
    {
        $code = $this->writeHeader($origin);
        $code.= 'export type ' . $name . ' = ' . $type . ';' . "\n";
        $code.= $this->writerFooter();

        return $code;
    }

    protected function writeArray(string $name, string $type, ArrayType $origin): string
    {
        $code = $this->writeHeader($origin);
        $code.= 'export type ' . $name . ' = ' . $type . ';' . "\n";
        $code.= $this->writerFooter();

        return $code;
    }

    protected function writeUnion(string $name, string $type, UnionType $origin): string
    {
        $code = $this->writeHeader($origin);
        $code.= 'export type ' . $name . ' = ' . $type . ';' . "\n";
        $code.= $this->writerFooter();

        return $code;
    }

    protected function writeIntersection(string $name, string $type, IntersectionType $origin): string
    {
        $code = $this->writeHeader($origin);
        $code.= 'export type ' . $name . ' = ' . $type . ';' . "\n";
        $code.= $this->writerFooter();

        return $code;
    }

    protected function writeReference(string $name, string $type, ReferenceType $origin): string
    {
        $code = $this->writeHeader($origin);
        $code.= 'export type ' . $name . ' = ' . $type . ';' . "\n";
        $code.= $this->writerFooter();

        return $code;
    }

    protected function normalizeName(string $name)
    {
        if (strpos($name, '-') !== false) {
            $name = '"' . $name . '"';
        }

        return $name;
    }

    private function writeHeader(TypeAbstract $origin): string
    {
        $code = '';

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= '/**' . "\n";
            $code.= ' * ' . $comment . "\n";
            $code.= ' */' . "\n";
        }

        $imports = $this->writeImports($origin);
        if (!empty($imports)) {
            $code.= "\n";
            $code.= $imports;
            $code.= "\n";
        }

        $code.= "\n";

        return $code;
    }

    private function writerFooter(): string
    {
        $code = '';
        $code.= "\n";

        return $code;
    }

    private function writeImports(TypeInterface $type): string
    {
        $imports = [];
        $refs = [];

        TypeUtil::walk($type, function(TypeInterface $type) use (&$refs){
            if ($type instanceof ReferenceType) {
                $refs[$type->getRef()] = $type->getRef();
                if ($type->getTemplate()) {
                    foreach ($type->getTemplate() as $type => $ref) {
                        $refs[$ref] = $ref;
                    }
                }
            } elseif ($type instanceof StructType && $type->getExtends()) {
                $refs[$type->getExtends()] = $type->getExtends();
            }
        });

        foreach ($refs as $ref) {
            [$ns, $name] = TypeUtil::split($ref);
            $imports[] = 'import {' . $name . '} from "./' . $name . '";';
        }

        return implode("\n", $imports);
    }
}
