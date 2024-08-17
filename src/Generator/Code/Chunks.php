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

use ZipArchive;

/**
 * Chunks
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Chunks
{
    private ?string $namespace;
    private array $parts = [];

    public function __construct(?string $namespace = null)
    {
        $this->namespace = $namespace;
    }

    public function append(string $identifier, string|Chunks $code): void
    {
        $this->parts[$identifier] = $code;
    }

    public function merge(Chunks $chunks): void
    {
        foreach ($chunks->getChunks() as $identifier => $code) {
            $this->append($identifier, $code);
        }
    }

    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    /**
     * @return array<string|Chunks>
     */
    public function getChunks(): array
    {
        return $this->parts;
    }

    /**
     * Writes this chunk collection as zip archive to the provided file
     */
    public function writeTo(string $file): void
    {
        $zip = new ZipArchive();
        $zip->open($file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $this->recursiveAddToZip($zip, $this);

        $zip->close();
    }

    private function recursiveAddToZip(ZipArchive $zip, Chunks $chunks, ?string $basePath = null): void
    {
        foreach ($chunks->getChunks() as $identifier => $code) {
            $prefix = $basePath !== null ? $basePath . '/' : '';

            if ($code instanceof Chunks) {
                $zip->addEmptyDir($prefix . $identifier);
                $this->recursiveAddToZip($zip, $code, $prefix . $identifier);
            } else {
                $zip->addFromString($prefix . $identifier, $code);
            }
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode("\n", $this->getChunks());
    }
}
