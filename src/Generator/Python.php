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

        [$parentMapping, $parentDiscriminator] = $this->getDiscriminatorByParent($origin);
        if (isset($parentMapping[$name->getRaw()])) {
            $discriminatorProperty = $this->normalizer->property($parentDiscriminator);

            $code.= $this->indent . $discriminatorProperty . ': Literal["' . $parentMapping[$name->getRaw()] . '"] = Field(alias="' . $parentDiscriminator . '")' . "\n";
        }

        $originDiscriminator = $origin->getDiscriminator();

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            if ($property->getName()->getRaw() === $parentDiscriminator) {
                // skip discriminated union properties
                continue;
            }

            $isDiscriminatorProperty = $property->getName()->getRaw() === $originDiscriminator;

            [$unionType, $discriminator] = $this->buildDiscriminatorUnion($property);
            if (!empty($unionType)) {
                $type = $unionType;
            } else {
                $type = $property->getType();
            }

            if ($property->isNullable() !== false && !$isDiscriminatorProperty && empty($discriminator)) {
                $type = 'Optional[' . $type . ']';
            }

            $default = '';
            $defaultValue = $property->getDefault();

            if ($isDiscriminatorProperty) {
                $default = '';
            } elseif (!empty($discriminator)) {
                if (str_starts_with($unionType, 'List[')) {
                    $default = 'discriminator="' . $discriminator . '", default_factory=list, ';
                } else {
                    $default = 'discriminator="' . $discriminator . '", ';
                }
            } elseif ($defaultValue !== null) {
                $default = 'default="' . addcslashes($defaultValue, '"\\') . '", ';
            } elseif ($property->isNullable() !== false) {
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
        $imports[] = 'from typing import Any, Dict, Generic, List, Optional, TypeVar, Annotated, Union, Literal';

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

            if ($ns !== DefinitionsInterface::SELF_NAMESPACE && isset($this->mapping[$ns])) {
                $imports[] = 'from ' . $this->mapping[$ns] . ' import ' . $this->normalizer->class($name);
            } else {
                $imports[] = 'from .' . $this->normalizer->file($name) . ' import ' . $this->normalizer->class($name);
            }
        }

        return array_merge($imports, $this->buildDiscriminatorImports($origin));
    }

    private function buildDiscriminatorUnion(Code\Property $property): array
    {
        [$mapping, $discriminator] = $this->getDiscriminatorByProperty($property->getOrigin());
        if (empty($discriminator)) {
            return [null, null];
        }

        $subTypes = [];
        foreach ($mapping as $class => $value) {
            $subTypes[] = $this->normalizer->class($class);
        }

        $unionType = 'Union[' . implode(', ', $subTypes) . ']';

        if ($property->getOrigin() instanceof ArrayPropertyType) {
            return ['List[' . $unionType . ']', $discriminator];
        } elseif ($property->getOrigin() instanceof MapPropertyType) {
            throw new GeneratorException('Map with discriminated unions are not supported');
        } else {
            return [$unionType, $discriminator];
        }
    }

    private function buildDiscriminatorImports(DefinitionTypeAbstract $origin): array
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
            [$mapping] = $this->getDiscriminatorByProperty($property);
            if (!is_array($mapping)) {
                continue;
            }

            foreach ($mapping as $class => $value) {
                [$ns, $name] = TypeUtil::split($class);
                $imports[] = 'from .' . $this->normalizer->file($name) . ' import ' . $this->normalizer->class($name);
            }
        }

        return $imports;
    }

    /**
     * @return array{array|null, string|null}
     */
    private function getDiscriminatorByProperty(PropertyTypeAbstract $property): array
    {
        if ($property instanceof CollectionPropertyType) {
            $property = $property->getSchema();
        }

        if (!$property instanceof ReferencePropertyType) {
            return [null, null];
        }

        return $this->getDiscriminatorType($property);
    }

    /**
     * @return array{array|null, string|null}
     */
    private function getDiscriminatorByParent(StructDefinitionType $origin): array
    {
        $parent = $origin->getParent();
        if (!$parent instanceof ReferencePropertyType) {
            return [null, null];
        }

        return $this->getDiscriminatorType($parent);
    }

    /**
     * @return array{array|null, string|null}
     */
    private function getDiscriminatorType(ReferencePropertyType $property): array
    {
        $type = $this->definitions->getType($property->getTarget());
        if (!$type instanceof StructDefinitionType) {
            return [null, null];
        }

        $discriminator = $type->getDiscriminator();
        $mapping = $type->getMapping();
        if ($discriminator === null || $mapping === null) {
            return [null, null];
        }

        return [$mapping, $discriminator];
    }
}
