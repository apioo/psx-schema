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

namespace PSX\Schema\Tests;

use PHPUnit\Framework\TestCase;
use PSX\Schema\Generator\TypeSchema;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManager;

/**
 * SchemaTestCase
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class SchemaTestCase extends TestCase
{
    protected SchemaManager $schemaManager;

    protected function setUp(): void
    {
        $this->schemaManager = new SchemaManager();
    }

    protected function getSchema(): SchemaInterface
    {
        return $this->schemaManager->getSchema(TestSchema::class);
    }

    protected function assertSchema(SchemaInterface $leftSchema, SchemaInterface $rightSchema): void
    {
        $generator = new TypeSchema();

        $expect = $generator->generate($leftSchema);
        $actual = $generator->generate($rightSchema);

        $this->assertJsonStringEqualsJsonString($expect, $actual);
    }

    protected function assertSchemaAttributes(SchemaInterface $leftSchema, SchemaInterface $rightSchema): void
    {
        foreach ($leftSchema->getDefinitions()->getTypes() as $typeName => $leftType) {
            $rightType = $rightSchema->getDefinitions()->getType($typeName);
            $this->assertSame($leftType->getAttributes(), $rightType->getAttributes());
        }
    }
}
