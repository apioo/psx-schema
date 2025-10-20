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

use PSX\Schema\Exception\TypeNotFoundException;
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\TypeUtil;

/**
 * CSharp
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class CSharp extends CodeGeneratorAbstract
{
    public function getFileName(string $file): string
    {
        return $file . '.cs';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\CSharp($mapping, $this->normalizer);
    }

    protected function newNormalizer(): NormalizerInterface
    {
        return new Normalizer\CSharp();
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, ?array $templates, StructDefinitionType $origin): string
    {
        $code = '';

        $discriminator = $origin->getDiscriminator();
        if ($discriminator !== null) {
            $code.= '[JsonPolymorphic(TypeDiscriminatorPropertyName = "' . $discriminator . '")]' . "\n";
        }

        $mapping = $origin->getMapping();
        if ($mapping !== null) {
            foreach ($mapping as $class => $value) {
                $code.= '[JsonDerivedType(typeof(' . $this->normalizer->class($class) . '), typeDiscriminator: "' . $value . '")]' . "\n";
            }
        }

        $code.= 'public ' . ($origin->getBase() === true ? 'abstract ' : '') . 'class ' . $name->getClass();

        if (!empty($generics)) {
            $code.= $this->generator->getGenericDefinition($generics);
        }

        if (!empty($extends)) {
            $code.= ' : ' . $extends;
            if (!empty($templates)) {
                $code.= $this->generator->getGenericDefinition($templates);
            }
        }

        $code.= "\n";
        $code.= '{' . "\n";

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            // in case we override an existing property we need to use the new keyword s.
            // https://learn.microsoft.com/en-us/dotnet/csharp/language-reference/keywords/new-modifier
            $override = '';
            if ($this->hasPropertyInParent($property->getName()->getRaw(), $origin->getParent())) {
                $override = 'new ';
            }

            $propertyName = $property->getName()->getProperty();
            if ($name->getClass() === $propertyName) {
                // fix: member names cannot be the same as their enclosing type (CS0542)
                $propertyName = $propertyName . '_';
            }

            $nullable = $property->isNullable() === false ? '' : '?';

            $default = '';
            $defaultValue = $property->getDefault();
            if ($defaultValue !== null) {
                $default = ' = "' . addcslashes($defaultValue, '"\\') . '";';
            }

            $code.= $this->indent . '[JsonPropertyName("' . $property->getName()->getRaw() . '")]' . "\n";

            if ($property->isDeprecated() === true) {
                $code.= $this->indent . '[ObsoleteAttribute()]' . "\n";
            }

            $code.= $this->indent . 'public ' . $override . $property->getType() . $nullable . ' ' . $propertyName . ' { get; set; }' . $default . "\n";
            $code.= "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapDefinitionType $origin): string
    {
        $code = 'public class ' . $name->getClass() . ' : Dictionary<string, ' . $type . '>' . "\n";
        $code.= '{' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    protected function writeArray(Code\Name $name, string $type, ArrayDefinitionType $origin): string
    {
        $code = 'public class ' . $name->getClass() . ' : List<string, ' . $type . '>' . "\n";
        $code.= '{' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    protected function writeHeader(DefinitionTypeAbstract $origin, Code\Name $className): string
    {
        $code = '';

        $imports = $this->getImports($origin);
        if (!empty($imports)) {
            $code.= implode("\n", $imports);
            $code.= "\n";
        }

        if (!empty($this->namespace)) {
            $code.= "\n";
            $code.= 'namespace ' . $this->namespace . ';' . "\n";
        }

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= "\n";
            $code.= '/// <summary>' . "\n";
            $code.= '/// ' . $comment . "\n";
            $code.= '/// </summary>';
        }

        return $code;
    }

    private function getImports(DefinitionTypeAbstract $origin): array
    {
        $imports = [];
        $imports[] = 'using System.Text.Json.Serialization;';

        if (TypeUtil::contains($origin, MapDefinitionType::class)) {
            $imports[] = 'using System.Collections.Generic;';
        }

        return $imports;
    }

    /**
     * @throws TypeNotFoundException
     */
    private function hasPropertyInParent(string $propertyName, ?ReferencePropertyType $reference): bool
    {
        $target = $reference?->getTarget();
        if (empty($target)) {
            return false;
        }

        $parent = $this->definitions->getType($target);
        if (!$parent instanceof StructDefinitionType) {
            return false;
        }

        if ($parent->hasProperty($propertyName)) {
            return true;
        }

        return $this->hasPropertyInParent($propertyName, $parent->getParent());
    }
}
