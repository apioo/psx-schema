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

use PSX\Schema\Exception\GeneratorException;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\CollectionPropertyType;
use PSX\Schema\Type\MapPropertyType;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StructDefinitionType;

/**
 * DiscriminatorTrait
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
trait DiscriminatorTrait
{
    /**
     * @return array{array|null, string|null}
     */
    private function getDiscriminatorByProperty(PropertyTypeAbstract $property): array
    {
        if ($property instanceof CollectionPropertyType) {
            $property = $property->getSchema();
        }

        if (!$property instanceof ReferencePropertyType) {
            return [null, null];
        }

        $type = $this->resolveReference($property);
        if (!$type instanceof StructDefinitionType) {
            return [null, null];
        }

        return $this->getDiscriminatorType($type);
    }

    /**
     * @return array{array|null, string|null}
     */
    private function getDiscriminatorByParent(StructDefinitionType $origin): array
    {
        $parent = $origin->getParent();
        if (!$parent instanceof ReferencePropertyType) {
            return [null, null];
        }

        $type = $this->resolveReference($parent);
        if (!$type instanceof StructDefinitionType) {
            return [null, null];
        }

        [$mapping, $discriminator] = $this->getDiscriminatorType($type);
        [$parentMapping, $parentDiscriminator] = $this->getDiscriminatorByParent($type);

        if ($mapping === null) {
            $mapping = $parentMapping;
        } elseif (is_array($mapping) && is_array($parentMapping)) {
            foreach ($parentMapping as $key => $value) {
                if (!isset($mapping[$key])) {
                    $mapping[$key] = $value;
                }
            }
        }

        if ($discriminator === null) {
            $discriminator = $parentDiscriminator;
        }

        return [$mapping, $discriminator];
    }

    /**
     * @return array{array|null, string|null}
     */
    private function getDiscriminatorType(StructDefinitionType $property): array
    {
        $discriminator = $property->getDiscriminator();
        $mapping = $property->getMapping();
        if ($discriminator === null || $mapping === null) {
            return [null, null];
        }

        return [$mapping, $discriminator];
    }

    private function resolveReference(ReferencePropertyType $property): ?StructDefinitionType
    {
        $type = $this->definitions->getType($property->getTarget());
        if (!$type instanceof StructDefinitionType) {
            return null;
        }

        return $type;
    }
}
