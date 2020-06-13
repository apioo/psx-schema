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

namespace PSX\Schema\Generator;

use PSX\Json\Parser;
use PSX\Schema\DefinitionsInterface;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\SchemaInterface;
use PSX\Schema\TypeInterface;

/**
 * TypeSchema
 *
 * @see     http://tools.ietf.org/html/draft-zyp-json-schema-04
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class TypeSchema implements GeneratorInterface
{
    public function generate(SchemaInterface $schema)
    {
        $data = $this->toArray(
            $schema->getType(),
            $schema->getDefinitions()
        );

        return Parser::encode($data, JSON_PRETTY_PRINT);
    }

    /**
     * @param \PSX\Schema\TypeInterface $type
     * @param \PSX\Schema\DefinitionsInterface $definitions
     * @return array
     */
    public function toArray(TypeInterface $type, DefinitionsInterface $definitions)
    {
        $object = $this->generateType($type);

        $result = [
            'definitions' => $this->generateDefinitions($definitions),
        ];

        $result = array_merge($result, $object);

        return $result;
    }

    protected function generateDefinitions(DefinitionsInterface $definitions)
    {
        $result = [];
        $types  = $definitions->getAllTypes();

        ksort($types);

        foreach ($types as $name => $type) {
            $result[$name] = $this->generateType($type);
        }

        return $result;
    }

    protected function generateType(TypeInterface $type)
    {
        return $type->toArray();
    }
}
