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

namespace PSX\Schema;

/**
 * Describes a content type
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ContentType implements \Stringable, \JsonSerializable
{
    public const BINARY = 'application/octet-stream';
    public const FORM = 'application/x-www-form-urlencoded';
    public const JSON = 'application/json';
    public const MULTIPART = 'multipart/form-data';
    public const TEXT = 'text/plain';
    public const XML = 'application/xml';

    private string $type;

    public function __construct(string $contentType)
    {
        $this->type = strtolower($contentType);
    }

    /**
     * The shape is a specific content type which represents a complete group of content types
     * i.e. the shape of the content type "application/vnd.github.raw+json" is "application/json"
     * based on the shape we generate specific client or server code
     */
    public function getShape(): ?string
    {
        if ($this->isJson()) {
            return self::JSON;
        } elseif ($this->isXml()) {
            return self::XML;
        } elseif ($this->isForm()) {
            return self::FORM;
        } elseif ($this->isMultipart()) {
            return self::MULTIPART;
        } elseif ($this->isText()) {
            return self::TEXT;
        } else {
            return self::BINARY;
        }
    }

    public function toString(): string
    {
        return $this->type;
    }

    public function __toString(): string
    {
        return $this->type;
    }

    public function jsonSerialize(): mixed
    {
        return $this->type;
    }

    private function isForm(): bool
    {
        return $this->type === 'application/x-www-form-urlencoded';
    }

    private function isMultipart(): bool
    {
        return $this->type === 'multipart/form-data';
    }

    private function isText(): bool
    {
        return str_starts_with($this->type, 'text/');
    }

    private function isJson(): bool
    {
        return $this->type === 'application/json' || str_ends_with($this->type, '+json');
    }

    private function isXml(): bool
    {
        return $this->type === 'application/xml' || $this->type === 'text/xml' || str_ends_with($this->type, '+xml');
    }

    public static function from(string $value): static
    {
        return new static($value);
    }
}
