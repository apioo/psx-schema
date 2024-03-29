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

namespace PSX\Schema\Generator\Type;

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
    /**
     * Returns a type string
     */
    public function getType(TypeInterface $type): string;

    /**
     * Returns a doc type string
     */
    public function getDocType(TypeInterface $type): string;
}
