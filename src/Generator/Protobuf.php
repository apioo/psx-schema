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

        $index = 1;
        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . 'optional ' . $property->getType() . ' ' . $property->getName()->getProperty() . ' = ' . $index . ' [json_name="' . $property->getName()->getRaw() . '"];' . "\n";

            $index++;
        }

        $code.= '}' . "\n";

        return $code;
    }
}
