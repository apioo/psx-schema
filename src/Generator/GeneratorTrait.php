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

namespace PSX\Schema\Generator;

use PSX\Schema\PropertyInterface;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\UnionType;

/**
 * GeneratorTrait
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
trait GeneratorTrait
{
    protected function getIdentifierForProperty(PropertyInterface $property): string
    {
        $title = $property->getTitle();
        if (!empty($title)) {
            $className = preg_replace('/[^a-zA-Z_\x7f-\xff]/u', '_', $title);
            $className = ucfirst($className);
        } else {
            $className = 'Object' . substr(md5(spl_object_hash($property)), 0, 8);
        }

        return $className;
    }

    protected function getSubSchemas(PropertyInterface $property): array
    {
        $result = [];

        if ($property instanceof ScalarType) {
            return [];
        } elseif ($property instanceof StructType) {
            $result[] = $property;
        } elseif ($property instanceof MapType) {
            $additionalProperties = $property->getAdditionalProperties();
            if ($additionalProperties instanceof PropertyInterface) {
                $result = array_merge($result, $this->getSubSchemas($additionalProperties));
            }
        } elseif ($property instanceof ArrayType) {
            $items = $property->getItems();
            if ($items instanceof PropertyInterface) {
                $result = array_merge($result, $this->getSubSchemas($items));
            }
        } elseif ($property instanceof UnionType) {
            $oneOf = $property->getOneOf();
            if (!empty($oneOf)) {
                foreach ($oneOf as $prop) {
                    $result = array_merge($result, $this->getSubSchemas($prop));
                }
            }
        } elseif ($property instanceof IntersectionType) {
            $allOf = $property->getAllOf();
            if (!empty($allOf)) {
                foreach ($allOf as $prop) {
                    $result = array_merge($result, $this->getSubSchemas($prop));
                }
            }
        }

        return $result;
    }
}
