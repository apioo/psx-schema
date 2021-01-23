<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * Java
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Java extends CodeGeneratorAbstract
{
    /**
     * @inheritDoc
     */
    public function getFileName(string $file): string
    {
        return $file . '.java';
    }

    /**
     * @inheritDoc
     */
    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Java($mapping);
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

        $code.= ' {' . "\n";

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . 'private ' . $property->getType() . ' ' . $name . ';' . "\n";
        }

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $code.= $this->indent . 'public void set' . ucfirst($name) . '(' . $property->getType() . ' ' . $name . ') {' . "\n";
            $code.= $this->indent . $this->indent . 'this.' . $name . ' = ' . $name . ';' . "\n";
            $code.= $this->indent . '}' . "\n";

            $code.= $this->indent . 'public ' . $property->getType() . ' get' . ucfirst($name) . '() {' . "\n";
            $code.= $this->indent . $this->indent . 'return this.' . $name . ';' . "\n";
            $code.= $this->indent . '}' . "\n";
        }

        $code.= '}' . "\n";

        return $code;
    }

    protected function writeMap(string $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $code = $this->writeHeader($origin->getDescription());
        $code.= 'public static class ' . $name . '<String, ' . $subType . '> extends HashMap<String, ' . $subType . '> {' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    protected function writeUnion(string $name, string $type, UnionType $origin): string
    {
        $code = $this->writeHeader($origin->getDescription());
        $code.= 'public class ' . $name . ' {' . "\n";
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

        return $code;
    }

    protected function writeIntersection(string $name, string $type, IntersectionType $origin): string
    {
        // @TODO how do we solve this best in Java
        $code = $this->writeHeader($origin->getDescription());
        $code.= 'public class ' . $name . ' {' . "\n";
        $code.= $this->indent . 'private List<object> values = new ArrayList<object>();' . "\n";
        foreach ($origin->getAllOf() as $item) {
            $type = $this->generator->getType($item);

            $code.= $this->indent . 'public void add' . ucfirst($name) . '(' . $type . ' value) {' . "\n";
            $code.= $this->indent . $this->indent . 'this.values.add(value);' . "\n";
            $code.= $this->indent . '}' . "\n";
        }

        $code.= $this->indent . 'public List<object> getValues() {' . "\n";
        $code.= $this->indent . $this->indent . 'return this.values;' . "\n";
        $code.= $this->indent . '}' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    protected function writeReference(string $name, string $type, ReferenceType $origin): string
    {
        $code = $this->writeHeader($origin->getDescription());
        $code.= 'public class ' . $name . ' extends ' . $type . ' {' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    private function writeHeader(?string $comment)
    {
        $code = '';

        if (!empty($this->namespace)) {
            $code.= 'package ' . $this->namespace . ';' . "\n";
        }

        if (!empty($comment)) {
            $code.= '/**' . "\n";
            $code.= ' * ' . $comment . "\n";
            $code.= ' */' . "\n";
        }

        return $code;
    }
}
