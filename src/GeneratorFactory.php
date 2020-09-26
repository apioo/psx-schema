<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * @link    http://phpsx.org
 */
class GeneratorFactory
{
    const TYPE_CSHARP = 'csharp';
    const TYPE_GO = 'go';
    const TYPE_HTML = 'html';
    const TYPE_JAVA = 'java';
    const TYPE_JSONSCHEMA = 'jsonschema';
    const TYPE_MARKDOWN = 'markdown';
    const TYPE_PHP = 'php';
    const TYPE_PROTOBUF = 'protobuf';
    const TYPE_PYTHON = 'python';
    const TYPE_SWIFT = 'swift';
    const TYPE_TYPESCHEMA = 'typeschema';
    const TYPE_TYPESCRIPT = 'typescript';

    /**
     * @param string $format
     * @param string $config
     * @return \PSX\Schema\GeneratorInterface
     */
    public function getGenerator(string $format, ?string $config = null)
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

            case self::TYPE_HTML:
                return new Generator\Html((int) $heading, $prefix);

            case self::TYPE_JAVA:
                return new Generator\Java($namespace, $mapping, $indent);

            case self::TYPE_JSONSCHEMA:
                return new Generator\JsonSchema();

            case self::TYPE_MARKDOWN:
                return new Generator\Markdown((int) $heading, $prefix);

            case self::TYPE_PHP:
                return new Generator\Php($namespace, $mapping, $indent);

            case self::TYPE_PROTOBUF:
                return new Generator\Protobuf($namespace, $mapping, $indent);

            case self::TYPE_PYTHON:
                return new Generator\Python($namespace, $mapping, $indent);

            case self::TYPE_SWIFT:
                return new Generator\Swift($namespace, $mapping, $indent);

            case self::TYPE_TYPESCRIPT:
                return new Generator\TypeScript($namespace, $mapping, $indent);

            default:
            case self::TYPE_TYPESCHEMA:
                return new Generator\TypeSchema();
        }
    }

    /**
     * @return array
     */
    public static function getPossibleTypes()
    {
        return [
            self::TYPE_CSHARP,
            self::TYPE_GO,
            self::TYPE_HTML,
            self::TYPE_JAVA,
            self::TYPE_JSONSCHEMA,
            self::TYPE_MARKDOWN,
            self::TYPE_PHP,
            self::TYPE_PROTOBUF,
            self::TYPE_PYTHON,
            self::TYPE_SWIFT,
            self::TYPE_TYPESCRIPT,
            self::TYPE_TYPESCHEMA,
        ];
    }
}
