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

namespace PSX\Schema\Generator;

use PSX\Record\Record;

/**
 * Config
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Config extends Record
{
    public const NAMESPACE = 'namespace';
    public const MAPPING = 'mapping';
    public const INDENT = 'indent';
    public const HEADING = 'heading';
    public const PREFIX = 'prefix';

    public function toString(): string
    {
        return base64_encode(json_encode($this));
    }

    public static function fromQueryString(?string $query): Config
    {
        $result = [];
        parse_str($query ?? '', $result);

        return self::from($result);
    }

    public static function fromBase64String(?string $config): Config
    {
        if (!empty($config)) {
            $data = json_decode(base64_decode($config));
        } else {
            $data = [];
        }

        if (is_iterable($data) || is_object($data)) {
            return self::from($data);
        } else {
            return new self();
        }
    }

    public static function of(string $namespace, array $mapping = []): Config
    {
        $config = new self();
        $config->put(self::NAMESPACE, $namespace);
        $config->put(self::MAPPING, $mapping);

        return $config;
    }
}
