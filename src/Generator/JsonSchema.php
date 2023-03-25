<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PSX\Json\Parser;
use PSX\Schema\DefinitionsInterface;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Type\AnyType;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeInterface;
use PSX\Schema\TypeUtil;

/**
 * JsonSchema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class JsonSchema implements GeneratorInterface
{
    /**
     * @var string
     */
    private $refBase;

    public function __construct(string $refBase = '#/definitions/')
    {
        $this->refBase = $refBase;
    }

    public function generate(SchemaInterface $schema)
    {
        $data = $this->toArray(
            $schema->getType(),
            $schema->getDefinitions()
        );

        return Parser::encode($data, JSON_PRETTY_PRINT);
    }


    /**
     * @param \PSX\Schema\TypeInterface $type
     * @param \PSX\Schema\DefinitionsInterface $definitions
     * @return array
     */
    public function toArray(TypeInterface $type, DefinitionsInterface $definitions)
    {
        $object = $this->generateType($type);

        $result = [
            'definitions' => $this->generateDefinitions($definitions),
        ];

        $result = array_merge($result, $object);

        return $result;
    }

    protected function generateDefinitions(DefinitionsInterface $definitions)
    {
        $result = [];
        $types  = $definitions->getAllTypes();

        ksort($types);

        foreach ($types as $ref => $type) {
            [$ns, $name] = TypeUtil::split($ref);

            $result[$name] = $this->generateType($type);
        }

        return $result;
    }

    protected function generateType(TypeInterface $type)
    {
        TypeUtil::normalize($type);

        if ($type instanceof StructType) {
            $data = $type->toArray();

            if (isset($data['properties'])) {
                $data['properties'] = array_map(function ($property) {
                    return $this->generateType($property);
                }, $data['properties']);
            }

            if (isset($data['$extends'])) {
                $extends = $data['$extends'];
                unset($data['$extends']);

                [$ns, $name] = TypeUtil::split($extends);

                return [
                    'allOf' => [
                        ['$ref' => $this->refBase . $name],
                        $data,
                    ]
                ];
            } else {
                return $data;
            }
        } elseif ($type instanceof MapType) {
            $data = $type->toArray();

            if (isset($data['additionalProperties']) && $data['additionalProperties'] instanceof TypeInterface) {
                $data['additionalProperties'] = $this->generateType($data['additionalProperties']);
            }

            return $data;
        } elseif ($type instanceof ArrayType) {
            $data = $type->toArray();

            if (isset($data['items']) && $data['items'] instanceof TypeInterface) {
                $data['items'] = $this->generateType($data['items']);
            }

            return $data;
        } elseif ($type instanceof UnionType) {
            $data = $type->toArray();

            if (isset($data['oneOf'])) {
                $data['oneOf'] = array_map(function($type){
                    return $this->generateType($type);
                }, $data['oneOf']);
            }

            return $data;
        } elseif ($type instanceof IntersectionType) {
            $data = $type->toArray();

            if (isset($data['allOf'])) {
                $data['allOf'] = array_map(function($type){
                    return $this->generateType($type);
                }, $data['allOf']);
            }

            return $data;
        } elseif ($type instanceof ReferenceType) {
            [$ns, $name] = TypeUtil::split($type->getRef());

            return [
                '$ref' => $this->refBase . $name
            ];
        } elseif ($type instanceof AnyType) {
            return [];
        } else {
            return $type->toArray();
        }
    }
}
