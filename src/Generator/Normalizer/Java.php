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

namespace PSX\Schema\Generator\Normalizer;

/**
 * Java
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Java extends NormalizerAbstract
{
    public function method(string... $name): string
    {
        $name = parent::method(...$name);
        if ($name === 'getClass') {
            // getClass is the only reserved getter at the Object
            $name = 'get_Class';
        }

        return $name;
    }

    protected function getKeywords(): array
    {
        return [
            'abstract',
            'assert',
            'boolean',
            'break',
            'byte',
            'case',
            'catch',
            'char',
            'class',
            'const',
            'continue',
            'default',
            'double',
            'do',
            'else',
            'enum',
            'extends',
            'false',
            'final',
            'finally',
            'float',
            'for',
            'goto',
            'if',
            'implements',
            'import',
            'instanceof',
            'int',
            'interface',
            'long',
            'native',
            'new',
            'null',
            'package',
            'private',
            'protected',
            'public',
            'return',
            'short',
            'static',
            'strictfp',
            'super',
            'switch',
            'synchronized',
            'this',
            'throw',
            'throws',
            'transient',
            'true',
            'try',
            'void',
            'volatile',
            'while',
        ];
    }

    public function comment(string $comment): string
    {
        return str_replace('"', '\\"', $comment);
    }
}
