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
 * Html
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Html extends MarkupAbstract
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
        $result = '<div id="' . $id . '" class="psx-object">';
        $result.= '<h' . $this->heading . '>' . htmlspecialchars($title) . '</h' . $this->heading . '>';

        if (!empty($description)) {
            $result.= '<div class="psx-object-description">' . htmlspecialchars($description) . '</div>';
        }

        $prop = '<table class="table psx-object-properties">';
        $prop.= '<colgroup>';
        $prop.= '<col width="30%" />';
        $prop.= '<col width="70%" />';
        $prop.= '</colgroup>';
        $prop.= '<thead>';
        $prop.= '<tr>';
        $prop.= '<th>Field</th>';
        $prop.= '<th>Description</th>';
        $prop.= '</tr>';
        $prop.= '</thead>';
        $prop.= '<tbody>';

        $json = '<span class="psx-object-json-pun">{</span>' . "\n";

        foreach ($properties as $name => $property) {
            $prop.= '<tr>';
            $prop.= '<td><span class="psx-property-name ' . ($property->isRequired() ? 'psx-property-required' : 'psx-property-optional') . '">' . $name . '</span></td>';
            $prop.= '<td>';
            $prop.= '<span class="psx-property-type">' . $property->getType() . '</span><br />';
            $prop.= '<div class="psx-property-description">' . htmlspecialchars($property->getDescription()) . '</div>';
            $prop.= $property->hasConstraints() ? $this->writeConstraints($property->getConstraints()) : '';
            $prop.= '</td>';
            $prop.= '</tr>';

            $json.= '  ';
            $json.= '<span class="psx-object-json-key">"' . $name . '"</span>';
            $json.= '<span class="psx-object-json-pun">: </span>';
            $json.= '<span class="psx-property-type">' . $property->getType() . '</span>';
            $json.= '<span class="psx-object-json-pun">,</span>';
            $json.= "\n";
        }

        $json.= '<span class="psx-object-json-pun">}</span>';

        $prop.= '</tbody>';
        $prop.= '</table>';

        $result.= '<pre class="psx-object-json">' . $json . '</pre>';
        $result.= $prop;
        $result.= '</div>';

        return $result . "\n";
    }

    /**
     * @param string $title
     * @param string $href
     * @return string
     */
    protected function writeLink($title, $href)
    {
        return '<a href="' . $href . '" title="RFC4648">' . htmlspecialchars($title) . '</a>';
    }

    /**
     * @param array $constraints
     * @return string
     */
    protected function writeConstraints(array $constraints)
    {
        $result = '<dl class="psx-property-constraint">';
        foreach ($constraints as $name => $constraint) {
            if (empty($constraint)) {
                continue;
            }

            $result.= '<dt>' . htmlspecialchars(ucfirst($name)) . '</dt>';
            $result.= '<dd>';

            $type = strtolower($name);
            if ($name == 'enum') {
                $result.= '<ul class="psx-constraint-enum">';
                foreach ($constraint as $prop) {
                    $result.= '<li><code>' . htmlspecialchars(json_encode($prop)) . '</code></li>';
                }
                $result.= '</ul>';
            } elseif ($name == 'const') {
                $result.= '<span class="psx-constraint-const">';
                $result.= '<code>' . htmlspecialchars(json_encode($constraint)) . '</code>';
                $result.= '</span>';
            } elseif (in_array($name, ['oneOf', 'anyOf', 'allOf'])) {
                $result.= '<ul class="psx-constraint-' . $type . '">';
                foreach ($constraint as $prop) {
                    /** @var Text\Property $prop */
                    $result.= '<li>' . $prop->getType() . '</li>';
                }
                $result.= '</ul>';
            } else {
                $result.= '<span class="psx-constraint-' . $type . '">' . htmlspecialchars($constraint) . '</span>';
            }

            $result.= '</dd>';
        }
        $result.= '</dl>';

        return $result;
    }
}
