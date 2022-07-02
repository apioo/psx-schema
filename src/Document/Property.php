<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Document;

/**
 * Property
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Property
{
    public const TYPE_STRING = 'string';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_NUMBER = 'number';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_OBJECT = 'object';
    public const TYPE_MAP = 'map';
    public const TYPE_ARRAY = 'array';
    public const TYPE_UNION = 'union';
    public const TYPE_INTERSECTION = 'intersection';
    public const TYPE_ANY = 'any';

    private ?string $name;
    private ?string $description;
    private ?string $type;
    private ?string $format;
    private ?string $pattern;
    private ?int $minLength;
    private ?int $maxLength;
    private ?int $minimum;
    private ?int $maximum;
    private ?bool $deprecated;
    private ?bool $nullable;
    private ?bool $readonly;
    private ?array $refs;

    public function __construct(array $property)
    {
        $this->name = $property['name'] ?? null;
        $this->description = $property['description'] ?? null;
        $this->type = $property['type'] ?? null;
        $this->format = $property['format'] ?? null;
        $this->pattern = $property['pattern'] ?? null;
        $this->minLength = $property['minLength'] ?? null;
        $this->maxLength = $property['maxLength'] ?? null;
        $this->minimum = $property['minimum'] ?? null;
        $this->maximum = $property['maximum'] ?? null;
        $this->deprecated = $property['deprecated'] ?? null;
        $this->nullable = $property['nullable'] ?? null;
        $this->readonly = $property['readonly'] ?? null;
        $this->refs = $property['refs'] ?? null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    public function getMinLength(): ?int
    {
        return $this->minLength;
    }

    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    public function getMinimum(): ?int
    {
        return $this->minimum;
    }

    public function getMaximum(): ?int
    {
        return $this->maximum;
    }

    public function getDeprecated(): ?bool
    {
        return $this->deprecated;
    }

    public function getNullable(): ?bool
    {
        return $this->nullable;
    }

    public function getReadonly(): ?bool
    {
        return $this->readonly;
    }

    public function getRefs(): ?array
    {
        return $this->refs;
    }

    public function getFirstRef(): ?string
    {
        return !empty($this->refs) ? reset($this->refs) : null;
    }
}
