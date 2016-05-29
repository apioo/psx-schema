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

use PSX\Record\RecordInterface;

/**
 * Default choice resolver which is used if no other resolver is available
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ChoiceResolver implements ChoiceResolverInterface
{
    public function getProperty($data, $path, Property\ChoiceType $property)
    {
        $properties = $property->getChoices();
        $matches    = [];

        foreach ($properties as $index => $prop) {
            $value = $this->match($data, $prop);
            if ($value > 0) {
                $matches[$index] = $value;
            }
        }

        if (empty($matches)) {
            return null;
        }

        arsort($matches);
        $key = key($matches);

        return isset($properties[$key]) ? $properties[$key] : null;
    }

    public function getTypes(Property\ChoiceType $property)
    {
        $properties = $property->getChoices();
        $types      = [];
        
        foreach ($properties as $key => $property) {
            $title     = $property->getName();
            $reference = $property->getReference();

            if (empty($title) && !empty($reference)) {
                $title = lcfirst(substr(strrchr($reference, '\\'), 1));
            }

            if (empty($title)) {
                $title = substr($property->getId(), 0, 8);
            }

            $types[$title] = $reference;
        }

        return $types;
    }

    /**
     * Returns a value indicating how much the given data structure matches
     * this type
     *
     * @param mixed $data
     * @param \PSX\Schema\Property\ComplexType $property
     * @return integer
     */
    protected function match($data, Property\ComplexType $property)
    {
        $data       = $this->normalizeToArray($data);
        $properties = $property->getProperties();

        if (is_array($data) && count($properties) > 0) {
            $match = 0;
            foreach ($properties as $name => $property) {
                if (isset($data[$name])) {
                    $match++;
                } elseif ($property->isRequired()) {
                    return 0;
                }
            }

            return $match / count($properties);
        }

        return 0;
    }

    protected function normalizeToArray($data)
    {
        if ($data instanceof RecordInterface) {
            $data = $data->getProperties();
        } elseif ($data instanceof \stdClass) {
            $data = (array) $data;
        }

        return $data;
    }
}
