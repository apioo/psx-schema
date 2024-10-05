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
 * Rust
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Rust extends GeneratorAbstract
{
    public function getContentType(ContentType $contentType, int $context): string
    {
        return match ($contentType->getShape()) {
            ContentType::BINARY => 'Bytes',
            ContentType::FORM => 'HashMap<string, string>',
            ContentType::JSON => 'serde_json::Value',
            ContentType::MULTIPART => $this->getString(),
            ContentType::TEXT, ContentType::XML => $this->getString(),
        };
    }

    protected function getString(): string
    {
        return 'String';
    }

    protected function getStringFormat(Format $format): string
    {
        return match ($format) {
            Format::DATE => 'chrono::NaiveDate',
            Format::DATETIME => 'chrono::NaiveDateTime',
            Format::TIME => 'chrono::NaiveTime',
            default => $this->getString(),
        };
    }

    protected function getInteger(): string
    {
        return 'u64';
    }

    protected function getNumber(): string
    {
        return 'f64';
    }

    protected function getBoolean(): string
    {
        return 'bool';
    }

    protected function getArray(string $type): string
    {
        return 'Vec<' . $type . '>';
    }

    protected function getMap(string $type): string
    {
        return 'HashMap<String, ' . $type . '>';
    }

    protected function getGroup(string $type): string
    {
        return '(' . $type . ')';
    }

    protected function getGeneric(array $types): string
    {
        return '';
    }

    protected function getAny(): string
    {
        return 'serde_json::Value';
    }

    protected function getNamespaced(string $namespace, string $name): string
    {
        return $namespace . '::' . $name;
    }
}
