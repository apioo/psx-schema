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

namespace PSX\Schema\Tests\Generator;

use PHPUnit\Framework\TestCase;
use PSX\Schema\Generator\Code\Chunks;

/**
 * ChunksTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ChunksTest extends TestCase
{
    public function testWriteToZip()
    {
        $subChunks = new Chunks();
        $subChunks->append('file_b', 'foobar');

        $chunks = new Chunks();
        $chunks->append('folder', $subChunks);
        $chunks->append('file_a', 'foobar');

        $chunks->writeToZip(__DIR__ . '/resource/test.zip');

        $this->assertFileExists(__DIR__ . '/resource/test.zip');
    }

    public function testWriteToFolder()
    {
        $subChunks = new Chunks();
        $subChunks->append('file_b', 'foobar');

        $chunks = new Chunks();
        $chunks->append('folder', $subChunks);
        $chunks->append('file_a', 'foobar');

        $result = $chunks->writeToFolder(__DIR__ . '/resource');

        iterator_to_array($result);

        $this->assertFileExists(__DIR__ . '/resource/file_a');
        $this->assertDirectoryExists(__DIR__ . '/resource/folder');
        $this->assertFileExists(__DIR__ . '/resource/folder/file_b');
    }

    public function testFindByPath()
    {
        $subSubChunks = new Chunks();
        $subSubChunks->append('file_c', 'foobar');

        $subChunks = new Chunks();
        $subChunks->append('file_b', 'foobar');
        $subChunks->append('folder_1', $subSubChunks);

        $chunks = new Chunks();
        $chunks->append('folder', $subChunks);
        $chunks->append('file_a', 'foobar');

        $this->assertEquals('foobar', $chunks->findByPath('folder/folder_1/file_c'));
        $this->assertInstanceOf(Chunks::class, $chunks->findByPath('folder/folder_1'));
        $this->assertEquals('foobar', $chunks->findByPath('folder/file_b'));
        $this->assertInstanceOf(Chunks::class, $chunks->findByPath('folder'));
        $this->assertEquals('foobar', $chunks->findByPath('file_a'));
    }

    public function testGetChunk()
    {
        $chunks = new Chunks();
        $chunks->append('folder', new Chunks());
        $chunks->append('file_a', 'foobar');

        $this->assertInstanceOf(Chunks::class, $chunks->getChunk('folder'));
        $this->assertEquals('foobar', $chunks->getChunk('file_a'));
    }
}