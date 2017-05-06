<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use PSX\Schema\PropertyType;

/**
 * GeneratorTrait
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
trait GeneratorTrait
{
    protected function getIdentifierForProperty(PropertyInterface $property)
    {
        $title = $property->getTitle();
        if (!empty($title)) {
            $className = preg_replace('/[^a-zA-Z_\x7f-\xff]/u', '_', $title);
            $className = ucfirst($className);
        } else {
            $className = 'Object' . substr($property->getConstraintId(), 0, 8);
        }

        return $className;
    }

    protected function getRealType(PropertyInterface $property)
    {
        $type = $property->getType();
        if (empty($type)) {
            // if we have no type we try to guess it based on the available
            // constraints
            if ($property->getProperties() !== null || $property->getPatternProperties() !== null || $property->getAdditionalProperties() !== null) {
                $type = PropertyType::TYPE_OBJECT;
            } elseif ($property->getItems() !== null || $property->getAdditionalItems() !== null) {
                $type = PropertyType::TYPE_ARRAY;
            } elseif ($property->getMaximum() !== null || $property->getMinimum() !== null || $property->getMultipleOf() !== null) {
                $type = PropertyType::TYPE_NUMBER;
            } elseif ($property->getMaxLength() !== null || $property->getMinLength() !== null || $property->getFormat() !== null || $property->getPattern() !== null) {
                $type = PropertyType::TYPE_STRING;
            }
        }

        return $type;
    }
}
