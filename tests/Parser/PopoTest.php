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

namespace PSX\Schema\Tests\Parser;

use PSX\Schema\Parser;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Tests\Parser\Popo\News;
use PSX\Schema\Tests\Parser\Popo\RecursiveTest;

/**
 * PopoTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class PopoTest extends ParserTestCase
{
    public function testParse()
    {
        $parser = new Parser\Popo($this->reader);
        $schema = $parser->parse(News::class);

        $this->assertSchema($this->getSchema(), $schema);
    }

    public function testParseRecursive()
    {
        $parser = new Parser\Popo($this->reader);
        $schema = $parser->parse(RecursiveTest::class);

        $this->assertInstanceOf(SchemaInterface::class, $schema);
    }
}
