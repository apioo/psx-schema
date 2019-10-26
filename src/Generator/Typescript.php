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
 * Typescript
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Typescript extends CodeGeneratorAbstract
{
    protected function newType(): TypeInterface
    {
        return new Type\Typescript();
    }

    protected function writeStruct(Code\Struct $struct): string
    {
        $code = '';

        $comment = $struct->getComment();
        if (!empty($comment)) {
            $code.= '/**' . "\n";
            $code.= ' * ' . $comment . "\n";
            $code.= ' */' . "\n";
        }

        $code.= 'interface ' . $struct->getName() . ' {' . "\n";

        foreach ($struct->getProperties() as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . $name . ($property->isRequired() ? '' : '?') . ': ' . $property->getType() . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(Code\Map $map): string
    {
        $code = '';

        $comment = $map->getComment();
        if (!empty($comment)) {
            $code.= '/**' . "\n";
            $code.= ' * ' . $comment . "\n";
            $code.= ' */' . "\n";
        }

        $code.= 'interface ' . $map->getName(). ' {' . "\n";
        $code.= $this->indent . '[index: string]: ' . $map->getType() . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    protected function normalizeName(string $name)
    {
        if (strpos($name, '-') !== false) {
            $name = '"' . $name . '"';
        }

        return $name;
    }
}
