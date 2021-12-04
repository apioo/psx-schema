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

/**
 * StringType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class StringType extends ScalarType
{
    /**
     * @var string
     */
    protected $pattern;

    /**
     * @var integer
     */
    protected $minLength;

    /**
     * @var integer
     */
    protected $maxLength;

    /**
     * @return string
     */
    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     * @return self
     */
    public function setPattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @return int
     */
    public function getMinLength(): ?int
    {
        return $this->minLength;
    }

    /**
     * @param int $minLength
     * @return self
     */
    public function setMinLength(int $minLength): self
    {
        $this->minLength = $minLength;

        return $this;
    }

    /**
     * @return int
     */
    public function getMaxLength(): ?int
    {
        return $this->maxLength;
    }

    /**
     * @param int $maxLength
     * @return self
     */
    public function setMaxLength(int $maxLength): self
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), array_filter([
            'type' => 'string',
            'pattern' => $this->pattern,
            'minLength' => $this->minLength,
            'maxLength' => $this->maxLength,
        ], function($value){
            return $value !== null;
        }));
    }
}
