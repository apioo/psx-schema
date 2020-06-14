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

namespace PSX\Schema\Parser\TypeSchema\Resolver;

use PSX\Json\Parser;
use PSX\Schema\Parser\TypeSchema\ResolverInterface;
use PSX\Uri\Uri;
use RuntimeException;

/**
 * File
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class File implements ResolverInterface
{
    public function resolve(Uri $uri): \stdClass
    {
        $path = str_replace('/', DIRECTORY_SEPARATOR, ltrim($uri->getPath(), '/'));

        if (is_file($path)) {
            $schema = file_get_contents($path);
            $data   = Parser::decode($schema);

            return $data;
        } else {
            throw new RuntimeException('Could not load external schema ' . $path);
        }
    }
}
