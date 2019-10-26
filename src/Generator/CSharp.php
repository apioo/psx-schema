<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * CSharp
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class CSharp extends CodeGeneratorAbstract
{
    /**
     * @inheritDoc
     */
    protected function newType(): TypeInterface
    {
        return new Type\CSharp();
    }

    /**
     * @inheritDoc
     */
    protected function writeStruct(Code\Struct $struct): string
    {
        $code = '';

        $comment = $struct->getComment();
        if (!empty($comment)) {
            $code.= '/// <summary>' . "\n";
            $code.= '/// ' . $comment . "\n";
            $code.= '/// </summary>' . "\n";
        }

        $code.= 'public class ' . $struct->getName() . "\n";
        $code.= '{' . "\n";

        foreach ($struct->getProperties() as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . 'public ' . $property->getType() . ' ' . ucfirst($name) . ' { get; set; }' . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    /**
     * @inheritDoc
     */
    protected function writeMap(Code\Map $map): string
    {
        $code = 'public class ' . $map->getName() . ' : Dictionary<string, ' . $map->getType() . '>' . "\n";
        $code.= '{' . "\n";
        $code.= '}' . "\n";

        return $code;
    }
}
