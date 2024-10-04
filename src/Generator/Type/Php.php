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

use Psr\Http\Message\StreamInterface;
use PSX\DateTime\LocalDate;
use PSX\DateTime\LocalDateTime;
use PSX\DateTime\LocalTime;
use PSX\Record\Record;
use PSX\Schema\ContentType;
use PSX\Schema\Format;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\GenericPropertyType;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\TypeInterface;

/**
 * Php
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Php extends GeneratorAbstract
{
    public function getDocType(TypeInterface $type): string
    {
        if ($type instanceof ArrayPropertyType) {
            $items = $type->getItems();
            if ($items instanceof TypeInterface) {
                return 'array<' . $this->getDocType($items) . '>';
            } else {
                return 'array';
            }
        } elseif ($type instanceof MapDefinitionType) {
            $additionalProperties = $type->getAdditionalProperties();
            if ($additionalProperties instanceof TypeInterface) {
                return '\\' . Record::class . '<' . $this->getDocType($additionalProperties) . '>';
            } else {
                return '\\' . Record::class;
            }
        } elseif ($type instanceof StringPropertyType && $type->getFormat() === Format::BINARY) {
            return 'resource';
        } elseif ($type instanceof GenericPropertyType) {
            return $type->getGeneric() ?? '';
        } else {
            return $this->getType($type);
        }
    }

    public function getContentType(ContentType $contentType, int $context): string
    {
        return match ($contentType->getShape()) {
            ContentType::BINARY => '\\' . StreamInterface::class,
            ContentType::FORM => $context & self::CONTEXT_CLIENT ? 'array' : '\\PSX\\Data\\Body\\Form',
            ContentType::JSON => $context & self::CONTEXT_CLIENT ? 'mixed' : '\\PSX\\Data\\Body\\Json',
            ContentType::MULTIPART => $context & self::CONTEXT_CLIENT ? '\\Sdkgen\\Client\\Multipart' : '\\PSX\\Data\\Body\\Multipart',
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
            Format::DATE => '\\' . LocalDate::class,
            Format::DATETIME => '\\' . LocalDateTime::class,
            Format::TIME => '\\' . LocalTime::class,
            default => $this->getString(),
        };
    }

    protected function getInteger(): string
    {
        return 'int';
    }

    protected function getNumber(): string
    {
        return 'float';
    }

    protected function getBoolean(): string
    {
        return 'bool';
    }

    protected function getArray(string $type): string
    {
        return 'array';
    }

    protected function getMap(string $type): string
    {
        return '\\' . Record::class;
    }

    protected function getUnion(array $types): string
    {
        return implode('|', $types);
    }

    protected function getIntersection(array $types): string
    {
        return implode('&', $types);
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
        return 'mixed';
    }

    protected function getNamespaced(string $namespace, string $name): string
    {
        return '\\' . $namespace . '\\' . $name;
    }
}
