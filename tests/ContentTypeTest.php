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

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PSX\Schema\ContentType;

/**
 * ContentTypeTest
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ContentTypeTest extends TestCase
{
    #[DataProvider('contentTypeProviderValid')]
    public function testIsValid(string $contentType): void
    {
        self::assertTrue(ContentType::isValid($contentType));
    }

    public static function contentTypeProviderValid(): array
    {
        return [
            [ContentType::BINARY],
            [ContentType::FORM],
            [ContentType::JSON],
            [ContentType::MULTIPART],
            [ContentType::TEXT],
            [ContentType::XML],
            ['application/linkset+json; profile="https://www.rfc-editor.org/info/rfc9727"'],
        ];
    }

    #[DataProvider('contentTypeProviderInvalid')]
    public function testIsValidFalse(string $contentType): void
    {
        self::assertFalse(ContentType::isValid($contentType));
    }

    public static function contentTypeProviderInvalid(): array
    {
        return [
            ['foobar'],
        ];
    }
}