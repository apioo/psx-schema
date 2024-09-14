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
 * Kotlin
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Kotlin extends GeneratorAbstract
{
    public function getContentType(ContentType $contentType): string
    {
        return match ($contentType) {
            ContentType::BINARY => 'ByteArray',
            ContentType::FORM => 'Map<string, string>',
            ContentType::JSON => 'Object',
            ContentType::MULTIPART => 'org.apache.hc.client5.http.entity.mime.MultipartEntityBuilder',
            ContentType::TEXT => $this->getString(),
            ContentType::XML => 'XMLDocument',
        };
    }

    protected function getString(): string
    {
        return 'String';
    }

    protected function getStringFormat(Format $format): string
    {
        return match ($format) {
            Format::DATE => 'java.time.LocalDate',
            Format::DATETIME => 'java.time.LocalDateTime',
            Format::TIME => 'java.time.LocalTime',
            default => $this->getString(),
        };
    }

    protected function getInteger(): string
    {
        return 'Int';
    }

    protected function getIntegerFormat(Format $format): string
    {
        return match ($format) {
            Format::INT32 => 'Int',
            Format::INT64 => 'Long',
            default => $this->getInteger(),
        };
    }

    protected function getNumber(): string
    {
        return 'Float';
    }

    protected function getBoolean(): string
    {
        return 'Boolean';
    }

    protected function getArray(string $type): string
    {
        return 'Array<' . $type . '>';
    }

    protected function getMap(string $type): string
    {
        return 'Map<String, ' . $type . '>';
    }

    protected function getUnion(array $types): string
    {
        return 'Any';
    }

    protected function getIntersection(array $types): string
    {
        return 'Any';
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
        return 'Any';
    }

    protected function getNamespaced(string $namespace, string $name): string
    {
        return $namespace . '.' . $name;
    }
}
