<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;

/**
 * Php
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Php extends TypeAbstract
{
    public function getDocType(PropertyInterface $property): string
    {
        $type = $this->getRealType($property);

        if ($type === PropertyType::TYPE_ARRAY) {
            $items = $property->getItems();
            if ($items instanceof PropertyInterface) {
                return 'array<' . $this->getDocType($items) . '>';
            } else {
                return 'array';
            }
        } elseif (is_array($type)) {
            return implode('|', $type);
        } elseif ($property->getOneOf()) {
            $parts = [];
            foreach ($property->getOneOf() as $property) {
                $parts[] = $this->getDocType($property);
            }
            return implode('|', $parts);
        } elseif ($property->getAllOf()) {
            $parts = [];
            foreach ($property->getAllOf() as $property) {
                $parts[] = $this->getDocType($property);
            }
            return implode('&', $parts);
        } else {
            return $this->getType($property);
        }
    }

    protected function getDate(): string
    {
        return '\\' . \DateTime::class;
    }

    protected function getDateTime(): string
    {
        return '\\' . \DateTime::class;
    }

    protected function getTime(): string
    {
        return '\\' . \DateTime::class;
    }

    protected function getDuration(): string
    {
        return '\\' . \DateInterval::class;
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

    protected function getStruct(string $type): string
    {
        return $type;
    }

    protected function getMap(string $type, string $child): string
    {
        return $type;
    }

    protected function getUnion(array $types): string
    {
        // @TODO currently not possible but there is an RFC for union types
        return '';
    }

    protected function getIntersection(array $types): string
    {
        return '';
    }

    protected function getGroup(string $type): string
    {
        return '(' . $type . ')';
    }

    protected function getAny(): string
    {
        return '';
    }
}
