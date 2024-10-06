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

namespace PSX\Schema\Generator\Type;

use PSX\Schema\ContentType;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\TypeInterface;

/**
 * A generator can implement this interface if it has the ability to resolve a type from a schema instance. It returns
 * then the fitting type for the target programming language i.e. for Java we use a HashMap as map data structure and
 * for TypeScript we use Record. It provides also a second method which allows you to return a different type for
 * documentation which is then used in the doc-block
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
interface GeneratorInterface
{
    public const CONTEXT_CLIENT = 1;
    public const CONTEXT_SERVER = 2;
    public const CONTEXT_REQUEST = 4;
    public const CONTEXT_RESPONSE = 8;

    /**
     * Returns a type string
     */
    public function getType(PropertyTypeAbstract $type): string;

    /**
     * Returns a doc type string
     */
    public function getDocType(PropertyTypeAbstract $type): string;

    /**
     * Returns generic types
     */
    public function getGenericType(array $types): string;

    /**
     * Returns a fitting type for the provided content type. If the programming language has a native type for the provided content
     * type it should return it, i.e. for "application/xml" Java could return "org.w3c.dom.Document" and PHP "DOMDocument".
     * As default the method should simply return a string type
     */
    public function getContentType(ContentType $contentType, int $context): string;
}
