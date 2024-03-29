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

namespace PSX\Schema\Tests;

use PHPUnit\Framework\TestCase;
use PSX\Schema\Inspector\SemVer;

/**
 * SemVerTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class SemVerTest extends TestCase
{
    public function testCompare()
    {
        $version1 = SemVer::fromString('0.1.0');
        $version2 = SemVer::fromString('0.1.1');

        $this->assertTrue($version1->equals($version1));
        $this->assertFalse($version1->greater($version1));
        $this->assertFalse($version1->lower($version1));

        $this->assertFalse($version1->equals($version2));
        $this->assertFalse($version1->greater($version2));
        $this->assertTrue($version1->lower($version2));

        $this->assertFalse($version2->equals($version1));
        $this->assertTrue($version2->greater($version1));
        $this->assertFalse($version2->lower($version1));
    }

    public function testIncrease()
    {
        $version1 = SemVer::fromString('0.1.0');
        $version1->increaseMajor();

        $this->assertEquals('1.0.0', $version1->toString());

        $version1 = SemVer::fromString('0.1.0');
        $version1->increaseMinor();

        $this->assertEquals('0.2.0', $version1->toString());

        $version1 = SemVer::fromString('0.1.0');
        $version1->increasePatch();

        $this->assertEquals('0.1.1', $version1->toString());
    }

    public function testIncreaseType()
    {
        $version1 = SemVer::fromString('0.1.0');
        $version1->increase(SemVer::MAJOR);

        $this->assertEquals('1.0.0', $version1->toString());

        $version1 = SemVer::fromString('0.1.0');
        $version1->increase(SemVer::MINOR);

        $this->assertEquals('0.2.0', $version1->toString());

        $version1 = SemVer::fromString('0.1.0');
        $version1->increase(SemVer::PATCH);

        $this->assertEquals('0.1.1', $version1->toString());
    }

    public function testIncreaseTypeInvalid()
    {
        $this->expectException(\InvalidArgumentException::class);

        $version1 = SemVer::fromString('0.1.0');
        $version1->increase('foo');
    }
}
