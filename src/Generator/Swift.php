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

use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\StructDefinitionType;

/**
 * Swift
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Swift extends CodeGeneratorAbstract
{
    public function getFileName(string $file): string
    {
        return $file . '.swift';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Swift($mapping, $this->normalizer);
    }

    protected function newNormalizer(): NormalizerInterface
    {
        return new Normalizer\Swift();
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, ?array $templates, StructDefinitionType $origin): string
    {
        $code = 'class ' . $name->getClass() . ': ';

        if (!empty($extends)) {
            $code.= $extends . ' ';
        } else {
            $code.= 'Codable ';
        }

        $code.= '{' . "\n";

        $keys = [];
        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $keys[$property->getName()->getProperty()] = $property->getName()->getRaw();

            /** @var Code\Property $property */
            $code.= $this->indent . 'var ' . $property->getName()->getProperty() . ': ' . $property->getType() . "\n";
        }

        $code.= "\n";
        $code.= $this->indent . 'enum CodingKeys: String, CodingKey {' . "\n";
        foreach ($keys as $key => $raw) {
            $code.= $this->indent . $this->indent . 'case ' . $key . ' = "' . $raw . '"' . "\n";
        }
        $code.= $this->indent . '}' . "\n";

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(Code\Name $name, string $type, MapDefinitionType $origin): string
    {
        return 'typealias ' . $name->getClass() . ' = ' . $type . ';' . "\n";
    }

    protected function writeArray(Code\Name $name, string $type, ArrayDefinitionType $origin): string
    {
        return 'typealias ' . $name->getClass() . ' = ' . $type . ';' . "\n";
    }

    protected function writeHeader(DefinitionTypeAbstract $origin, Code\Name $className): string
    {
        $code = '';

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= '// ' . $comment . "\n";
        }

        return $code;
    }
}
