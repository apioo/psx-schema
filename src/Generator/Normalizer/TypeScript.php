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

namespace PSX\Schema\Generator\Normalizer;

/**
 * TypeScript
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TypeScript extends NormalizerAbstract
{
    public function import(string $name, ?string $namespace = null): string
    {
        if (!empty($namespace)) {
            return $namespace . '/' . $this->file($name);
        } else {
            return $this->file($name);
        }
    }

    protected function hasPropertyReserved(): bool
    {
        return false;
    }

    protected function hasMethodReserved(): bool
    {
        return false;
    }

    protected function getKeywords(): array
    {
        return [
            'break',
            'case',
            'catch',
            'class',
            'const',
            'continue',
            'debugger',
            'default',
            'delete',
            'do',
            'else',
            'enum',
            'export',
            'extends',
            'false',
            'finally',
            'for',
            'function',
            'if',
            'import',
            'in',
            'instanceof',
            'new',
            'null',
            'return',
            'super',
            'switch',
            'this',
            'throw',
            'true',
            'try',
            'typeof',
            'var',
            'void',
            'while',
            'with',
        ];
    }
}
