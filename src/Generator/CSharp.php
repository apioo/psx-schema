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

use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\MapDefinitionType;
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
                $code.= '[JsonDerivedType(typeof(' . $class . '), typeDiscriminator: "' . $value . '")]' . "\n";
            }
        }

        $code.= 'public ' . ($origin->getBase() === true ? 'abstract ' : '') . 'class ' . $name->getClass();

        if (!empty($generics)) {
            $code.= $this->generator->getGenericType($generics);
        }

        if (!empty($extends)) {
            $code.= ' : ' . $extends;
            if (!empty($templates)) {
                $code.= $this->generator->getGenericType($templates);
            }
        }

        $code.= "\n";
        $code.= '{' . "\n";

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . '[JsonPropertyName("' . $property->getName()->getRaw() . '")]' . "\n";
            $code.= $this->indent . 'public ' . $property->getType() . '? ' . $property->getName()->getProperty() . ' { get; set; }' . "\n";
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
            $code.= "\n";
            $code.= implode("\n", $imports);
            $code.= "\n";
        }

        if (!empty($this->namespace)) {
            $code.= 'namespace ' . $this->namespace . ';' . "\n";
        }

        $code.= "\n";

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= '/// <summary>' . "\n";
            $code.= '/// ' . $comment . "\n";
            $code.= '/// </summary>' . "\n";
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
}
