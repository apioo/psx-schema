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
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\StructDefinitionType;

/**
 * Markdown
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Markdown extends MarkupAbstract
{
    public function getFileName(string $file): string
    {
        return $file . '.md';
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Markdown($mapping, $this->normalizer);
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructDefinitionType $origin): string
    {
        $return = str_repeat('#', $this->heading) . ' ' . htmlspecialchars($name->getClass()) . "\n";
        $return.= '' . "\n";

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $return.= $comment . "\n";
            $return.= '' . "\n";
        }

        $return.= 'Field | Type | Description' . "\n";
        $return.= '----- | ---- | -----------' . "\n";

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $row = [
                $property->getName()->getProperty(),
                $property->getType(),
                $property->getComment(),
            ];

            $return.= implode(' | ', $row);
            $return.= "\n";
        }

        return $return;
    }

    protected function writeMap(Code\Name $name, string $type, MapDefinitionType $origin): string
    {
        $return = str_repeat('#', $this->heading) . ' ' . htmlspecialchars($name->getClass()) . "\n";
        $return.= '' . "\n";

        $return.= 'Field | Type | Description | Constraints' . "\n";
        $return.= '----- | ---- | ----------- | -----------' . "\n";

        $row = [
            '*',
            $type,
            '',
            '',
        ];

        $return.= implode(' | ', $row);
        $return.= "\n";

        return $return;
    }

    protected function writeConstraints(array $constraints)
    {
        $result = [];
        foreach ($constraints as $name => $constraint) {
            if (empty($constraint)) {
                continue;
            }

            if (is_scalar($constraint)) {
                $result[] = ucfirst($name) . ': `' . $constraint . '`';
            }
        }

        return implode(', ', $result);
    }
}
