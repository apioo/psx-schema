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
use PSX\Schema\Type\AnyPropertyType;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\ArrayTypeInterface;
use PSX\Schema\Type\GenericPropertyType;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\MapTypeInterface;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StructDefinitionType;
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
    private string $refBase;

    public function __construct(?Config $config = null)
    {
        $this->refBase = $config?->get('ref_base') ?? '#/definitions/';
    }

    public function generate(SchemaInterface $schema): Code\Chunks|string
    {
        $data = $this->toArray(
            $schema->getDefinitions(),
            $schema->getRoot()
        );

        return Parser::encode($data);
    }

    public function toArray(DefinitionsInterface $definitions, ?string $root): array
    {
        if ($root !== null) {
            $object = $this->generateType($definitions->getType($root), $definitions);
        } else {
            $object = [];
        }

        $result = [
            'definitions' => $this->generateDefinitions($definitions),
        ];

        return array_merge($result, $object);
    }

    protected function generateDefinitions(DefinitionsInterface $definitions): array
    {
        $result = [];
        $types  = $definitions->getAllTypes();

        ksort($types);

        foreach ($types as $ref => $type) {
            [$ns, $name] = TypeUtil::split($ref);

            $result[$name] = $this->generateType($type, $definitions);
        }

        return $result;
    }

    protected function generateType(TypeInterface $type, DefinitionsInterface $definitions, ?array $template = null)
    {
        TypeUtil::normalize($type);

        if ($type instanceof StructDefinitionType) {
            $data = $type->toArray();
            $data['type'] = 'object';

            if (isset($data['properties'])) {
                $data['properties'] = array_map(function ($property) use ($definitions, $template) {
                    return $this->generateType($property, $definitions, $template);
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
        } elseif ($type instanceof MapTypeInterface) {
            $data = $type->toArray();

            if (isset($data['additionalProperties']) && $data['additionalProperties'] instanceof TypeInterface) {
                $data['additionalProperties'] = $this->generateType($data['additionalProperties'], $definitions, $template);
            }

            return $data;
        } elseif ($type instanceof ArrayTypeInterface) {
            $data = $type->toArray();

            if (isset($data['items']) && $data['items'] instanceof TypeInterface) {
                $data['items'] = $this->generateType($data['items'], $definitions, $template);
            }

            return $data;
        } elseif ($type instanceof ReferencePropertyType) {
            [$ns, $name] = TypeUtil::split($type->getTarget());

            return [
                '$ref' => $this->refBase . $name
            ];
        } elseif ($type instanceof AnyPropertyType) {
            return [];
        } elseif ($type instanceof GenericPropertyType) {
            if (!isset($template[$type->getName()])) {
                // could not resolve generic
                return [];
            }

            $type = $definitions->getType($template[$type->getName()]);

            return $this->generateType($type, $definitions, $template);
        } else {
            return $type->toArray();
        }
    }
}
