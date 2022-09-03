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

use PSX\Schema\Generator\Normalizer\NormalizerInterface;
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
    public function getFileName(string $file): string
    {
        return $file . '.rs';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Rust($mapping);
    }

    protected function newNormalizer(): NormalizerInterface
    {
        return new Normalizer\Rust();
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = 'struct ' . $name->getClass() . ' {' . "\n";

        if (!empty($extends)) {
            $code.= $this->indent . '*' . $extends . "\n";
        }

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . $property->getName()->getProperty() . ': ' . $property->getType() . ',' . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $code = 'type ' . $name->getClass() . ' = HashMap<String, ' . $subType . '>() {' . "\n";
        $code.= '}' . "\n";

        return $code;
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

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= "\n";
            $code.= '// ' . $comment . "\n";
        }

        return $code;
    }
}
