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
 * Protobuf
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Protobuf extends GeneratorAbstract
{
    public function getGenericDefinition(array $types): string
    {
        return '';
    }

    protected function getString(): string
    {
        return 'string';
    }

    protected function getStringFormat(Format $format): string
    {
        return match ($format) {
            Format::DATE => 'Timestamp',
            Format::DATETIME => 'Timestamp',
            default => $this->getString(),
        };
    }

    protected function getInteger(): string
    {
        return 'int64';
    }

    protected function getNumber(): string
    {
        return 'float';
    }

    protected function getBoolean(): string
    {
        return 'bool';
    }

    protected function getArray(string $type): string
    {
        return 'repeated ' . $type;
    }

    protected function getMap(string $type): string
    {
        return 'map<string, ' . $type . '>';
    }

    protected function getGroup(string $type): string
    {
        return '(' . $type . ')';
    }

    protected function getAny(): string
    {
        return 'Any';
    }

    protected function getNamespaced(string $namespace, string $name): string
    {
        return $namespace . '.' . $name;
    }
}
