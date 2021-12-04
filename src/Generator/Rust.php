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
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;

/**
 * Rust
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Rust extends CodeGeneratorAbstract
{
    /**
     * @inheritDoc
     */
    public function getFileName(string $file): string
    {
        return $file . '.rs';
    }

    /**
     * @inheritDoc
     */
    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Rust($mapping);
    }

    /**
     * @inheritDoc
     */
    protected function writeStruct(string $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = 'struct ' . $name . ' {' . "\n";

        if (!empty($extends)) {
            $code.= $this->indent . '*' . $extends . "\n";
        }

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . $name . ': ' . $property->getType() . ',' . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(string $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $code = 'type ' . $name . ' = HashMap<String, ' . $subType . '>() {' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    protected function writeReference(string $name, string $type, ReferenceType $origin): string
    {
        return 'type ' . $name . ' = ' . $type . "\n";
    }

    protected function writeHeader(TypeAbstract $origin): string
    {
        $code = "\n";

        if (!empty($this->namespace)) {
            $code.= 'package ' . $this->namespace . "\n";
        }

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= "\n";
            $code.= '// ' . $comment . "\n";
        }

        return $code;
    }
}
