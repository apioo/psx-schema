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
use PSX\Schema\Type\StructType;

/**
 * Markdown
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Markdown extends MarkupAbstract
{
    /**
     * @inheritDoc
     */
    public function getFileName(string $file): string
    {
        return $file . '.md';
    }

    /**
     * @inheritDoc
     */
    protected function newTypeGenerator(): GeneratorInterface
    {
        return new Type\Markdown();
    }

    /**
     * @inheritDoc
     */
    protected function writeStruct(string $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $return = '<a name="' . htmlspecialchars($name) . '"></a>' . "\n";
        $return.= str_repeat('#', $this->heading) . ' ' . htmlspecialchars($name) . "\n";
        $return.= '' . "\n";

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $return.= $comment . "\n";
            $return.= '' . "\n";
        }

        $return.= 'Field | Type | Description | Constraints' . "\n";
        $return.= '----- | ---- | ----------- | -----------' . "\n";

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $constraints = $this->getConstraints($property->getOrigin());

            $row = [
                $name,
                $property->getType(),
                ($property->isRequired() ? '**REQUIRED**. ' : '') . $property->getComment(),
                !empty($constraints) ? $this->writeConstraints($constraints) : '',
            ];

            $return.= implode(' | ', $row);
            $return.= "\n";
        }

        return $return;
    }

    /**
     * @inheritDoc
     */
    protected function writeMap(string $name, string $type, MapType $origin): string
    {
        $return = '<a name="' . htmlspecialchars($name) . '"></a>' . "\n";
        $return.= str_repeat('#', $this->heading) . ' ' . htmlspecialchars($name) . "\n";
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
