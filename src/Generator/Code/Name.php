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

namespace PSX\Schema\Generator\Code;

use PSX\Schema\Generator\Normalizer\NormalizerInterface;

/**
 * Name
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Name
{
    private string $raw;
    private string $mapped;
    private NormalizerInterface $normalizer;

    public function __construct(string $raw, string $mapped, NormalizerInterface $normalizer)
    {
        $this->raw = $raw;
        $this->mapped = $mapped;
        $this->normalizer = $normalizer;
    }

    public function getRaw(): string
    {
        return $this->raw;
    }

    public function getArgument(): string
    {
        return $this->normalizer->argument($this->mapped);
    }

    public function getProperty(): string
    {
        return $this->normalizer->property($this->mapped);
    }

    public function getMethod(int $style): string
    {
        return $this->normalizer->method($this->mapped, $style);
    }

    public function getClass(): string
    {
        return $this->normalizer->class($this->mapped);
    }

    public function getFile(): string
    {
        return $this->normalizer->file($this->mapped);
    }
}
