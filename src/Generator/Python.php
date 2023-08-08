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

use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\AnyType;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeInterface;
use PSX\Schema\TypeUtil;

/**
 * Python
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Python extends CodeGeneratorAbstract
{
    public function getFileName(string $file): string
    {
        return $file . '.py';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Python($mapping, $this->normalizer);
    }

    protected function newNormalizer(): NormalizerInterface
    {
        return new Normalizer\Python();
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = '@dataclass_json' . "\n";
        $code.= '@dataclass' . "\n";
        $code.= 'class ' . $name->getClass();

        if (!empty($extends)) {
            $code.= '(' . $extends . ')';
        }

        $code.= ':' . "\n";

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . $property->getName()->getProperty() . ': ' . $property->getType() . "\n";
        }

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $code = '@dataclass_json' . "\n";
        $code.= '@dataclass' . "\n";
        $code.= 'class ' . $name->getClass() . '(Dict[str, ' . $subType . ']):' . "\n";
        $code.= '    pass' . "\n";

        return $code;
    }

    protected function writeReference(Code\Name $name, string $type, ReferenceType $origin): string
    {
        $code = '@dataclass_json' . "\n";
        $code.= '@dataclass' . "\n";
        $code.= 'class ' . $name->getClass() . '(' . $type . '):' . "\n";
        $code.= '    pass' . "\n";

        return $code;
    }

    protected function writeHeader(TypeAbstract $origin): string
    {
        $code = '';

        if (!empty($this->namespace)) {
            // TODO can we namespace?
        }

        $imports = $this->getImports($origin);
        if (!empty($imports)) {
            $code.= "\n";
            $code.= implode("\n", $imports);
            $code.= "\n";
        }

        $code.= "\n";

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= '# ' . $comment . "\n";
        }

        return $code;
    }

    private function getImports(TypeAbstract $origin): array
    {
        $imports = [];
        $imports[] = 'from dataclasses import dataclass';
        $imports[] = 'from dataclasses_json import dataclass_json';

        if (TypeUtil::contains($origin, AnyType::class)) {
            $imports[] = 'from typing import Any';
        }

        if (TypeUtil::contains($origin, ArrayType::class)) {
            $imports[] = 'from typing import List';
        }

        if (TypeUtil::contains($origin, MapType::class)) {
            $imports[] = 'from typing import Dict';
        }

        if (TypeUtil::contains($origin, UnionType::class)) {
            $imports[] = 'from typing import Union';
        }

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

        foreach ($refs as $ref) {
            [$ns, $name] = TypeUtil::split($ref);
            $imports[] = 'from ' . $this->normalizer->file($name) . ' import ' . $this->normalizer->class($name);
        }

        return $imports;
    }
}
