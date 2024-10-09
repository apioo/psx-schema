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

namespace PSX\Schema\Generator\Type;

use PSX\Schema\Format;

/**
 * MarkupAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class MarkupAbstract extends GeneratorAbstract
{
    public function getGenericDefinition(array $types): string
    {
        return '<' . implode(', ', $types) . '>';
    }

    protected function getString(): string
    {
        return 'String';
    }

    protected function getStringFormat(Format $format): string
    {
        return 'String (' . $format->value . ')';
    }

    protected function getInteger(): string
    {
        return 'Integer';
    }

    protected function getIntegerFormat(Format $format): string
    {
        return 'Integer (' . $format->value . ')';
    }

    protected function getNumber(): string
    {
        return 'Number';
    }

    protected function getBoolean(): string
    {
        return 'Boolean';
    }

    protected function getArray(string $type): string
    {
        return 'Array (' . $type . ')';
    }

    protected function getStruct(string $type): string
    {
        return $type;
    }

    protected function getMap(string $type): string
    {
        return 'Map (' . $type . ')';
    }

    protected function getGroup(string $type): string
    {
        return '(' . $type . ')';
    }

    protected function getReference(string $ref): string
    {
        return $ref;
    }

    protected function getAny(): string
    {
        return 'Any';
    }

    protected function getNamespaced(string $namespace, string $name): string
    {
        return $namespace . '.' . $name;
    }

    /**
     * @param string $name
     * @return string
     */
    abstract protected function escape(string $name): string;
}
