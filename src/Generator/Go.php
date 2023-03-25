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
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
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

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $generic = '';
        if (!empty($generics)) {
            $types = [];
            foreach ($generics as $type) {
                $types[] = $type . ' any';
            }
            $generic = '[' . implode(', ', $types) . ']';
        }

        $code = 'type ' . $name->getClass() . $generic . ' struct {' . "\n";

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . $property->getName()->getProperty() . ' ' . $property->getType() . ' `json:"' . $property->getName()->getRaw() . '"`' . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        return 'type ' . $name->getClass() . ' = map[string]' . $subType . "\n";
    }

    protected function writeReference(Code\Name $name, string $type, ReferenceType $origin): string
    {
        return 'type ' . $name->getClass() . ' = ' . $type . "\n";
    }

    protected function writeHeader(TypeAbstract $origin): string
    {
        $code = "\n";

        if (!empty($this->namespace)) {
            $code.= 'package ' . $this->namespace . "\n";
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
            $code.= '// ' . $comment . "\n";
        }

        return $code;
    }

    private function getImports(TypeAbstract $origin): array
    {
        $imports = [];

        if (TypeUtil::contains($origin, StringType::class, TypeAbstract::FORMAT_DURATION)) {
            $imports[] = 'import "time"';
        } elseif (TypeUtil::contains($origin, StringType::class, TypeAbstract::FORMAT_DATE)) {
            $imports[] = 'import "time"';
        } elseif (TypeUtil::contains($origin, StringType::class, TypeAbstract::FORMAT_TIME)) {
            $imports[] = 'import "time"';
        } elseif (TypeUtil::contains($origin, StringType::class, TypeAbstract::FORMAT_DATETIME)) {
            $imports[] = 'import "time"';
        }

        return $imports;
    }
}
