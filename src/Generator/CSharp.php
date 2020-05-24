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

use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\UnionType;

/**
 * CSharp
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class CSharp extends CodeGeneratorAbstract
{
    /**
     * @inheritDoc
     */
    public function getFileName(string $file): string
    {
        return $file . '.cs';
    }

    /**
     * @inheritDoc
     */
    protected function newTypeGenerator(): GeneratorInterface
    {
        return new Type\CSharp();
    }

    /**
     * @inheritDoc
     */
    protected function writeStruct(string $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = $this->writeHeader($origin->getDescription());
        $code.= 'public class ' . $name;

        if (!empty($generics)) {
            $code.= '<' . implode(', ', $generics) . '>';
        }

        if (!empty($extends)) {
            $code.= ' extends ' . $extends;
        }

        $code.= "\n";
        $code.= '{' . "\n";

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . 'public ' . $property->getType() . ' ' . ucfirst($name) . ' { get; set; }' . "\n";
        }

        $code.= '}' . "\n";
        $code.= $this->writerFooter();

        return $code;
    }

    protected function writeMap(string $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $code = $this->writeHeader($origin->getDescription());
        $code.= 'public class ' . $name . '<string, ' . $subType . '> : IDictionary<string, ' . $subType . '>' . "\n";
        $code.= '{' . "\n";
        $code.= '}' . "\n";
        $code.= $this->writerFooter();

        return $code;
    }

    protected function writeUnion(string $name, string $type, UnionType $origin): string
    {
        // @TODO how do we solve this best in C#
        $code = $this->writeHeader($origin->getDescription());
        $code.= 'public class ' . $name . ' : ' . $type . "\n";
        $code.= '{' . "\n";
        $code.= $this->indent . 'private object value;' . "\n";
        foreach ($origin->getOneOf() as $item) {
            $type = $this->generator->getType($item);

            $code.= $this->indent . 'public void set' . ucfirst($name) . '(' . $type . ' value) {' . "\n";
            $code.= $this->indent . $this->indent . 'this.value = value;' . "\n";
            $code.= $this->indent . '}' . "\n";
        }

        $code.= $this->indent . 'public object getValue() {' . "\n";
        $code.= $this->indent . $this->indent . 'return this.value;' . "\n";
        $code.= $this->indent . '}' . "\n";
        $code.= '}' . "\n";
        $code.= $this->writerFooter();

        return $code;
    }

    protected function writeIntersection(string $name, string $type, IntersectionType $origin): string
    {
        // @TODO how do we solve this best in C#
        $code = $this->writeHeader($origin->getDescription());
        $code.= 'public class ' . $name . ' : ' . $type . "\n";
        $code.= '{' . "\n";
        $code.= $this->indent . 'private List<object> values = new List<object>();' . "\n";
        foreach ($origin->getAllOf() as $item) {
            $type = $this->generator->getType($item);

            $code.= $this->indent . 'public void add' . ucfirst($name) . '(' . $type . ' value) {' . "\n";
            $code.= $this->indent . $this->indent . 'this.values.add(value);' . "\n";
            $code.= $this->indent . '}' . "\n";
        }

        $code.= $this->indent . 'public List<object> getValues() {' . "\n";
        $code.= $this->indent . $this->indent . 'return this.values;' . "\n";
        $code.= $this->indent . '}' . "\n";
        $code.= $this->writerFooter();

        return $code;
    }

    protected function writeReference(string $name, string $type, ReferenceType $origin): string
    {
        $code = $this->writeHeader($origin->getDescription());
        $code.= 'public class ' . $name . ' : ' . $type . "\n";
        $code.= '{' . "\n";
        $code.= '}' . "\n";
        $code.= $this->writerFooter();

        return $code;
    }

    private function writeHeader(?string $comment)
    {
        $code = '';

        if (!empty($this->namespace)) {
            $code.= 'namespace ' . $this->namespace . "\n";
            $code.= '{' . "\n";
        }

        if (!empty($comment)) {
            $code.= '/// <summary>' . "\n";
            $code.= '/// ' . $comment . "\n";
            $code.= '/// </summary>' . "\n";
        }

        return $code;
    }

    private function writerFooter()
    {
        if (!empty($this->namespace)) {
            return '}' . "\n";
        } else {
            return '';
        }
    }
}
