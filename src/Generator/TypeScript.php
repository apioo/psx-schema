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
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\StructDefinitionType;
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

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, ?array $templates, StructDefinitionType $origin): string
    {
        $code = 'export interface ' . $name->getClass();

        if (!empty($generics)) {
            $code.= $this->generator->getGenericDefinition($generics);
        }

        if (!empty($extends)) {
            $code.= ' extends ' . $extends;
            if (!empty($templates)) {
                $code.= $this->generator->getGenericDefinition($templates);
            }
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

            $nullable = $property->isNullable() === false ? '' : '?';
            $code.= $this->indent . $propertyName . $nullable . ': ' . $type . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapDefinitionType $origin): string
    {
        $code ='export interface ' . $name->getClass() . ' extends Record<string, ' . $type . '> {' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    protected function writeHeader(DefinitionTypeAbstract $origin, Code\Name $className): string
    {
        $code = '';

        $imports = $this->getImports($origin, $className);
        if (!empty($imports)) {
            $code.= implode("\n", $imports);
            $code.= "\n";
        }

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            if (!empty($imports)) {
                $code.= "\n";
            }

            $code.= '/**' . "\n";
            $code.= ' * ' . $comment . "\n";
            $code.= ' */';
        }

        return $code;
    }

    private function getImports(DefinitionTypeAbstract $origin, Code\Name $className): array
    {
        $imports = [];
        $refs = TypeUtil::findRefs($origin);
        foreach ($refs as $ref) {
            [$ns, $name] = TypeUtil::split($ref);

            $typeName = $this->normalizer->class($name);
            if ($typeName === $className->getClass()) {
                // we dont need to include the same class
                continue;
            }

            if ($ns === DefinitionsInterface::SELF_NAMESPACE) {
                $imports[] = 'import {' . $typeName . '} from "./' . $this->normalizer->import($name) . '";';
            } else {
                if (!isset($this->mapping[$ns])) {
                    throw new GeneratorException('Provided namespace "' . $ns . '" is not configured');
                }

                $imports[] = 'import {' . $typeName . '} from "' . $this->mapping[$ns] . '";';
            }
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
