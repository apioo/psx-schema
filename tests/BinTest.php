<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Tests;

use PHPUnit\Framework\TestCase;

/**
 * BinTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class BinTest extends TestCase
{
    protected function setUp(): void
    {
        if (strpos(shell_exec('php -v'), 'PHP') === false) {
            $this->markTestIncomplete('Looks like php is not available');
        }
    }

    public function testBin()
    {
        $actual = shell_exec('php ' . __DIR__ . '/../bin/schema --no-ansi');
        $expect = <<<TEXT
PSX Schema

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  help          Display help for a command
  list          List commands
 schema
  schema:parse  Parses an arbitrary source and outputs the schema in a specific format

TEXT;

        $expect = str_replace(["\r\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $actual, $actual);
    }
}
