<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\DateTime\Date;
use PSX\DateTime\Time;
use PSX\Schema\Type\GenericType;
use PSX\Schema\Type\StringType;
use PSX\Schema\TypeInterface;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\UnionType;
use PSX\Uri\Uri;
use PSX\Schema\Type\TypeAbstract;

/**
 * Php
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
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
                return 'array<string, ' . $this->getDocType($additionalProperties) . '>';
            } else {
                return 'array';
            }
        } elseif ($type instanceof StringType && $type->getFormat() === TypeAbstract::FORMAT_BINARY) {
            return 'resource';
        } elseif ($type instanceof UnionType) {
            $parts = [];
            foreach ($type->getOneOf() as $item) {
                $parts[] = $this->getDocType($item);
            }
            return implode('|', $parts);
        } elseif ($type instanceof IntersectionType) {
            $parts = [];
            foreach ($type->getAllOf() as $item) {
                $parts[] = $this->getDocType($item);
            }
            return implode('&', $parts);
        } elseif ($type instanceof GenericType) {
            return $type->getGeneric();
        } else {
            return $this->getType($type);
        }
    }

    protected function getDate(): string
    {
        return '\\' . Date::class;
    }

    protected function getDateTime(): string
    {
        return '\\' . \DateTime::class;
    }

    protected function getTime(): string
    {
        return '\\' . Time::class;
    }

    protected function getDuration(): string
    {
        return '\\' . \DateInterval::class;
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
        return 'array'; // we use PHP array as map data structure
    }

    protected function getUnion(array $types): string
    {
        if (PHP_MAJOR_VERSION >= 8) {
            return implode('|', $types);
        } else {
            return '';
        }
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
        return '';
    }
}
