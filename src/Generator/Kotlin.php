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

use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\TypeUtil;

/**
 * Kotlin
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Kotlin extends CodeGeneratorAbstract
{
    public function getFileName(string $file): string
    {
        return $file . '.kt';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Kotlin($mapping, $this->normalizer);
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = 'open class ' . $name->getClass();

        if (!empty($generics)) {
            $code.= '<' . implode(', ', $generics) . '>';
        }

        if (!empty($extends)) {
            $code.= ' : ' . $extends;
        }

        $code.= ' {' . "\n";

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . 'var ' . $property->getName()->getProperty() . ': ' . $property->getType() . '? = null' . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $code = 'open class ' . $name->getClass() . ' : HashMap<String, ' . $subType . '>() {' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    protected function writeReference(Code\Name $name, string $type, ReferenceType $origin): string
    {
        return 'typealias ' . $name->getClass() . ' = ' . $type . "\n";
    }

    protected function writeHeader(TypeAbstract $origin): string
    {
        $code = '';

        if (!empty($this->namespace)) {
            $code.= 'package ' . $this->namespace . ';' . "\n";
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
            $code.= '/**' . "\n";
            $code.= ' * ' . $comment . "\n";
            $code.= ' */' . "\n";
        }

        return $code;
    }

    private function getImports(TypeAbstract $origin): array
    {
        $imports = [];

        if (TypeUtil::contains($origin, StringType::class, TypeAbstract::FORMAT_URI)) {
            $imports[] = 'import java.net.URI;';
        }

        if (TypeUtil::contains($origin, StringType::class, TypeAbstract::FORMAT_DURATION)) {
            $imports[] = 'import java.time.Duration;';
        }

        if (TypeUtil::contains($origin, StringType::class, TypeAbstract::FORMAT_DATE)) {
            $imports[] = 'import java.time.LocalDate;';
        }

        if (TypeUtil::contains($origin, StringType::class, TypeAbstract::FORMAT_TIME)) {
            $imports[] = 'import java.time.LocalTime;';
        }

        if (TypeUtil::contains($origin, StringType::class, TypeAbstract::FORMAT_DATETIME)) {
            $imports[] = 'import java.time.LocalDateTime;';
        }

        if (TypeUtil::contains($origin, MapType::class)) {
            $imports[] = 'import java.util.HashMap;';
        }

        return $imports;
    }
}
