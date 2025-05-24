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

use PSX\Schema\Format;
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\TypeUtil;

/**
 * Rust
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Rust extends CodeGeneratorAbstract
{
    public function getFileName(string $file): string
    {
        return $file . '.rs';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Rust($mapping, $this->normalizer);
    }

    protected function newNormalizer(): NormalizerInterface
    {
        return new Normalizer\Rust();
    }

    protected function supportsExtends(): bool
    {
        return false;
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, ?array $templates, StructDefinitionType $origin): string
    {
        $code = '#[derive(Serialize, Deserialize)]' . "\n";
        $code.= 'pub struct ' . $name->getClass() . ' {' . "\n";

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $type = $property->getType();
            if ($property->isNullable() !== false) {
                $type = 'Option<' . $type . '>';
            }

            $code.= $this->indent . '#[serde(rename = "' . $property->getName()->getRaw() . '")]' . "\n";
            $code.= $this->indent . $property->getName()->getProperty() . ': ' . $type . ',' . "\n";
            $code.= "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapDefinitionType $origin): string
    {
        return 'pub type ' . $name->getClass() . ' = std::collections::HashMap<String, ' . $type . '>;' . "\n";
    }

    protected function writeArray(Code\Name $name, string $type, ArrayDefinitionType $origin): string
    {
        return 'pub type ' . $name->getClass() . ' = std::collections::LinkedList<' . $type . '>;' . "\n";
    }

    protected function writeHeader(DefinitionTypeAbstract $origin, Code\Name $className): string
    {
        $code = '';

        if (!empty($this->namespace)) {
            $code.= 'mod ' . $this->namespace . ';' . "\n";
            $code.= "\n";
        }

        $imports = $this->getImports($origin);
        if (!empty($imports)) {
            $code.= implode("\n", $imports);
            $code.= "\n";
        }

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= "\n";
            $code.= '// ' . $comment;
        }

        return $code;
    }

    private function getImports(DefinitionTypeAbstract $origin): array
    {
        $imports = [];

        if ($origin instanceof StructDefinitionType) {
            $imports[] = 'use serde::{Serialize, Deserialize};';
        }

        $refs = TypeUtil::findRefs($origin);
        foreach ($refs as $ref) {
            [$ns, $name] = TypeUtil::split($ref);
            $imports[] = 'use ' . $this->normalizer->file($name) . '::' . $this->normalizer->class($name) . ';';
        }

        return $imports;
    }
}
