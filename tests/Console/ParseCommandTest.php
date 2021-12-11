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

namespace PSX\Schema\Tests\Console;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;
use PSX\Schema\Console\ParseCommand;
use PSX\Schema\SchemaManager;
use PSX\Schema\Tests\Parser\Popo\Attribute\News;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * ParseCommandTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ParseCommandTest extends TestCase
{
    public function testGeneratePhp()
    {
        $command = $this->getParseCommand();

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'source'   => News::class,
            'target'   => __DIR__ . '/resource',
            '--format' => 'php',
        ));

        $actual = $commandTester->getDisplay();
        $expect = 'Generated 5 files';

        $this->assertEquals($expect, substr($actual, 0, strlen($expect)), $actual);
        $this->assertFileExists(__DIR__ . '/resource/Author.php');
        $this->assertFileExists(__DIR__ . '/resource/Location.php');
        $this->assertFileExists(__DIR__ . '/resource/Meta.php');
        $this->assertFileExists(__DIR__ . '/resource/News.php');
        $this->assertFileExists(__DIR__ . '/resource/Web.php');
    }

    protected function getParseCommand()
    {
        return new ParseCommand(new SchemaManager(new AnnotationReader()));
    }
}
