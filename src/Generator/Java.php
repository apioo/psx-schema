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

use PSX\Schema\Format;
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\TypeUtil;

/**
 * Java
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Java extends CodeGeneratorAbstract
{
    public function getFileName(string $file): string
    {
        return $file . '.java';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Java($mapping, $this->normalizer);
    }

    protected function newNormalizer(): NormalizerInterface
    {
        return new Normalizer\Java();
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = 'public class ' . $name->getClass();

        if (!empty($generics)) {
            $code.= '<' . implode(', ', $generics) . '>';
        }

        if (!empty($extends)) {
            $code.= ' extends ' . $extends;
        }

        $code.= ' {' . "\n";

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . 'private ' . $property->getType() . ' ' . $property->getName()->getProperty() . ';' . "\n";
        }

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . '@JsonSetter("' . $property->getName()->getRaw() . '")' . "\n";
            $code.= $this->indent . 'public void ' . $property->getName()->getMethod(prefix: ['set']) . '(' . $property->getType() . ' ' . $property->getName()->getArgument() . ') {' . "\n";
            $code.= $this->indent . $this->indent . 'this.' . $property->getName()->getProperty() . ' = ' . $property->getName()->getArgument() . ';' . "\n";
            $code.= $this->indent . '}' . "\n";

            $code.= $this->indent . '@JsonGetter("' . $property->getName()->getRaw() . '")' . "\n";
            $code.= $this->indent . 'public ' . $property->getType() . ' ' . $property->getName()->getMethod(prefix: ['get']) . '() {' . "\n";
            $code.= $this->indent . $this->indent . 'return this.' . $property->getName()->getProperty() . ';' . "\n";
            $code.= $this->indent . '}' . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $code = 'public class ' . $name->getClass() . ' extends HashMap<String, ' . $subType . '> {' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    protected function writeReference(Code\Name $name, string $type, ReferenceType $origin): string
    {
        $code = 'public class ' . $name->getClass() . ' extends ' . $type . ' {' . "\n";
        $code.= '}' . "\n";

        return $code;
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
        $imports[] = 'import com.fasterxml.jackson.annotation.JsonGetter;';
        $imports[] = 'import com.fasterxml.jackson.annotation.JsonSetter;';

        if (TypeUtil::contains($origin, StringType::class, Format::URI)) {
            $imports[] = 'import java.net.URI;';
        }

        if (TypeUtil::contains($origin, StringType::class, Format::DURATION)) {
            $imports[] = 'import java.time.Duration;';
        }

        if (TypeUtil::contains($origin, StringType::class, Format::PERIOD)) {
            $imports[] = 'import java.time.Period;';
        }

        if (TypeUtil::contains($origin, StringType::class, Format::DATE)) {
            $imports[] = 'import java.time.LocalDate;';
        }

        if (TypeUtil::contains($origin, StringType::class, Format::TIME)) {
            $imports[] = 'import java.time.LocalTime;';
        }

        if (TypeUtil::contains($origin, StringType::class, Format::DATETIME)) {
            $imports[] = 'import java.time.LocalDateTime;';
        }

        if (TypeUtil::contains($origin, MapType::class)) {
            $imports[] = 'import java.util.HashMap;';
        }

        return $imports;
    }
}
