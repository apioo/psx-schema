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

use PSX\DateTime\Duration;
use PSX\DateTime\LocalDate;
use PSX\DateTime\LocalDateTime;
use PSX\DateTime\LocalTime;
use PSX\DateTime\Period;
use PSX\Record\Record;
use PSX\Schema\Format;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\GenericType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\StringType;
use PSX\Schema\TypeInterface;
use PSX\Uri\Uri;

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
        if ($type instanceof ArrayType) {
            $items = $type->getItems();
            if ($items instanceof TypeInterface) {
                return 'array<' . $this->getDocType($items) . '>';
            } else {
                return 'array';
            }
        } elseif ($type instanceof MapType) {
            $additionalProperties = $type->getAdditionalProperties();
            if ($additionalProperties instanceof TypeInterface) {
                return '\\' . Record::class . '<' . $this->getDocType($additionalProperties) . '>';
            } else {
                return '\\' . Record::class;
            }
        } elseif ($type instanceof StringType && $type->getFormat() === Format::BINARY) {
            return 'resource';
        } elseif ($type instanceof IntersectionType) {
            $parts = [];
            foreach ($type->getAllOf() as $item) {
                $parts[] = $this->getDocType($item);
            }
            return implode('&', $parts);
        } elseif ($type instanceof GenericType) {
            return $type->getGeneric() ?? '';
        } else {
            return $this->getType($type);
        }
    }

    protected function getDate(): string
    {
        return '\\' . LocalDate::class;
    }

    protected function getDateTime(): string
    {
        return '\\' . LocalDateTime::class;
    }

    protected function getTime(): string
    {
        return '\\' . LocalTime::class;
    }

    protected function getPeriod(): string
    {
        return '\\' . Period::class;
    }

    protected function getDuration(): string
    {
        return '\\' . Duration::class;
    }

    protected function getUri(): string
    {
        return '\\' . Uri::class;
    }

    protected function getBinary(): string
    {
        return '';
    }

    protected function getString(): string
    {
        return 'string';
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
        return '';
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
