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
 * Java
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Java extends CodeGeneratorAbstract
{
    /**
     * @inheritDoc
     */
    protected function newType(): TypeInterface
    {
        return new Type\Java();
    }

    /**
     * @inheritDoc
     */
    protected function writeStruct(Code\Struct $struct): string
    {
        $code = $this->writeHeader($struct->getComment());
        $code.= 'public static class ' . $struct->getName() . ' {' . "\n";

        foreach ($struct->getProperties() as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . 'private ' . $property->getType() . ' ' . $name . ';' . "\n";
        }

        foreach ($struct->getProperties() as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . 'public void set' . ucfirst($name) . '(' . $property->getType() . ' ' . $name . ') {' . "\n";
            $code.= $this->indent . $this->indent . 'this.' . $name . ' = ' . $name . ';' . "\n";
            $code.= $this->indent . '}' . "\n";

            $code.= $this->indent . 'public ' . $property->getType() . ' get' . ucfirst($name) . '() {' . "\n";
            $code.= $this->indent . $this->indent . 'return this.' . $name . ';' . "\n";
            $code.= $this->indent . '}' . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    /**
     * @inheritDoc
     */
    protected function writeMap(Code\Map $map): string
    {
        $code = $this->writeHeader($map->getComment());
        $code.= 'public static class ' . $map->getName() . ' extends HashMap<String, ' . $map->getType() . '> {' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    private function writeHeader(?string $comment)
    {
        $code = '';

        if (!empty($this->namespace)) {
            $code.= 'package ' . $this->namespace . ';' . "\n";
        }

        if (!empty($comment)) {
            $code.= '/**' . "\n";
            $code.= ' * ' . $comment . "\n";
            $code.= ' */' . "\n";
        }

        return $code;
    }
}
