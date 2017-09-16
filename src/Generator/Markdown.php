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

/**
 * Markdown
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Markdown extends MarkupAbstract
{
    /**
     * @param string $id
     * @param string $title
     * @param string $description
     * @param \PSX\Schema\Generator\Text\Property[] $properties
     * @return string
     */
    protected function writeObject($id, $title, $description, array $properties)
    {
        $result = str_repeat('#', $this->heading) . ' ' . $title . "\n";
        $result.= '' . "\n";

        if (!empty($description)) {
            $result.= $description . "\n";
            $result.= '' . "\n";
        }

        $result.= 'Field | Type | Description | Constraints' . "\n";
        $result.= '----- | ---- | ----------- | -----------' . "\n";

        foreach ($properties as $name => $property) {
            $row = [
                $name,
                $property->getType(),
                $property->getDescription(),
                $property->hasConstraints() ? $this->writeConstraints($property->getConstraints()) : '',
            ];

            $result.= implode(' | ', $row);
            $result.= "\n";
        }

        $result.= '' . "\n";

        return $result;
    }

    protected function writeLink($title, $href)
    {
        return '[' . $title . '](' . $href . ')';
    }

    protected function writeConstraints(array $constraints)
    {
        $result = [];
        foreach ($constraints as $name => $constraint) {
            if (empty($constraint)) {
                continue;
            }

            if (is_scalar($constraint)) {
                $result[] = ucfirst($name) . ': ' . $constraint;
            }
        }

        return implode(', ', $result);
    }
}
