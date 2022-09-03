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

namespace PSX\Schema\Generator\Normalizer;

/**
 * A generator can implement this interface if it has the ability to resolve a
 * type from a schema instance
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
interface NormalizerInterface
{
    public const TYPE_ARGUMENT = 1;
    public const TYPE_PROPERTY = 2;
    public const TYPE_METHOD = 3;
    public const TYPE_CLASS = 4;

    public const CAMEL_CASE = 1;
    public const PASCAL_CASE = 2;
    public const SNAKE_CASE = 3;

    public const METHOD_GETTER = 1;
    public const METHOD_SETTER = 2;

    public function argument(string $name): string;
    public function property(string $name): string;
    public function method(string $name, int $style): string;
    public function class(string $name): string;
    public function file(string $name): string;
}
