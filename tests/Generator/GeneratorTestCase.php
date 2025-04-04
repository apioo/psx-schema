<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Tests\Generator;

use PSX\Schema\Generator\Code\Chunks;
use PSX\Schema\Generator\FileAwareInterface;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Tests\SchemaTestCase;
use SebastianBergmann\Diff\Chunk;

/**
 * GeneratorTestCase
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class GeneratorTestCase extends SchemaTestCase
{
    protected function getComplexSchema(): SchemaInterface
    {
        return $this->schemaManager->getSchema(__DIR__ . '/resource/source_typeschema.json');
    }

    protected function getOOPSchema(): SchemaInterface
    {
        return $this->schemaManager->getSchema(__DIR__ . '/resource/source_oop.json');
    }

    protected function getImportSchema(): SchemaInterface
    {
        return $this->schemaManager->getSchema(__DIR__ . '/resource/source_import.json');
    }

    protected function getUnionSchema(): SchemaInterface
    {
        return $this->schemaManager->getSchema(__DIR__ . '/resource/source_union.json');
    }

    protected function getTestSchema(): SchemaInterface
    {
        return $this->schemaManager->getSchema(__DIR__ . '/resource/source_test.json');
    }

    protected function write(GeneratorInterface $generator, string|Chunks $result, string $baseDir): void
    {
        if ($generator instanceof FileAwareInterface && $result instanceof Chunks) {
            $chunks = new Chunks();
            foreach ($result->getChunks() as $identifier => $code) {
                $chunks->append($generator->getFileName($identifier), $generator->getFileContent($code));
            }

            iterator_to_array($chunks->writeToFolder($baseDir));
        } else {
            file_put_contents($baseDir . '/output.txt', (string) $result);
        }
    }
}
