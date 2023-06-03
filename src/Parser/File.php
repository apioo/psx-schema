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

namespace PSX\Schema\Parser;

use PSX\Schema\Exception\ParserException;
use PSX\Schema\Parser\Context\FilesystemContext;
use PSX\Schema\SchemaInterface;

/**
 * File
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class File extends TypeSchema
{
    public function parse(string $schema, ?ContextInterface $context = null): SchemaInterface
    {
        $file = $schema;
        if (!is_file($schema) && $context instanceof FilesystemContext) {
            $file = $context->getBasePath() . '/' . $file;
        }

        if (!is_file($file)) {
            throw new ParserException('Could not load external schema ' . $schema);
        }

        return parent::parse(file_get_contents($file), new FilesystemContext(pathinfo($file, PATHINFO_DIRNAME)));
    }
}
