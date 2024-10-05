<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * Ruby
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Ruby extends GeneratorAbstract
{
    protected function getString(): string
    {
        return '';
    }

    protected function getInteger(): string
    {
        return '';
    }

    protected function getNumber(): string
    {
        return '';
    }

    protected function getBoolean(): string
    {
        return '';
    }

    protected function getArray(string $type): string
    {
        return '';
    }

    protected function getMap(string $type): string
    {
        return '';
    }

    protected function getGroup(string $type): string
    {
        return '(' . $type . ')';
    }

    protected function getGeneric(array $types): string
    {
        return '';
    }

    protected function getAny(): string
    {
        return '';
    }

    protected function getNamespaced(string $namespace, string $name): string
    {
        return $namespace . '::' . $name;
    }
}
