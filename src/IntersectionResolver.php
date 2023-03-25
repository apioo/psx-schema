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

namespace PSX\Schema;

use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StructType;

/**
 * IntersectionResolver
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class IntersectionResolver
{
    private DefinitionsInterface $definitions;

    public function __construct(DefinitionsInterface $definitions)
    {
        $this->definitions = $definitions;
    }

    /**
     * If the provided property is an allOf schema it tries to merge all
     * contained sub schemas into a new schema which contains all properties
     *
     * @throws Exception\InvalidSchemaException
     * @throws Exception\TypeNotFoundException
     */
    public function resolve(IntersectionType $type): ?StructType
    {
        $items = $type->getAllOf();
        if (empty($items)) {
            return null;
        }

        $newType = new StructType();
        foreach ($items as $item) {
            $this->merge($newType, $item);
        }

        return $newType;
    }

    /**
     * @throws Exception\InvalidSchemaException
     * @throws Exception\TypeNotFoundException
     */
    private function merge(StructType $left, TypeInterface $right): void
    {
        if ($right instanceof ReferenceType) {
            $right = $this->definitions->getType($right->getRef());
        }

        if (!$right instanceof StructType) {
            throw new \InvalidArgumentException('All of must contain only struct types');
        }

        if ($right->getTitle()) {
            $left->setTitle($right->getTitle());
        }

        if ($right->getDescription()) {
            $left->setDescription($right->getDescription());
        }

        foreach ($right->getProperties() as $name => $type) {
            $left->addProperty($name, $type);
        }
    }
}
