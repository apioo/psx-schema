<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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

/**
 * IntersectionResolver
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class IntersectionResolver
{
    /**
     * If the provided property is an allOf schema it tries to merge all
     * contained sub schemas into a new schema which contains all properties
     * 
     * @param PropertyInterface $property
     * @return PropertyInterface|null
     */
    public function resolve(PropertyInterface $property): ?PropertyInterface
    {
        $schemas = $this->getSchemasToMerge($property->getAllOf());
        if (empty($schemas)) {
            return null;
        }

        $newProperty = new PropertyType();
        foreach ($schemas as $schema) {
            $this->merge($newProperty, $schema);
        }

        return $newProperty;
    }

    private function getSchemasToMerge(?array $allOf): ?array
    {
        if (empty($allOf)) {
            return null;
        }

        $result = [];
        foreach ($allOf as $prop) {
            /** @var PropertyInterface $prop */
            // resolve nested intersection
            if ($prop->getAllOf()) {
                $prop = $this->resolve($prop);
            }

            if ($prop->getProperties()) {
                // we can only merge struct types
                $result[] = $prop;
            } else {
                // this means we have an property which we can not merge
                return null;
            }
        }

        return $result;
    }

    private function merge(PropertyInterface $left, PropertyInterface $right)
    {
        if ($right->getType()) {
            $left->setType($right->getType());
        }

        if ($right->getTitle()) {
            $left->setTitle($right->getTitle());
        }

        if ($right->getDescription()) {
            $left->setDescription($right->getDescription());
        }

        $leftProps  = $left->getProperties()  ?: [];
        $rightProps = $right->getProperties() ?: [];
        $left->setProperties(array_merge($leftProps, $rightProps));

        return $left;
    }
}
