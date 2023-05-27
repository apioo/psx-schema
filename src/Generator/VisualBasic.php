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
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\TypeUtil;

/**
 * VisualBasic
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class VisualBasic extends CodeGeneratorAbstract
{
    public function getFileName(string $file): string
    {
        return $file . '.vb';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\VisualBasic($mapping, $this->normalizer);
    }

    protected function newNormalizer(): NormalizerInterface
    {
        return new Normalizer\VisualBasic();
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = 'Public Class ' . $name->getClass();

        if (!empty($generics)) {
            $code.= '(Of ' . implode(', ', $generics) . ')';
        }

        if (!empty($extends)) {
            $code.= "\n" . $this->indent . 'Inherits ' . $extends;
        }

        $code.= "\n";

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . '<JsonPropertyName("' . $property->getName()->getRaw() . '")>' . "\n";
            $code.= $this->indent . 'Public Property ' . $property->getName()->getProperty() . ' As ' . $property->getType() . "\n";
        }

        $code.= 'End Class' . "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $code = 'Public Class ' . $name->getClass() . "\n";
        $code.= $this->indent . 'Inherits Dictionary(Of String, ' . $subType . ')' . "\n";
        $code.= 'End Class' . "\n";

        return $code;
    }

    protected function writeReference(Code\Name $name, string $type, ReferenceType $origin): string
    {
        $code = 'Public Class ' . $name->getClass() . ' : ' . $type . "\n";
        $code.= $this->indent . 'Inherits ' . $type . "\n";
        $code.= 'End Class' . "\n";

        return $code;
    }

    protected function writeHeader(TypeAbstract $origin): string
    {
        $code = '';

        if (!empty($this->namespace)) {
            $code.= 'Namespace ' . $this->namespace . "\n";
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
            $code.= '\' ' . $comment . "\n";
        }

        return $code;
    }

    protected function writeFooter(TypeAbstract $origin): string
    {
        if (!empty($this->namespace)) {
            return 'End Namespace' . "\n";
        } else {
            return '';
        }
    }

    private function getImports(TypeAbstract $origin): array
    {
        $imports = [];
        $imports[] = 'Imports System.Text.Json.Serialization';

        if (TypeUtil::contains($origin, MapType::class)) {
            $imports[] = 'using System.Collections.Generic;';
        }

        return $imports;
    }
}
