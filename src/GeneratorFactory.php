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

namespace PSX\Schema;

use PSX\Schema\Generator\Config;

/**
 * GeneratorFactory
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class GeneratorFactory
{
    public const TYPE_CSHARP = 'csharp';
    public const TYPE_GO = 'go';
    public const TYPE_GRAPHQL = 'graphql';
    public const TYPE_HTML = 'html';
    public const TYPE_JAVA = 'java';
    public const TYPE_JSONSCHEMA = 'jsonschema';
    public const TYPE_KOTLIN = 'kotlin';
    public const TYPE_MARKDOWN = 'markdown';
    public const TYPE_PHP = 'php';
    public const TYPE_PROTOBUF = 'protobuf';
    public const TYPE_PYTHON = 'python';
    public const TYPE_RUBY = 'ruby';
    public const TYPE_RUST = 'rust';
    public const TYPE_SWIFT = 'swift';
    public const TYPE_TYPESCHEMA = 'typeschema';
    public const TYPE_TYPESCRIPT = 'typescript';
    public const TYPE_VISUALBASIC = 'visualbasic';

    public function getGenerator(string $format, ?Config $config = null): GeneratorInterface
    {
        switch ($format) {
            case self::TYPE_CSHARP:
                return new Generator\CSharp($config);

            case self::TYPE_GO:
                return new Generator\Go($config);

            case self::TYPE_GRAPHQL:
                return new Generator\GraphQL($config);

            case self::TYPE_HTML:
                return new Generator\Html($config);

            case self::TYPE_JAVA:
                return new Generator\Java($config);

            case self::TYPE_JSONSCHEMA:
                return new Generator\JsonSchema($config);

            case self::TYPE_KOTLIN:
                return new Generator\Kotlin($config);

            case self::TYPE_MARKDOWN:
                return new Generator\Markdown($config);

            case self::TYPE_PHP:
                return new Generator\Php($config);

            case self::TYPE_PROTOBUF:
                return new Generator\Protobuf($config);

            case self::TYPE_PYTHON:
                return new Generator\Python($config);

            case self::TYPE_RUBY:
                return new Generator\Ruby($config);

            case self::TYPE_RUST:
                return new Generator\Rust($config);

            case self::TYPE_SWIFT:
                return new Generator\Swift($config);

            case self::TYPE_TYPESCRIPT:
                return new Generator\TypeScript($config);

            case self::TYPE_VISUALBASIC:
                return new Generator\VisualBasic($config);

            default:
            case self::TYPE_TYPESCHEMA:
                return new Generator\TypeSchema();
        }
    }

    public static function getPossibleTypes(): array
    {
        return [
            self::TYPE_CSHARP,
            self::TYPE_GO,
            self::TYPE_GRAPHQL,
            self::TYPE_HTML,
            self::TYPE_JAVA,
            self::TYPE_JSONSCHEMA,
            self::TYPE_KOTLIN,
            self::TYPE_MARKDOWN,
            self::TYPE_PHP,
            self::TYPE_PROTOBUF,
            self::TYPE_PYTHON,
            self::TYPE_RUBY,
            self::TYPE_RUST,
            self::TYPE_SWIFT,
            self::TYPE_TYPESCRIPT,
            self::TYPE_TYPESCHEMA,
            self::TYPE_VISUALBASIC,
        ];
    }
}
