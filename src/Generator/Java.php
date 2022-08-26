<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * Java
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Java extends CodeGeneratorAbstract
{
    private const RESERVED_NAMES = [
        'abstract',
        'assert',
        'boolean',
        'break',
        'byte',
        'case',
        'catch',
        'char',
        'class',
        'const',
        'continue',
        'default',
        'double',
        'do',
        'else',
        'enum',
        'extends',
        'false',
        'final',
        'finally',
        'float',
        'for',
        'goto',
        'if',
        'implements',
        'import',
        'instanceof',
        'int',
        'interface',
        'long',
        'native',
        'new',
        'null',
        'package',
        'private',
        'protected',
        'public',
        'return',
        'short',
        'static',
        'strictfp',
        'super',
        'switch',
        'synchronized',
        'this',
        'throw',
        'throws',
        'transient',
        'true',
        'try',
        'void',
        'volatile',
        'while',
    ];

    /**
     * @inheritDoc
     */
    public function getFileName(string $file): string
    {
        return $file . '.java';
    }

    /**
     * @inheritDoc
     */
    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Java($mapping);
    }

    /**
     * @inheritDoc
     */
    protected function writeStruct(string $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = 'public class ' . $name;

        if (!empty($generics)) {
            $code.= '<' . implode(', ', $generics) . '>';
        }

        if (!empty($extends)) {
            $code.= ' extends ' . $extends;
        }

        $code.= ' {' . "\n";

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . 'private ' . $property->getType() . ' ' . $name . ';' . "\n";
        }

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . '@JsonSetter("' . $property->getName() . '")' . "\n";
            $code.= $this->indent . 'public void set' . $this->normalizeMethodName($name) . '(' . $property->getType() . ' ' . $name . ') {' . "\n";
            $code.= $this->indent . $this->indent . 'this.' . $name . ' = ' . $name . ';' . "\n";
            $code.= $this->indent . '}' . "\n";

            $code.= $this->indent . '@JsonGetter("' . $property->getName() . '")' . "\n";
            $code.= $this->indent . 'public ' . $property->getType() . ' get' . $this->normalizeMethodName($name) . '() {' . "\n";
            $code.= $this->indent . $this->indent . 'return this.' . $name . ';' . "\n";
            $code.= $this->indent . '}' . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(string $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $code = 'public class ' . $name . ' extends HashMap<String, ' . $subType . '> {' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    protected function writeReference(string $name, string $type, ReferenceType $origin): string
    {
        $code = 'public class ' . $name . ' extends ' . $type . ' {' . "\n";
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

    protected function normalizeMethodName(string $name): string
    {
        if (str_starts_with($name, '_')) {
            $name = substr($name, 1);
        }

        $name = parent::normalizeMethodName($name);
        if ($name === 'Class') {
            // getClass is the only reserved getter at the Object
            $name = '_Class';
        }

        return $name;
    }

    protected function getReservedNames(): array
    {
        return self::RESERVED_NAMES;
    }

    private function getImports(TypeAbstract $origin): array
    {
        $imports = [];
        $imports[] = 'import com.fasterxml.jackson.annotation.JsonGetter;';
        $imports[] = 'import com.fasterxml.jackson.annotation.JsonSetter;';

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
