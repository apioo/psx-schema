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
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeUtil;

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
    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\CSharp($mapping);
    }

    /**
     * @inheritDoc
     */
    protected function writeStruct(string $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $code = 'public class ' . $name;

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

        return $code;
    }

    protected function writeMap(string $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $code = 'public class ' . $name . ' : Dictionary<string, ' . $subType . '>' . "\n";
        $code.= '{' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    protected function writeReference(string $name, string $type, ReferenceType $origin): string
    {
        $code = 'public class ' . $name . ' : ' . $type . "\n";
        $code.= '{' . "\n";
        $code.= '}' . "\n";

        return $code;
    }

    protected function writeHeader(TypeAbstract $origin): string
    {
        $code = '';

        if (!empty($this->namespace)) {
            $code.= 'namespace ' . $this->namespace . "\n";
            $code.= '{' . "\n";
        }

        $imports = $this->getImports($origin);
        if (!empty($imports)) {
            $code.= "\n";
            $code.= implode("\n", $imports);
            $code.= "\n";
        }

        $code.= "\n";

        $comment = $origin->getDescription();
        if (!empty($comment)) {
            $code.= '/// <summary>' . "\n";
            $code.= '/// ' . $comment . "\n";
            $code.= '/// </summary>' . "\n";
        }

        return $code;
    }

    protected function writeFooter(TypeAbstract $origin): string
    {
        if (!empty($this->namespace)) {
            return '}' . "\n";
        } else {
            return '';
        }
    }

    private function getImports(TypeAbstract $origin): array
    {
        $imports = [];

        if (TypeUtil::contains($origin, MapType::class)) {
            $imports[] = 'using System.Collections.Generic;';
        }

        return $imports;
    }
}
