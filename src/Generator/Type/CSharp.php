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

use PSX\Schema\ContentType;
use PSX\Schema\Format;

/**
 * CSharp
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class CSharp extends GeneratorAbstract
{
    public function getContentType(ContentType $contentType, int $context): string
    {
        return match ($contentType->getShape()) {
            ContentType::BINARY => 'byte[]',
            ContentType::FORM => 'System.Collections.Specialized.NameValueCollection',
            ContentType::JSON => 'object',
            ContentType::MULTIPART => 'System.Collections.Generic.Dictionary<string, string>',
            ContentType::TEXT, ContentType::XML => $this->getString(),
        };
    }

    protected function getString(): string
    {
        return 'string';
    }

    protected function getStringFormat(Format $format): string
    {
        return match ($format) {
            Format::DATE => 'System.DateOnly',
            Format::DATETIME => 'System.DateTime',
            Format::TIME => 'System.TimeOnly',
            default => $this->getString(),
        };
    }

    protected function getInteger(): string
    {
        return 'int';
    }

    protected function getIntegerFormat(Format $format): string
    {
        return match ($format) {
            Format::INT32 => 'int',
            Format::INT64 => 'long',
            default => $this->getInteger(),
        };
    }

    protected function getNumber(): string
    {
        return 'double';
    }

    protected function getBoolean(): string
    {
        return 'bool';
    }

    protected function getArray(string $type): string
    {
        return 'System.Collections.Generic.List<' . $type . '>';
    }

    protected function getMap(string $type): string
    {
        return 'System.Collections.Generic.Dictionary<string, ' . $type . '>';
    }

    protected function getUnion(array $types): string
    {
        return 'object';
    }

    protected function getIntersection(array $types): string
    {
        return 'object';
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
        return 'object';
    }

    protected function getNamespaced(string $namespace, string $name): string
    {
        return $namespace . '.' . $name;
    }
}
