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

    public function getGenerator(string $format, ?string $config = null): GeneratorInterface
    {
        $result = [];
        parse_str($config ?? '', $result);
        $namespace = $result['namespace'] ?? null;
        $mapping = $result['mapping'] ?? [];
        $indent = $result['indent'] ?? 4;
        $heading = $result['heading'] ?? 1;
        $prefix = $result['prefix'] ?? 'psx_model_';

        switch ($format) {
            case self::TYPE_CSHARP:
                return new Generator\CSharp($namespace, $mapping, $indent);

            case self::TYPE_GO:
                return new Generator\Go($namespace, $mapping, $indent);

            case self::TYPE_GRAPHQL:
                return new Generator\GraphQL($namespace, $mapping, $indent);

            case self::TYPE_HTML:
                return new Generator\Html((int) $heading, $prefix);

            case self::TYPE_JAVA:
                return new Generator\Java($namespace, $mapping, $indent);

            case self::TYPE_JSONSCHEMA:
                return new Generator\JsonSchema();

            case self::TYPE_KOTLIN:
                return new Generator\Kotlin($namespace, $mapping, $indent);

            case self::TYPE_MARKDOWN:
                return new Generator\Markdown((int) $heading, $prefix);

            case self::TYPE_PHP:
                return new Generator\Php($namespace, $mapping, $indent);

            case self::TYPE_PROTOBUF:
                return new Generator\Protobuf($namespace, $mapping, $indent);

            case self::TYPE_PYTHON:
                return new Generator\Python($namespace, $mapping, $indent);

            case self::TYPE_RUBY:
                return new Generator\Ruby($namespace, $mapping, $indent);

            case self::TYPE_RUST:
                return new Generator\Rust($namespace, $mapping, $indent);

            case self::TYPE_SWIFT:
                return new Generator\Swift($namespace, $mapping, $indent);

            case self::TYPE_TYPESCRIPT:
                return new Generator\TypeScript($namespace, $mapping, $indent);

            case self::TYPE_VISUALBASIC:
                return new Generator\VisualBasic($namespace, $mapping, $indent);

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
