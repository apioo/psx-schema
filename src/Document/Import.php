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
 * Import
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Import implements \JsonSerializable
{
    private $alias;
    private $document;
    private $version;

    /**
     * @param array $import
     */
    public function __construct(array $import)
    {
        $this->alias = $import['alias'] ?? null;
        $this->document = $import['document'] ?? null;
        $this->version = $import['version'] ?? null;
    }

    public function getAlias()
    {
        return $this->alias;
    }

    public function getDocument()
    {
        return $this->document;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function jsonSerialize()
    {
        return [
            'alias' => $this->alias,
            'document' => $this->document,
            'version' => $this->version,
        ];
    }
}
