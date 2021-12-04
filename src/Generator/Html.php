<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\UnionType;

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
     * @inheritDoc
     */
    public function getFileName(string $file): string
    {
        return $file . '.html';
    }

    /**
     * @inheritDoc
     */
    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Html($mapping);
    }

    /**
     * @inheritDoc
     */
    protected function writeStruct(string $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $title = '<a class="psx-type-link" data-name="' . $name . '">' . htmlspecialchars($name) . '</a>';
        if (!empty($generics)) {
            $title.= '&lt;' . implode(', ', $generics) . '&gt;';
        }

        if (!empty($extends)) {
            $title.= ' extends <a class="psx-type-link" data-name="' . $extends . '">' . htmlspecialchars($extends) . '</a>';
        }

        $return = '<div id="' . htmlspecialchars($name) . '" class="psx-object psx-struct">';
        $return.= '<h' . $this->heading . '>' . $title . '</h' . $this->heading . '>';

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $return.= '<div class="psx-object-description">' . htmlspecialchars($comment) . '</div>';
        }

        $rows = [];
        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $rows[] = [
                $name,
                $property,
                $this->getConstraints($property->getOrigin()),
            ];
        }

        $return.= $this->generateJson($rows);
        $return.= $this->generateTable($rows);
        $return.= '</div>';

        return $return . "\n";
    }

    /**
     * @inheritDoc
     */
    protected function writeMap(string $name, string $type, MapType $origin): string
    {
        $return = '<div id="' . htmlspecialchars($name) . '" class="psx-object psx-map">';
        $return.= '<h' . $this->heading . '><a class="psx-type-link" data-name="' . $name . '">' . $name . '</a></h' . $this->heading . '>';

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $return.= '<div class="psx-object-description">' . htmlspecialchars($comment) . '</div>';
        }

        $return.= '<pre class="psx-object-json">' . $type . '</pre>';
        $return.= '</div>';

        return $return . "\n";
    }

    protected function writeArray(string $name, string $type, ArrayType $origin): string
    {
        $return = '<div id="' . htmlspecialchars($name) . '" class="psx-object psx-array">';
        $return.= '<h' . $this->heading . '><a class="psx-type-link" data-name="' . $name . '">' . $name . '</a></h' . $this->heading . '>';

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $return.= '<div class="psx-object-description">' . htmlspecialchars($comment) . '</div>';
        }

        $return.= '<pre class="psx-object-json">' . $type . '</pre>';
        $return.= '</div>';

        return $return . "\n";
    }

    protected function writeUnion(string $name, string $type, UnionType $origin): string
    {
        $return = '<div id="' . htmlspecialchars($name) . '" class="psx-object psx-union">';
        $return.= '<h' . $this->heading . '><a class="psx-type-link" data-name="' . $name . '">' . $name . '</a></h' . $this->heading . '>';

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $return.= '<div class="psx-object-description">' . htmlspecialchars($comment) . '</div>';
        }

        $return.= '<pre class="psx-object-json">OneOf: ' . $type . '</pre>';
        $return.= '</div>';

        return $return . "\n";
    }

    protected function writeIntersection(string $name, string $type, IntersectionType $origin): string
    {
        $return = '<div id="' . htmlspecialchars($name) . '" class="psx-object psx-intersection">';
        $return.= '<h' . $this->heading . '><a class="psx-type-link" data-name="' . $name . '">' . $name . '</a></h' . $this->heading . '>';

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $return.= '<div class="psx-object-description">' . htmlspecialchars($comment) . '</div>';
        }

        $return.= '<pre class="psx-object-json">AllOf: ' . $type . '</pre>';
        $return.= '</div>';

        return $return . "\n";
    }

    protected function writeReference(string $name, string $type, ReferenceType $origin): string
    {
        $generics = '';
        $template = $origin->getTemplate();
        if (!empty($template)) {
            foreach ($template as $key => $value) {
                $generics.= "\n";
                $generics.= '<span class="psx-object-json-key">"' . htmlspecialchars($key) . '"</span>';
                $generics.= '<span class="psx-object-json-pun"> = </span>';
                $generics.= '<span class="psx-property-type"><a href="#' . $value . '">' . $value . '</a></span>';
            }
        }

        $return = '<div id="' . htmlspecialchars($name) . '" class="psx-object psx-reference">';
        $return.= '<h' . $this->heading . '><a href="#' . $name . '">' . $name . '</a></h' . $this->heading . '>';

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $return.= '<div class="psx-object-description">' . htmlspecialchars($comment) . '</div>';
        }

        $return.= '<pre class="psx-object-json">';
        $return.= 'Reference: ' . $type;
        $return.= $generics;
        $return.= '</pre>';
        $return.= '</div>';

        return $return . "\n";
    }

    /**
     * @param array $constraints
     * @return string
     */
    protected function writeConstraints(array $constraints): string
    {
        $html = '<dl class="psx-property-constraint">';
        foreach ($constraints as $name => $constraint) {
            if (empty($constraint)) {
                continue;
            }

            $html.= '<dt>' . htmlspecialchars(ucfirst($name)) . '</dt>';
            $html.= '<dd>';

            $type = strtolower($name);
            if ($name == 'enum') {
                $html.= '<ul class="psx-constraint-enum">';
                foreach ($constraint as $prop) {
                    $html.= '<li><code>' . htmlspecialchars(json_encode($prop)) . '</code></li>';
                }
                $html.= '</ul>';
            } elseif ($name == 'const') {
                $html.= '<span class="psx-constraint-const">';
                $html.= '<code>' . htmlspecialchars(json_encode($constraint)) . '</code>';
                $html.= '</span>';
            } else {
                $html.= '<span class="psx-constraint-' . $type . '">' . htmlspecialchars($constraint) . '</span>';
            }

            $html.= '</dd>';
        }
        $html.= '</dl>';

        return $html;
    }

    private function generateTable(array $rows): string
    {
        $html = '<table class="table psx-object-properties">';
        $html.= '<colgroup>';
        $html.= '<col width="30%" />';
        $html.= '<col width="70%" />';
        $html.= '</colgroup>';
        $html.= '<thead>';
        $html.= '<tr>';
        $html.= '<th>Field</th>';
        $html.= '<th>Description</th>';
        $html.= '</tr>';
        $html.= '</thead>';
        $html.= '<tbody>';

        foreach ($rows as $row) {
            [$name, $property, $constraints] = $row;

            $classes = $this->getPropertyCssClasses($property);

            $html.= '<tr>';
            $html.= '<td><span class="psx-property-name ' . implode(' ', $classes) . '">' . htmlspecialchars($name) . '</span></td>';
            $html.= '<td>';
            $html.= '<span class="psx-property-type"><a class="psx-type-link" data-name="' . $property->getType() . '">' . $property->getType() . '</a></span><br />';
            $html.= '<div class="psx-property-description">' . htmlspecialchars($property->getComment()) . '</div>';
            $html.= !empty($constraints) ? $this->writeConstraints($constraints) : '';
            $html.= '</td>';
            $html.= '</tr>';
        }

        $html.= '</tbody>';
        $html.= '</table>';

        return $html;
    }

    private function generateJson(array $rows): string
    {
        $html = '<span class="psx-object-json-pun">{</span>' . "\n";

        foreach ($rows as $row) {
            [$name, $property] = $row;

            $html.= '  ';
            $html.= '<span class="psx-object-json-key">"' . htmlspecialchars($name) . '"</span>';
            $html.= '<span class="psx-object-json-pun">: </span>';
            $html.= '<span class="psx-property-type">' . $property->getType() . '</span>';
            $html.= '<span class="psx-object-json-pun">,</span>';
            $html.= "\n";
        }

        $html.= '<span class="psx-object-json-pun">}</span>';

        return '<pre class="psx-object-json">' . $html . '</pre>';
    }

    private function getPropertyCssClasses(Code\Property $property): array
    {
        $classes = [];
        $classes[] = $property->isRequired() ? 'psx-property-required' : 'psx-property-optional';

        if ($property->isDeprecated()) {
            $classes[] = 'psx-property-deprecated';
        }

        if ($property->isNullable()) {
            $classes[] = 'psx-property-nullable';
        }

        if ($property->isReadonly()) {
            $classes[] = 'psx-property-readonly';
        }

        return $classes;
    }
}
