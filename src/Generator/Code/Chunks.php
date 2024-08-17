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

use Closure;
use Generator;
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

    public function getChunk(string $identifier): Chunks|string|null
    {
        return $this->parts[$identifier] ?? null;
    }

    /**
     * Tries to find a nested chunks based on the provided path
     */
    public function findByPath(string $path): Chunks|string|null
    {
        $parts = explode('/', $path);
        $first = array_shift($parts);

        $result = $this->parts[$first] ?? null;

        if (empty($parts)) {
            return $result;
        } elseif ($result instanceof Chunks) {
            return $result->findByPath(implode('/', $parts));
        } else {
            return null;
        }
    }

    /**
     * @deprecated use the explicit writeToZip method
     */
    public function writeTo(string $file): void
    {
        $this->writeToZip($file);
    }

    /**
     * Writes this chunk collection as zip archive to the provided file
     */
    public function writeToZip(string $file): void
    {
        $zip = new ZipArchive();
        $zip->open($file, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $this->recursiveWriteToZip($zip, $this);

        $zip->close();
    }

    /**
     * Writes all files to the provided folder, returns a generator which you need to iterate in order to write all
     * files, this allows to output all generated files
     *
     * @return Generator<string>
     */
    public function writeToFolder(string $folder, ?Closure $fileCallback = null, ?Closure $codeCallback = null): Generator
    {
        if (!is_dir($folder)) {
            throw new \InvalidArgumentException('Provided folder is not a directory');
        }

        yield from $this->recursiveWriteToFolder($folder, $this, $fileCallback, $codeCallback);
    }

    private function recursiveWriteToZip(ZipArchive $zip, Chunks $chunks, ?string $basePath = null): void
    {
        foreach ($chunks->getChunks() as $identifier => $code) {
            $item = ($basePath !== null ? $basePath . '/' : '') . $identifier;

            if ($code instanceof Chunks) {
                $zip->addEmptyDir($item);

                $this->recursiveWriteToZip($zip, $code, $item);
            } else {
                $zip->addFromString($item, $code);
            }
        }
    }

    private function recursiveWriteToFolder(string $folder, Chunks $chunks, ?Closure $fileCallback = null, ?Closure $codeCallback = null): Generator
    {
        foreach ($chunks->getChunks() as $identifier => $code) {
            $item = $folder . '/' . $identifier;

            if ($code instanceof Chunks) {
                if (!is_dir($item)) {
                    mkdir($item, recursive: true);
                }

                yield from $this->recursiveWriteToFolder($item, $code, $fileCallback, $codeCallback);
            } else {
                if ($fileCallback instanceof Closure) {
                    $item = $fileCallback($item);
                }

                if ($codeCallback instanceof Closure) {
                    $code = $codeCallback($code);
                }

                file_put_contents($item, $code);

                yield $item;
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
