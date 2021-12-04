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

namespace PSX\Schema\Type;

use PSX\Schema\TypeInterface;

/**
 * PropertyType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
abstract class TypeAbstract implements TypeInterface, \JsonSerializable
{
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_OBJECT = 'object';
    const TYPE_ARRAY = 'array';
    const TYPE_NUMBER = 'number';
    const TYPE_INTEGER = 'integer';
    const TYPE_STRING = 'string';
    const TYPE_ANY = 'any';

    const FORMAT_INT32 = 'int32';
    const FORMAT_INT64 = 'int64';
    const FORMAT_BINARY = 'base64';
    const FORMAT_DATETIME = 'date-time';
    const FORMAT_DATE = 'date';
    const FORMAT_DURATION = 'duration';
    const FORMAT_TIME = 'time';
    const FORMAT_URI = 'uri';

    const ATTR_CLASS = 'class';
    const ATTR_MAPPING = 'mapping';

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var boolean
     */
    protected $nullable;

    /**
     * @var boolean
     */
    protected $deprecated;

    /**
     * @var boolean
     */
    protected $readonly;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return bool
     */
    public function isNullable(): ?bool
    {
        return $this->nullable;
    }

    /**
     * @param bool $nullable
     * @return self
     */
    public function setNullable(bool $nullable): self
    {
        $this->nullable = $nullable;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDeprecated(): ?bool
    {
        return $this->deprecated;
    }

    /**
     * @param bool $deprecated
     * @return self
     */
    public function setDeprecated(bool $deprecated): self
    {
        $this->deprecated = $deprecated;

        return $this;
    }

    /**
     * @return bool
     */
    public function isReadonly(): ?bool
    {
        return $this->readonly;
    }

    /**
     * @param bool $readonly
     * @return self
     */
    public function setReadonly(bool $readonly): self
    {
        $this->readonly = $readonly;

        return $this;
    }
    
    /**
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function setAttribute(string $key, $value): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getAttribute(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'description' => $this->description,
            'nullable' => $this->nullable,
            'deprecated' => $this->deprecated,
            'readonly' => $this->readonly,
        ], function($value){
            return $value !== null;
        });
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
