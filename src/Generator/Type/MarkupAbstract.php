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

/**
 * MarkupAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
abstract class MarkupAbstract extends GeneratorAbstract
{
    protected function getDate(): string
    {
        return $this->writeLink('Date', 'http://tools.ietf.org/html/rfc3339#section-5.6');
    }

    protected function getDateTime(): string
    {
        return  $this->writeLink('DateTime', 'http://tools.ietf.org/html/rfc3339#section-5.6');
    }

    protected function getTime(): string
    {
        return  $this->writeLink('Time', 'http://tools.ietf.org/html/rfc3339#section-5.6');
    }

    protected function getDuration(): string
    {
        return  $this->writeLink('Duration', 'https://en.wikipedia.org/wiki/ISO_8601#Durations');
    }

    protected function getUri(): string
    {
        return  $this->writeLink('URI', 'http://tools.ietf.org/html/rfc3986');
    }

    protected function getBinary(): string
    {
        return  $this->writeLink('Base64', 'http://tools.ietf.org/html/rfc4648');
    }

    protected function getString(): string
    {
        return 'String';
    }

    protected function getInteger(): string
    {
        return 'Integer';
    }

    protected function getNumber(): string
    {
        return 'Number';
    }

    protected function getBoolean(): string
    {
        return 'Boolean';
    }

    protected function getArray(string $type): string
    {
        return 'Array (' . $type . ')';
    }

    protected function getStruct(string $type): string
    {
        return $this->writeLink($type, '#' . $type);
    }

    protected function getMap(string $type, string $child): string
    {
        return $this->writeLink($type, '#' . $type);
    }

    protected function getUnion(array $types): string
    {
        return implode(' &#124; ', $types);
    }

    protected function getIntersection(array $types): string
    {
        return implode(' &#38; ', $types);
    }

    protected function getGroup(string $type): string
    {
        return '(' . $type . ')';
    }

    protected function getAny(): string
    {
        return '';
    }

    /**
     * @param string $name
     * @param string $href
     * @return string
     */
    abstract protected function writeLink(string $name, string $href): string;
}
