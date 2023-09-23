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

namespace PSX\Schema\Tests\Parser\Popo;

use PHPUnit\Framework\TestCase;
use PSX\DateTime\LocalDate;
use PSX\DateTime\LocalDateTime;
use PSX\DateTime\LocalTime;
use PSX\DateTime\Period;
use PSX\Record\RecordInterface;
use PSX\Schema\Parser\Popo\Dumper;
use PSX\Schema\Parser\Popo\TypeNameBuilder;
use PSX\Uri\Uri;

/**
 * TypeNameTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TypeNameTest extends TestCase
{
    /**
     * @dataProvider nameProvider
     */
    public function testBuild(string $class, int $level, string $expect): void
    {
        $builder = new TypeNameBuilder();
        $actual = $builder->build(new \ReflectionClass($class), $level);

        $this->assertSame($expect, $actual);
    }

    public function nameProvider(): array
    {
        return [
            [self::class, -1, 'TypeNameTest'],
            [self::class, 0, 'TypeNameTest'],
            [self::class, 1, 'TypeNameTest'],
            [self::class, 2, 'Popo_TypeNameTest'],
            [self::class, 3, 'Parser_Popo_TypeNameTest'],
            [self::class, 4, 'Tests_Parser_Popo_TypeNameTest'],
            [self::class, 5, 'Schema_Tests_Parser_Popo_TypeNameTest'],
            [self::class, 6, 'PSX_Schema_Tests_Parser_Popo_TypeNameTest'],
            [self::class, 7, 'PSX_Schema_Tests_Parser_Popo_TypeNameTest'],
        ];
    }
}
