<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use PSX\Schema\Type\StructType;

/**
 * Python
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Python extends CodeGeneratorAbstract
{
    /**
     * @inheritDoc
     */
    public function getFileName(string $file): string
    {
        return $file . '.py';
    }

    /**
     * @inheritDoc
     */
    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Python($mapping);
    }

    /**
     * @inheritDoc
     */
    protected function writeStruct(string $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = $this->writeHeader($origin->getDescription());
        $code.= 'class ' . $name;

        if (!empty($extends)) {
            $code.= '(' . $extends . ')';
        }

        $code.= ':' . "\n";

        $items = [];
        $args = [];
        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $args[] = $name . ': ' . $property->getType();
            $items[] = $name;
        }

        $code.= $this->indent . 'def __init__(self, ' . implode(', ', $args) . '):' . "\n";
        foreach ($items as $item) {
            $code.= $this->indent . $this->indent . 'self.' . $item . ' = ' . $item . "\n";
        }

        return $code;
    }

    protected function writeMap(string $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $code = $this->writeHeader($origin->getDescription());
        $code.= 'class ' . $name . '(Mapping[str, ' . $subType . ']):' . "\n";

        return $code;
    }

    protected function writeReference(string $name, string $type, ReferenceType $origin): string
    {
        $code = $this->writeHeader($origin->getDescription());
        $code.= 'class ' . $name . '(' . $type . '):' . "\n";

        return $code;
    }

    private function writeHeader(?string $comment)
    {
        $code = '';

        if (!empty($this->namespace)) {
            // TODO can we namespace?
        }

        if (!empty($comment)) {
            $code.= '# ' . $comment . "\n";
        }

        return $code;
    }
}
