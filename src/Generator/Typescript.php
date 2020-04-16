<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use PSX\Schema\TypeInterface;

/**
 * Typescript
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Typescript extends CodeGeneratorAbstract
{
    protected function newTypeGenerator(): GeneratorInterface
    {
        return new Type\Typescript();
    }

    protected function writeStruct(string $name, array $properties, ?string $extends, ?array $generics, TypeInterface $origin): string
    {
        $code = $this->writeHeader($origin->getDescription());
        $code.= 'interface ' . $name;

        if (!empty($generics)) {
            $code.= '<' . implode(', ', $generics) . '>';
        }

        if (!empty($extends)) {
            $code.= ' extends ' . $extends;
        }

        $code.= ' {' . "\n";

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . $name . ($property->isRequired() ? '' : '?') . ': ' . $property->getType() . "\n";
        }

        $code.= '}' . "\n";
        $code.= $this->writerFooter();

        return $code;
    }

    protected function writeMap(string $name, string $type, TypeInterface $origin): string
    {
        return 'type ' . $name . ' = ' . $type . ';' . "\n";
    }

    protected function writeArray(string $name, string $type, TypeInterface $origin): string
    {
        return 'type ' . $name . ' = ' . $type . ';' . "\n";
    }

    protected function writeUnion(string $name, string $type, TypeInterface $origin): string
    {
        return 'type ' . $name . ' = ' . $type . ';' . "\n";
    }

    protected function writeIntersection(string $name, string $type, TypeInterface $origin): string
    {
        return 'type ' . $name . ' = ' . $type . ';' . "\n";
    }

    protected function writeReference(string $name, string $type, TypeInterface $origin): string
    {
        return 'type ' . $name . ' = ' . $type . ';' . "\n";
    }

    protected function normalizeName(string $name)
    {
        if (strpos($name, '-') !== false) {
            $name = '"' . $name . '"';
        }

        return $name;
    }

    private function writeHeader(?string $comment): string
    {
        $code = '';

        if (!empty($this->namespace)) {
            $code.= 'namespace ' . $this->namespace . ' {' . "\n";
        }

        if (!empty($comment)) {
            $code.= '/**' . "\n";
            $code.= ' * ' . $comment . "\n";
            $code.= ' */' . "\n";
        }

        return $code;
    }

    private function writerFooter(): string
    {
        if (!empty($this->namespace)) {
            return '}' . "\n";
        } else {
            return '';
        }
    }
}
