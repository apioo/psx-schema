<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Schema\Exception\GeneratorException;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\StructDefinitionType;

/**
 * Protobuf
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Protobuf extends CodeGeneratorAbstract
{
    public function getFileName(string $file): string
    {
        return $file . '.proto';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Protobuf($mapping, $this->normalizer);
    }

    protected function supportsExtends(): bool
    {
        return false;
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, ?array $templates, StructDefinitionType $origin): string
    {
        $code = 'message ' . $name->getClass() . ' {' . "\n";

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . 'optional ' . $property->getType() . ' ' . $property->getName()->getProperty() . ' = ' . $this->generateNumber($property->getName()->getRaw()) . ' [json_name="' . $property->getName()->getRaw() . '"];' . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    private function generateNumber(string $name): int
    {
        $hash = sha1($name);
        $result = 0;
        for ($i = 0; $i < 7; $i++) {
            $result+= (hexdec($hash[$i]) << ($i * 4));
        }

        /** @psalm-suppress TypeDoesNotContainType */
        if ($result >= 19_000 && $result <= 19_999) {
            // Field numbers 19,000 to 19,999 are reserved for the Protocol Buffers implementation
            $result += (19_999 - $result) + 1;
        }

        if ($result > 536_870_911) {
            throw new GeneratorException('Generated index is too large');
        }

        return $result;
    }
}
