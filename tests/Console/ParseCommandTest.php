<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use Doctrine\Common\Annotations\SimpleAnnotationReader;
use PHPUnit\Framework\TestCase;
use PSX\Schema\Console\ParseCommand;
use PSX\Schema\Parser\Popo;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManager;
use PSX\Schema\Tests\Parser\Popo\News;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * ParseCommandTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ParseCommandTest extends TestCase
{
    public function testGeneratePhp()
    {
        $command = $this->getParseCommand();

        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'source'   => News::class,
            '--format' => 'php',
        ));

        $actual = $commandTester->getDisplay();

        $expect = file_get_contents(__DIR__ . '/resource/php.php');
        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }

    protected function getParseCommand()
    {
        return new ParseCommand(new SchemaManager(new AnnotationReader()));
    }
}
