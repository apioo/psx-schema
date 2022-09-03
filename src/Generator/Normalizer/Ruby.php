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
 * Ruby
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Ruby extends NormalizerAbstract
{
    protected function getArgumentStyle(): int
    {
        return self::SNAKE_CASE;
    }

    protected function getPropertyStyle(): int
    {
        return self::SNAKE_CASE;
    }

    protected function getMethodStyle(): int
    {
        return self::SNAKE_CASE;
    }

    protected function getClassStyle(): int
    {
        return self::PASCAL_CASE;
    }

    protected function getFileStyle(): int
    {
        return self::SNAKE_CASE;
    }

    protected function getKeywords(): array
    {
        return [
            'begin',
            'end',
            'alias',
            'and',
            'break',
            'case',
            'class',
            'def',
            'module',
            'next',
            'nil',
            'not',
            'or',
            'redo',
            'rescue',
            'retry',
            'return',
            'elsif',
            'end',
            'false',
            'ensure',
            'for',
            'if',
            'true',
            'undef',
            'unless',
            'do',
            'else',
            'super',
            'then',
            'until',
            'when',
            'while',
            'defined',
            'self',
        ];
    }
}
