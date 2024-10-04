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

use PSX\Schema\Format;
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\Type\PropertyTypeAbstract;
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

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructDefinitionType $origin): string
    {
        $code = '';
        if (!empty($generics)) {
            foreach ($generics as $type) {
                $code.= $type . ' = TypeVar("' . $type . '")' . "\n";
            }
        }

        $code.= 'class ' . $name->getClass();

        $parts = [];
        if (!empty($extends)) {
            $parts[] = $extends;
        } else {
            $parts[] = 'BaseModel';
        }

        if (!empty($generics)) {
            foreach ($generics as $type) {
                $parts[] = 'Generic[' . $type . ']';
            }
        }

        $code.= '(' . implode(', ', $parts) . '):' . "\n";

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . $property->getName()->getProperty() . ': Optional[' . $property->getType() . '] = Field(default=None, alias="' . $property->getName()->getRaw() . '")' . "\n";
        }

        $code.= '    pass' . "\n";
        $code.= "\n";
        $code.= "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapDefinitionType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $code = 'class ' . $name->getClass() . '(Dict[str, ' . $subType . ']):' . "\n";
        $code.= '    @classmethod' . "\n";
        $code.= '    def __get_pydantic_core_schema__(cls, source_type: Any, handler: GetCoreSchemaHandler) -> CoreSchema:' . "\n";
        $code.= '        return core_schema.dict_schema(handler.generate_schema(str), handler.generate_schema(' . $subType . '))' . "\n";
        $code.= "\n";
        $code.= "\n";

        return $code;
    }

    protected function writeReference(Code\Name $name, string $type, ReferencePropertyType $origin): string
    {
        $code = 'class ' . $name->getClass() . '(' . $type . '):' . "\n";
        $code.= '    pass' . "\n";
        $code.= "\n";
        $code.= "\n";

        return $code;
    }

    protected function writeHeader(PropertyTypeAbstract $origin, Code\Name $className): string
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
        $code.= "\n";

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= '# ' . $comment . "\n";
        }

        return $code;
    }

    private function getImports(PropertyTypeAbstract $origin): array
    {
        $imports = [];

        $imports[] = 'from pydantic import BaseModel, Field, GetCoreSchemaHandler';
        $imports[] = 'from pydantic_core import CoreSchema, core_schema';
        $imports[] = 'from typing import Any, Dict, Generic, List, Optional, TypeVar, Union';

        if (TypeUtil::contains($origin, StringPropertyType::class, Format::DATE)) {
            $imports[] = 'import datetime';
        } elseif (TypeUtil::contains($origin, StringPropertyType::class, Format::TIME)) {
            $imports[] = 'import datetime';
        } elseif (TypeUtil::contains($origin, StringPropertyType::class, Format::DATETIME)) {
            $imports[] = 'import datetime';
        }

        $refs = [];
        TypeUtil::walk($origin, function(TypeInterface $type) use (&$refs){
            if ($type instanceof ReferencePropertyType) {
                $refs[$type->getRef()] = $type->getRef();
                if ($type->getTemplate()) {
                    foreach ($type->getTemplate() as $ref) {
                        $refs[$ref] = $ref;
                    }
                }
            } elseif ($type instanceof StructDefinitionType && $type->getParent()) {
                $refs[$type->getParent()] = $type->getParent();
            }
        });

        foreach ($refs as $ref) {
            [$ns, $name] = TypeUtil::split($ref);
            $imports[] = 'from .' . $this->normalizer->file($name) . ' import ' . $this->normalizer->class($name);
        }

        return $imports;
    }
}
