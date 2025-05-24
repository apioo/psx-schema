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
use PSX\Schema\Format;
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\CollectionPropertyType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\MapPropertyType;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;
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

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, ?array $templates, StructDefinitionType $origin): string
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
            if (!empty($templates)) {
                $extends.= $this->generator->getGenericDefinition($templates);
            }
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
            $discriminator = $this->getDiscriminatorType($property);
            if (!empty($discriminator)) {
                $type = $discriminator;
            } else {
                $type = $property->getType();
            }

            $default = '';
            if ($property->isNullable() !== false) {
                $type = 'Optional[' . $type . ']';
                $default = 'default=None, ';
            }

            $code.= $this->indent . $property->getName()->getProperty() . ': ' . $type . ' = Field(' . $default . 'alias="' . $property->getName()->getRaw() . '")' . "\n";
        }

        $code.= '    pass' . "\n";
        $code.= "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapDefinitionType $origin): string
    {
        $code = 'class ' . $name->getClass() . '(UserDict[str, ' . $type . ']):' . "\n";
        $code.= '    @classmethod' . "\n";
        $code.= '    def __get_pydantic_core_schema__(cls, source_type: Any, handler: GetCoreSchemaHandler) -> CoreSchema:' . "\n";
        $code.= '        return core_schema.dict_schema(handler.generate_schema(str), handler.generate_schema(' . $type . '))' . "\n";
        $code.= "\n";

        return $code;
    }

    protected function writeArray(Code\Name $name, string $type, ArrayDefinitionType $origin): string
    {
        $code = 'class ' . $name->getClass() . '(UserList[' . $type . ']):' . "\n";
        $code.= '    @classmethod' . "\n";
        $code.= '    def __get_pydantic_core_schema__(cls, source_type: Any, handler: GetCoreSchemaHandler) -> CoreSchema:' . "\n";
        $code.= '        return core_schema.list_schema(handler.generate_schema(str), handler.generate_schema(' . $type . '))' . "\n";
        $code.= "\n";

        return $code;
    }

    protected function writeHeader(DefinitionTypeAbstract $origin, Code\Name $className): string
    {
        $code = '';

        $imports = $this->getImports($origin);
        if (!empty($imports)) {
            $code.= implode("\n", $imports);
            $code.= "\n";
            $code.= "\n";
        }

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= "\n";
            $code.= '# ' . $comment;
        }

        return $code;
    }

    private function getImports(DefinitionTypeAbstract $origin): array
    {
        $imports = [];

        $imports[] = 'from pydantic import BaseModel, Field, GetCoreSchemaHandler, Tag';
        $imports[] = 'from pydantic_core import CoreSchema, core_schema';
        $imports[] = 'from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union';

        if ($origin instanceof MapDefinitionType) {
            $imports[] = 'from collections import UserDict';
        } elseif ($origin instanceof ArrayDefinitionType) {
            $imports[] = 'from collections import UserList';
        }

        if (TypeUtil::contains($origin, StringPropertyType::class, Format::DATE)) {
            $imports[] = 'import datetime';
        } elseif (TypeUtil::contains($origin, StringPropertyType::class, Format::TIME)) {
            $imports[] = 'import datetime';
        } elseif (TypeUtil::contains($origin, StringPropertyType::class, Format::DATETIME)) {
            $imports[] = 'import datetime';
        }

        $refs = TypeUtil::findRefs($origin, true);
        foreach ($refs as $ref) {
            [$ns, $name] = TypeUtil::split($ref);

            if ($ns === DefinitionsInterface::SELF_NAMESPACE) {
                $imports[] = 'from .' . $this->normalizer->file($name) . ' import ' . $this->normalizer->class($name);
            } else {
                if (!isset($this->mapping[$ns])) {
                    throw new GeneratorException('Provided namespace "' . $ns . '" is not configured');
                }

                $imports[] = 'from ' . $this->mapping[$ns] . ' import ' . $this->normalizer->class($name);
            }
        }

        return array_merge($imports, $this->getDiscriminatorImports($origin));
    }

    private function getDiscriminatorType(Code\Property $property): ?string
    {
        $discriminatorConfig = $this->getDiscriminatorConfig($property->getOrigin());
        if (empty($discriminatorConfig)) {
            return null;
        }

        [$mapping, $discriminator] = $discriminatorConfig;

        $subTypes = [];
        foreach ($mapping as $class => $value) {
            $subTypes[] = 'Annotated[' . $this->normalizer->class($class) . ', Tag(\'' . $value . '\')]';
        }

        $unionType = 'Annotated[Union[' . implode(', ', $subTypes) . '], Field(discriminator=\'' . $discriminator . '\')]';

        if ($property->getOrigin() instanceof ArrayPropertyType) {
            return 'List[' . $unionType . ']';
        } elseif ($property->getOrigin() instanceof MapPropertyType) {
            return 'Dict[str, ' . $unionType . ']';
        } else {
            return $unionType;
        }
    }

    private function getDiscriminatorImports(DefinitionTypeAbstract $origin): array
    {
        if (!$origin instanceof StructDefinitionType) {
            return [];
        }

        $properties = $origin->getProperties();
        if (empty($properties)) {
            return [];
        }

        $imports = [];
        foreach ($origin->getProperties() as $property) {
            $discriminatorConfig = $this->getDiscriminatorConfig($property);
            if (empty($discriminatorConfig)) {
                continue;
            }

            [$mapping] = $discriminatorConfig;

            foreach ($mapping as $class => $value) {
                [$ns, $name] = TypeUtil::split($class);
                $imports[] = 'from .' . $this->normalizer->file($name) . ' import ' . $this->normalizer->class($name);
            }
        }

        return $imports;
    }

    private function getDiscriminatorConfig(PropertyTypeAbstract $property): ?array
    {
        if ($property instanceof CollectionPropertyType) {
            $property = $property->getSchema();
        }

        if (!$property instanceof ReferencePropertyType) {
            return null;
        }

        $type = $this->definitions->getType($property->getTarget());
        if (!$type instanceof StructDefinitionType) {
            return null;
        }

        $discriminator = $type->getDiscriminator();
        $mapping = $type->getMapping();
        if ($discriminator === null || $mapping === null) {
            return null;
        }

        return [$mapping, $discriminator];
    }
}
