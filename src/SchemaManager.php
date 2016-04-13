<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

namespace PSX\Schema;

use Doctrine\Common\Annotations\Reader;

/**
 * SchemaManager
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaManager implements SchemaManagerInterface
{
    protected $popoParser;

    public function __construct(Reader $annotationReader)
    {
        $this->popoParser = new Parser\Popo($annotationReader);
    }

    public function getSchema($schemaName)
    {
        if (class_exists($schemaName)) {
            if (in_array('PSX\\Schema\\SchemaInterface', class_implements($schemaName))) {
                return new $schemaName($this);
            } else {
                return $this->popoParser->parse($schemaName);
            }
        } elseif (is_file($schemaName)) {
            return Parser\JsonSchema::fromFile($schemaName);
        } else {
            throw new InvalidSchemaException('Schema ' . $schemaName . ' does not exist');
        }
    }
}
