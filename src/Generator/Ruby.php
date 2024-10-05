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
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\StructDefinitionType;

/**
 * Ruby
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Ruby extends CodeGeneratorAbstract
{
    public function getFileName(string $file): string
    {
        return $file . '.rb';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Ruby($mapping, $this->normalizer);
    }

    protected function newNormalizer(): NormalizerInterface
    {
        return new Normalizer\Ruby();
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructDefinitionType $origin): string
    {
        $code = 'class ' . $name->getClass() . "\n";

        if (!empty($extends)) {
            $code.= $this->indent . 'extend ' . $extends . "\n";
        }

        $attr = [];
        $items = [];
        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $attr[] = ':' . $property->getName()->getProperty();
            $items[] = $property->getName()->getProperty();
        }

        if (!empty($attr)) {
            $code.= $this->indent . 'attr_accessor ' . implode(', ', $attr) . "\n";
        }

        $code.= "\n";

        $code.= $this->indent . 'def initialize(' . implode(', ', $items) . ')' . "\n";
        foreach ($items as $item) {
            $code.= $this->indent . $this->indent . '@' . $item . ' = ' . $item . "\n";
        }
        $code.= $this->indent . 'end' . "\n";

        $code.= 'end' . "\n";

        return $code;
    }

    protected function writeHeader(DefinitionTypeAbstract $origin, Code\Name $className): string
    {
        $code = '';

        if (!empty($this->namespace)) {
            $code.= 'module ' . $this->namespace . "\n";
            $code.= "\n";
        }

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= '# ' . $comment . "\n";
        }

        return $code;
    }

    protected function writeFooter(DefinitionTypeAbstract $origin, Code\Name $className): string
    {
        $code = '';

        if (!empty($this->namespace)) {
            $code.= 'end' . "\n";
        }

        return $code;
    }

    protected function getIndent(): int
    {
        return 2;
    }
}
