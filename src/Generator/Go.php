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
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\TypeUtil;

/**
 * Go
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Go extends CodeGeneratorAbstract
{
    public function getFileName(string $file): string
    {
        if (str_ends_with($file, '_test')) {
            // in case the file ends with _test we rename it to _test_ so that go does not interpret this file as test
            $file .= '_';
        }

        return $file . '.go';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Go($mapping, $this->normalizer);
    }

    protected function newNormalizer(): NormalizerInterface
    {
        return new Normalizer\Go();
    }

    protected function supportsExtends(): bool
    {
        return false;
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, ?array $templates, StructDefinitionType $origin): string
    {
        $generic = '';
        if (!empty($generics) && empty($templates)) {
            $types = [];
            foreach ($generics as $type) {
                $types[] = $type . ' any';
            }
            $generic = '[' . implode(', ', $types) . ']';
        }

        $code = 'type ' . $name->getClass() . $generic . ' struct {' . "\n";

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $ref = '';
            if ($property->getOrigin() instanceof ReferencePropertyType) {
                $ref = '*';
            }

            $code.= $this->indent . $property->getName()->getProperty() . ' ' . $ref . $property->getType() . ' `json:"' . $property->getName()->getRaw() . '"`' . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapDefinitionType $origin): string
    {
        return 'type ' . $name->getClass() . ' = map[string]' . $type . "\n";
    }

    protected function writeArray(Code\Name $name, string $type, ArrayDefinitionType $origin): string
    {
        return 'type ' . $name->getClass() . ' = []' . $type . "\n";
    }

    protected function writeHeader(DefinitionTypeAbstract $origin, Code\Name $className): string
    {
        $code = '';

        if (!empty($this->namespace)) {
            $code.= 'package ' . $this->namespace . "\n";
        }

        $imports = $this->getImports($origin, $className);
        if (!empty($imports)) {
            $code.= "\n";
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

            if ($ns !== DefinitionsInterface::SELF_NAMESPACE && $this->mapping[$ns]) {
                $imports[$ns] = 'import "' . $this->mapping[$ns] . '"';
            }
        }

        return array_values($imports);
    }
}
