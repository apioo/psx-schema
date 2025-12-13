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
    public function getContentType(ContentType $contentType, int $context): string
    {
        return match ($contentType->getShape()) {
            ContentType::BINARY => 'java.io.InputStream',
            ContentType::FORM => $context & self::CONTEXT_CLIENT ? 'java.util.List<org.apache.hc.core5.http.NameValuePair>' : 'org.springframework.util.MultiValueMap<String, String>',
            ContentType::JSON => $context & self::CONTEXT_CLIENT ? 'Object' : 'String',
            ContentType::MULTIPART => $context & self::CONTEXT_CLIENT ? 'org.apache.hc.client5.http.entity.mime.MultipartEntityBuilder' : 'reactor.core.publisher.Mono<org.springframework.util.MultiValueMap<String, org.springframework.http.codec.multipart.Part>>',
            default => $this->getString(),
        };
    }

    public function getGenericDefinition(array $types): string
    {
        return '<' . implode(', ', $types) . '>';
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
        };
    }

    protected function getInteger(): string
    {
        return 'Int';
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
        return 'ArrayList<' . $type . '>';
    }

    protected function getMap(string $type): string
    {
        return 'HashMap<String, ' . $type . '>';
    }

    protected function getGroup(string $type): string
    {
        return '(' . $type . ')';
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
