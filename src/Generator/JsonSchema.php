<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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
use PSX\Schema\Exception\GeneratorException;
use PSX\Schema\Exception\TypeNotFoundException;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Type\AnyPropertyType;
use PSX\Schema\Type\ArrayTypeInterface;
use PSX\Schema\Type\Factory\PropertyTypeFactory;
use PSX\Schema\Type\GenericPropertyType;
use PSX\Schema\Type\MapTypeInterface;
use PSX\Schema\Type\PropertyTypeAbstract;
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
        try {
            $data = $this->toArray($schema->getDefinitions(), $schema->getRoot());

            return Parser::encode($data);
        } catch (TypeNotFoundException|\JsonException $e) {
            throw new GeneratorException($e->getMessage(), previous: $e);
        }
    }

    /**
     * @throws GeneratorException
     * @throws TypeNotFoundException
     */
    public function toArray(DefinitionsInterface $definitions, ?string $root): array
    {
        $result = [];

        if ($root !== null && $definitions->hasType($root)) {
            $object = $this->generateType($definitions->getType($root), $definitions);
            $definitions->removeType($root);
        } else {
            $object = [];
        }

        if (!$definitions->isEmpty()) {
            $result['definitions'] = $this->generateDefinitions($definitions);
        }

        return array_merge($result, $object);
    }

    /**
     * @throws GeneratorException
     * @throws TypeNotFoundException
     */
    public function toProperty(PropertyTypeAbstract $type, DefinitionsInterface $definitions): mixed
    {
        return $this->generateType($type, $definitions);
    }

    /**
     * @throws GeneratorException
     * @throws TypeNotFoundException
     */
    protected function generateDefinitions(DefinitionsInterface $definitions): array
    {
        $result = [];
        $types  = $definitions->getAllTypes();

        ksort($types);

        foreach ($types as $ref => $type) {
            [$ns, $name] = TypeUtil::split($ref);

            // we skip generic types, those are resolved inline
            if (TypeUtil::contains($type, GenericPropertyType::class)) {
                continue;
            }

            $result[$name] = $this->generateType($type, $definitions);
        }

        return $result;
    }

    /**
     * @throws GeneratorException
     * @throws TypeNotFoundException
     */
    protected function generateType(TypeInterface $type, DefinitionsInterface $definitions, ?array $template = null)
    {
        TypeUtil::normalize($type);

        if ($type instanceof StructDefinitionType) {
            $data = $type->toArray();
            $data['type'] = 'object';

            $parent = $type->getParent();
            if ($parent instanceof ReferencePropertyType) {
                $template = $parent->getTemplate();
            }

            if (isset($data['properties'])) {
                $data['properties'] = array_map(function ($property) use ($definitions, $template) {
                    return $this->generateType($property, $definitions, $template);
                }, $data['properties']);
            }

            if ($parent instanceof ReferencePropertyType) {
                unset($data['parent']);

                return [
                    'allOf' => [
                        $this->generateType($parent, $definitions, $template),
                        $data,
                    ]
                ];
            } else {
                return $data;
            }
        } elseif ($type instanceof MapTypeInterface) {
            $data = $type->toArray();
            $data['type'] = 'object';

            if (isset($data['schema']) && $data['schema'] instanceof TypeInterface) {
                $data['additionalProperties'] = $this->generateType($data['schema'], $definitions, $template);
                unset($data['schema']);
            }

            return $data;
        } elseif ($type instanceof ArrayTypeInterface) {
            $data = $type->toArray();
            $data['type'] = 'array';

            if (isset($data['schema']) && $data['schema'] instanceof TypeInterface) {
                $data['items'] = $this->generateType($data['schema'], $definitions, $template);
                unset($data['schema']);
            }

            return $data;
        } elseif ($type instanceof ReferencePropertyType) {
            $targetType = $definitions->getType($type->getTarget());
            $hasGenerics = TypeUtil::contains($targetType, GenericPropertyType::class);

            if ($hasGenerics) {
                // in case the referenced type has generics we resolve
                return $this->generateType($targetType, $definitions, $type->getTemplate());
            } else {
                [$ns, $name] = TypeUtil::split($type->getTarget());

                return [
                    '$ref' => $this->refBase . $name
                ];
            }
        } elseif ($type instanceof AnyPropertyType) {
            return (object) [];
        } elseif ($type instanceof GenericPropertyType) {
            $target = $template[$type->getName()] ?? throw new GeneratorException('Could not resolve generic type ' . $type->getName());

            return $this->generateType(PropertyTypeFactory::getReference($target), $definitions, $template);
        } else {
            return $type->toArray();
        }
    }
}
