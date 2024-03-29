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

namespace PSX\Schema\Generator\Code;

/**
 * Chunks
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Chunks
{
    /**
     * @var string|null
     */
    private $namespace;

    /**
     * @var array 
     */
    private $parts = [];

    /**
     * @param string|null $namespace
     */
    public function __construct(?string $namespace = null)
    {
        $this->namespace = $namespace;
    }

    /**
     * @param string $identifier
     * @param string $code
     */
    public function append(string $identifier, string $code)
    {
        $this->parts[$identifier] = $code;
    }

    /**
     * @param Chunks $chunks
     */
    public function merge(Chunks $chunks)
    {
        foreach ($chunks->getChunks() as $identifier => $code) {
            $this->append($identifier, $code);
        }
    }

    /**
     * @return string|null
     */
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    /**
     * @return array
     */
    public function getChunks()
    {
        return $this->parts;
    }

    /**
     * Writes this chunk collection as zip archive to the provided file
     * 
     * @param string $file
     */
    public function writeTo(string $file)
    {
        $zip = new \ZipArchive();
        $zip->open($file, \ZipArchive::CREATE);

        foreach ($this->getChunks() as $identifier => $code) {
            $zip->addFromString($identifier, $code);
        }

        $zip->close();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode("\n", $this->getChunks());
    }
}
