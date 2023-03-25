<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

/**
 * Java
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Java extends GeneratorAbstract
{
    protected function getDate(): string
    {
        return 'LocalDate';
    }

    protected function getDateTime(): string
    {
        return 'LocalDateTime';
    }

    protected function getTime(): string
    {
        return 'LocalTime';
    }

    protected function getPeriod(): string
    {
        return 'Period';
    }

    protected function getDuration(): string
    {
        return 'Duration';
    }

    protected function getUri(): string
    {
        return 'URI';
    }

    protected function getBinary(): string
    {
        return 'byte[]';
    }

    protected function getString(): string
    {
        return 'String';
    }

    protected function getInteger(): string
    {
        return 'int';
    }

    protected function getNumber(): string
    {
        return 'double';
    }

    protected function getBoolean(): string
    {
        return 'boolean';
    }

    protected function getArray(string $type): string
    {
        return $type . '[]';
    }

    protected function getMap(string $type): string
    {
        return 'HashMap<String, ' . $type . '>';
    }

    protected function getUnion(array $types): string
    {
        return 'Object';
    }

    protected function getIntersection(array $types): string
    {
        return 'Object';
    }

    protected function getGroup(string $type): string
    {
        return '(' . $type . ')';
    }

    protected function getGeneric(array $types): string
    {
        return '<' . implode(', ', $types) . '>';
    }

    protected function getAny(): string
    {
        return 'Object';
    }

    protected function getNamespaced(string $namespace, string $name): string
    {
        return $namespace . '.' . $name;
    }
}
