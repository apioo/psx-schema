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
 * Java
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Java extends GeneratorAbstract
{
    public function getContentType(ContentType $contentType, int $context): string
    {
        return match ($contentType) {
            ContentType::BINARY => 'java.io.InputStream',
            ContentType::FORM => $context & self::CONTEXT_CLIENT ? 'java.util.Map<String, String>' : 'org.springframework.util.MultiValueMap<String, String>',
            ContentType::JSON => $context & self::CONTEXT_CLIENT ? 'Object' : 'String',
            ContentType::MULTIPART => $context & self::CONTEXT_CLIENT ? 'org.apache.hc.client5.http.entity.mime.MultipartEntityBuilder' : 'reactor.core.publisher.Mono<org.springframework.util.MultiValueMap<String, org.springframework.http.codec.multipart.Part>>',
            ContentType::TEXT => $this->getString(),
            ContentType::XML => 'org.w3c.dom.Document',
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
        return 'Integer';
    }

    protected function getIntegerFormat(Format $format): string
    {
        return match ($format) {
            Format::INT32 => 'Integer',
            Format::INT64 => 'Long',
            default => $this->getInteger(),
        };
    }

    protected function getNumber(): string
    {
        return 'Double';
    }

    protected function getBoolean(): string
    {
        return 'Boolean';
    }

    protected function getArray(string $type): string
    {
        return 'java.util.List<' . $type . '>';
    }

    protected function getMap(string $type): string
    {
        return 'java.util.Map<String, ' . $type . '>';
    }

    protected function getUnion(array $types): string
    {
        return 'Object';
    }

    protected function getIntersection(array $types): string
    {
        return 'Object';
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
        return 'Object';
    }

    protected function getNamespaced(string $namespace, string $name): string
    {
        return $namespace . '.' . $name;
    }
}
