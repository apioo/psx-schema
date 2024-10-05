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

namespace PSX\Schema\Generator;

use PSX\Json\Parser;
use PSX\Schema\DefinitionsInterface;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\SchemaInterface;
use PSX\Schema\TypeInterface;
use PSX\Schema\TypeUtil;

/**
 * TypeSchema
 *
 * @see     http://tools.ietf.org/html/draft-zyp-json-schema-04
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TypeSchema implements GeneratorInterface
{
    public function generate(SchemaInterface $schema): Code\Chunks|string
    {
        $data = $this->toArray(
            $schema->getType(),
            $schema->getDefinitions()
        );

        return Parser::encode($data);
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

        foreach ($types as $ref => $type) {
            [$ns, $name] = TypeUtil::split($ref);

            if ($ns === DefinitionsInterface::SELF_NAMESPACE) {
                $result[$name] = $this->generateType($type);
            } else {
                $result[$ref] = $this->generateType($type);
            }
        }

        return $result;
    }

    protected function generateType(TypeInterface $type)
    {
        TypeUtil::normalize($type);

        return $type->toArray();
    }
}
