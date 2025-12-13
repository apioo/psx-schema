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

use PSX\Schema\Exception\InvalidSchemaException;

/**
 * SchemaSource
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class SchemaSource
{
    private function __construct(private string $scheme, private string $source)
    {
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function __toString(): string
    {
        return $this->scheme . '://' . $this->source;
    }

    /**
     * @throws InvalidSchemaException
     */
    public static function fromFile(string $file): self
    {
        if (!is_file($file)) {
            throw new InvalidSchemaException('Provided file does not exist');
        }

        return new self('file', $file);
    }

    /**
     * @throws InvalidSchemaException
     */
    public static function fromUrl(string $url): self
    {
        if (str_starts_with($url, 'http://')) {
            return new self('http', substr($url, 7));
        } elseif (str_starts_with($url, 'https://')) {
            return new self('https', substr($url, 8));
        } else {
            throw new InvalidSchemaException('Provided url must start with either http:// or https://');
        }
    }

    /**
     * @throws InvalidSchemaException
     */
    public static function fromClass(string $class): self
    {
        if (!class_exists($class)) {
            throw new InvalidSchemaException('Provided class does not exist');
        }

        return new self('php+class', str_replace('\\', '.', $class));
    }

    /**
     * A PHP doc type i.e. array<string>
     */
    public static function fromType(string $type, ?string $namespace = null): self
    {
        return new self('php+doc', $type . (!empty($namespace) ? '@' . $namespace : ''));
    }

    public static function fromTypeHub(string $user, string $document, string $version): self
    {
        return new self('typehub', $user . ':' . $document . '@' . $version);
    }

    /**
     * @throws InvalidSchemaException
     */
    public static function fromString(string $source): self
    {
        $pos = strpos($source, '://');
        if ($pos === false) {
            $source = self::guessSchemeFromSchemaName($source);
            $pos = strpos($source, '://');
        }

        if ($pos === false) {
            throw new InvalidSchemaException('Could not resolve schema uri');
        }

        $scheme = substr($source, 0, $pos);
        $value = substr($source, $pos + 3);

        return new self($scheme, $value);
    }

    private static function guessSchemeFromSchemaName(string $source): string
    {
        if (class_exists($source)) {
            if (in_array(SchemaInterface::class, class_implements($source))) {
                return 'php+schema://' . str_replace('\\', '.', $source);
            } else {
                return 'php+class://' . str_replace('\\', '.', $source);
            }
        } elseif (str_contains($source, '<')) {
            return 'php+doc://' . $source;
        } elseif (is_file($source)) {
            return 'file://' . $source;
        } else {
            return $source;
        }
    }
}
