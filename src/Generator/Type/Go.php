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
 * Go
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Go extends GeneratorAbstract
{
    public function getContentType(ContentType $contentType, int $context): string
    {
        return match ($contentType->getShape()) {
            ContentType::BINARY => '[]byte',
            ContentType::FORM => 'url.Values',
            ContentType::JSON => 'any',
            ContentType::MULTIPART => 'map[string]any',
            ContentType::TEXT, ContentType::XML => $this->getString(),
        };
    }

    protected function getString(): string
    {
        return 'string';
    }

    protected function getInteger(): string
    {
        return 'int';
    }

    protected function getIntegerFormat(Format $format): string
    {
        return match ($format) {
            Format::INT32 => 'int32',
            Format::INT64 => 'int64',
            default => $this->getInteger(),
        };
    }

    protected function getNumber(): string
    {
        return 'float64';
    }

    protected function getBoolean(): string
    {
        return 'bool';
    }

    protected function getArray(string $type): string
    {
        return '[]' . $type;
    }

    protected function getMap(string $type): string
    {
        return 'map[string]' . $type;
    }

    protected function getUnion(array $types): string
    {
        return 'any';
    }

    protected function getIntersection(array $types): string
    {
        return 'any';
    }

    protected function getGroup(string $type): string
    {
        return '(' . $type . ')';
    }

    protected function getGeneric(array $types): string
    {
        return '[' . implode(', ', $types) . ']';
    }

    protected function getAny(): string
    {
        return 'any';
    }

    protected function getNamespaced(string $namespace, string $name): string
    {
        return $namespace . '.' . $name;
    }
}
