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
 * CSharp
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class CSharp extends NormalizerAbstract
{
    protected function getPropertyStyle(): int
    {
        return self::PASCAL_CASE;
    }

    protected function hasPropertyReserved(): bool
    {
        return false;
    }

    protected function getKeywords(): array
    {
        return [
            'abstract',
            'as',
            'base',
            'bool',
            'break',
            'byte',
            'case',
            'catch',
            'char',
            'checked',
            'class',
            'const',
            'continue',
            'decimal',
            'default',
            'delegate',
            'do',
            'double',
            'else',
            'enum',
            'event',
            'explicit',
            'extern',
            'false',
            'finally',
            'fixed',
            'float',
            'for',
            'foreach',
            'goto',
            'if',
            'implicit',
            'in',
            'int',
            'interface',
            'internal',
            'is',
            'lock',
            'long',
            'namespace',
            'new',
            'null',
            'object',
            'operator',
            'out',
            'override',
            'params',
            'private',
            'protected',
            'public',
            'readonly',
            'ref',
            'return',
            'sbyte',
            'sealed',
            'short',
            'sizeof',
            'stackalloc',
            'static',
            'string',
            'struct',
            'switch',
            'this',
            'throw',
            'true',
            'try',
            'typeof',
            'uint',
            'ulong',
            'unchecked',
            'unsafe',
            'ushort',
            'using',
            'virtual',
            'void',
            'volatile',
            'while',
        ];
    }
}
