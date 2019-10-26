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

use PSX\Schema\Generator\Type\TypeInterface;

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
    protected function newType(): TypeInterface
    {
        return new Type\Markdown();
    }

    /**
     * @inheritDoc
     */
    protected function writeStruct(Code\Struct $struct): string
    {
        $return = '<a name="' . $struct->getName() . '"></a>' . "\n";
        $return.= str_repeat('#', $this->heading) . ' ' . $struct->getName() . "\n";
        $return.= '' . "\n";

        $comment = $struct->getComment();
        if (!empty($comment)) {
            $return.= $comment . "\n";
            $return.= '' . "\n";
        }

        $return.= 'Field | Type | Description | Constraints' . "\n";
        $return.= '----- | ---- | ----------- | -----------' . "\n";

        foreach ($struct->getProperties() as $name => $property) {
            /** @var Code\Property $property */
            $constraints = $this->getConstraints($property->getProperty());

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
    protected function writeMap(Code\Map $map): string
    {
        $return = '<a name="' . $map->getName() . '"></a>' . "\n";
        $return.= str_repeat('#', $this->heading) . ' ' . $map->getName() . "\n";
        $return.= '' . "\n";

        $comment = $map->getComment();
        if (!empty($comment)) {
            $return.= $comment . "\n";
            $return.= '' . "\n";
        }

        $return.= 'Field | Type | Description | Constraints' . "\n";
        $return.= '----- | ---- | ----------- | -----------' . "\n";

        $row = [
            '*',
            $map->getType(),
            $map->getComment(),
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
