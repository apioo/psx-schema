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

use JsonException;
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
use PSX\Schema\Type\ScalarPropertyType;
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
    private const ATTRIBUTE_DISCRIMINATOR_TYPE = 'discriminator_type';
    private const ATTRIBUTE_DISCRIMINATOR_VALUE = 'discriminator_value';

    private string $definitionKey;
    private string $refBase;
    private bool $inlineDefinitions;
    private bool $defsKeyword;
    private bool $allPropertiesRequired;
    private bool $additionalPropertiesFalse;
    private bool $anyOfDiscriminatedUnion;
    private bool $resolveParentProperties;
    private bool $anyOfNullable;
    private bool $typeNullable;
    private bool $discriminatedValueAsEnum;
    private bool $removeDeprecatedProperty;
    private bool $removeNullableProperty;
    private bool $removeDefaultProperty;
    private bool $removeFormatProperty;
    private bool $anyValueAsString;
    private bool $normalizePropertyNames;

    public function __construct(?Config $config = null)
    {
        $openAIMode = (bool) ($config?->get('openai_mode') ?? false);
        if ($openAIMode === true) {
            $config = JsonSchemaOpenAI::getConfig($config);
        }

        $this->inlineDefinitions = (bool) ($config?->get('inline_definitions') ?? false);
        $this->defsKeyword = (bool) ($config?->get('defs_keyword') ?? false);
        $this->allPropertiesRequired = (bool) ($config?->get('all_properties_required') ?? false);
        $this->additionalPropertiesFalse = (bool) ($config?->get('additional_properties_false') ?? false);
        $this->anyOfDiscriminatedUnion = (bool) ($config?->get('any_of_discriminated_union') ?? false);
        $this->resolveParentProperties = (bool) ($config?->get('resolve_parent_properties') ?? false);
        $this->anyOfNullable = (bool) ($config?->get('any_of_nullable') ?? false);
        $this->typeNullable = (bool) ($config?->get('type_nullable') ?? false);
        $this->discriminatedValueAsEnum = (bool) ($config?->get('discriminated_value_as_enum') ?? false);
        $this->removeDeprecatedProperty = (bool) ($config?->get('remove_deprecated_property') ?? false);
        $this->removeNullableProperty = (bool) ($config?->get('remove_nullable_property') ?? false);
        $this->removeDefaultProperty = (bool) ($config?->get('remove_default_property') ?? false);
        $this->removeFormatProperty = (bool) ($config?->get('remove_format_property') ?? false);
        $this->anyValueAsString = (bool) ($config?->get('any_value_as_string') ?? false);
        $this->normalizePropertyNames = (bool) ($config?->get('normalize_property_names') ?? false);

        $this->definitionKey = $this->defsKeyword ? '$defs' : 'definitions';
        $this->refBase = $config?->get('ref_base') ?? '#/' . $this->definitionKey . '/';
    }

    public function generate(SchemaInterface $schema): Code\Chunks|string
    {
        try {
            $data = $this->toArray($schema->getDefinitions(), $schema->getRoot());

            return Parser::encode($data);
        } catch (TypeNotFoundException|JsonException $e) {
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

        if ($this->inlineDefinitions === false && !$definitions->isEmpty()) {
            $result[$this->definitionKey] = $this->generateDefinitions($definitions);
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

        if ($this->discriminatedValueAsEnum) {
            foreach ($types as $type) {
                if (!$type instanceof StructDefinitionType) {
                    continue;
                }

                $this->setDiscriminatorType($type, $definitions);
            }
        }

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

        $data = $type->toArray();

        if ($this->removeDeprecatedProperty && isset($data['deprecated'])) {
            unset($data['deprecated']);
        }

        if ($this->removeNullableProperty && isset($data['nullable'])) {
            unset($data['nullable']);
        }

        if ($this->removeDefaultProperty && isset($data['default'])) {
            unset($data['default']);
        }

        if ($this->removeFormatProperty && isset($data['format'])) {
            unset($data['format']);
        }

        if ($type instanceof StructDefinitionType) {
            $data['type'] = 'object';

            if (isset($data['base'])) {
                unset($data['base']);
            }

            $discriminator = null;
            if (isset($data['discriminator'])) {
                $discriminator = $data['discriminator'];
                unset($data['discriminator']);
            }

            $mapping = null;
            if (isset($data['mapping'])) {
                $mapping = $data['mapping'];
                unset($data['mapping']);
            }

            if (!empty($discriminator) && !empty($mapping)) {
                if ($this->anyOfDiscriminatedUnion) {
                    return $this->resolveAnyOfDiscriminatedUnion($mapping);
                } else {
                    return $this->resolveDiscriminatedUnion($discriminator, $mapping);
                }
            }

            $parent = $type->getParent();
            if ($parent instanceof ReferencePropertyType) {
                $template = $parent->getTemplate();

                unset($data['parent']);
            }

            $parentProperties = [];
            $parentRequired = [];
            if ($this->resolveParentProperties && $parent instanceof ReferencePropertyType) {
                $resolvedParent = $definitions->getType($parent->getTarget());
                $parentType = $this->generateType($resolvedParent, $definitions, $template);

                if (isset($parentType['properties'])) {
                    $parentProperties = $parentType['properties'];
                }

                if (isset($parentType['required'])) {
                    $parentRequired = $parentType['required'];
                }
            }

            $properties = [];
            $required = [];
            if (isset($data['properties'])) {
                $sourceDiscriminatorType = $type->getAttribute(self::ATTRIBUTE_DISCRIMINATOR_TYPE);
                $sourceDiscriminatorValue = $type->getAttribute(self::ATTRIBUTE_DISCRIMINATOR_VALUE);

                foreach ($data['properties'] as $key => $property) {
                    if ($this->normalizePropertyNames) {
                        $key = self::normalizePropertyName($key);
                    }

                    $properties[$key] = $this->generateType($property, $definitions, $template);

                    if ($property instanceof ScalarPropertyType) {
                        if (!empty($sourceDiscriminatorType) && $sourceDiscriminatorType === $key && !empty($sourceDiscriminatorValue)) {
                            $properties[$key]['enum'] = [$sourceDiscriminatorValue];

                            if (isset($properties[$key]['default'])) {
                                unset($properties[$key]['default']);
                            }
                        } elseif ($property->isNullable() === true) {
                            if ($this->anyOfNullable) {
                                $nullableType = [];
                                if (isset($properties[$key]['description'])) {
                                    $nullableType['description'] = $properties[$key]['description'];
                                    unset($properties[$key]['description']);
                                }

                                $nullableType['anyOf'] = [
                                    $properties[$key],
                                    ['type' => null]
                                ];

                                $properties[$key] = $nullableType;
                            } elseif ($this->typeNullable) {
                                $propertyType = $properties[$key]['type'] ?? null;
                                if (is_string($propertyType)) {
                                    $properties[$key]['type'] = [$propertyType, 'null'];
                                }
                            }
                        }
                    }

                    if ($property instanceof PropertyTypeAbstract && ($property->isNullable() === false || $this->allPropertiesRequired)) {
                        $required[] = $key;
                    }
                }
            }

            $allProperties = array_merge($parentProperties, $properties);
            if (count($allProperties) > 0) {
                $data['properties'] = $allProperties;
            }

            $allRequired = array_values(array_unique(array_merge($parentRequired, $required)));
            if (count($allRequired) > 0) {
                $data['required'] = $allRequired;
            }

            if ($this->additionalPropertiesFalse) {
                $data['additionalProperties'] = false;
            }

            if (!$this->resolveParentProperties && $parent instanceof ReferencePropertyType) {
                if (!isset($data['properties'])) {
                    // in case $data is of type object and has no other properties we can simply return the type
                    return $this->generateType($parent, $definitions, $template);
                } else {
                    return [
                        'allOf' => [
                            $this->generateType($parent, $definitions, $template),
                            $data,
                        ]
                    ];
                }
            } else {
                return $data;
            }
        } elseif ($type instanceof MapTypeInterface) {
            $data['type'] = 'object';

            if ($this->additionalPropertiesFalse) {
                $data['properties'] = (object) [];
                $data['additionalProperties'] = false;
                unset($data['schema']);
            } elseif (isset($data['schema']) && $data['schema'] instanceof TypeInterface) {
                $data['additionalProperties'] = $this->generateType($data['schema'], $definitions, $template);
                unset($data['schema']);
            }

            return $data;
        } elseif ($type instanceof ArrayTypeInterface) {
            $data['type'] = 'array';

            if (isset($data['schema']) && $data['schema'] instanceof TypeInterface) {
                $data['items'] = $this->generateType($data['schema'], $definitions, $template);
                unset($data['schema']);
            }

            return $data;
        } elseif ($type instanceof ReferencePropertyType) {
            $target = $type->getTarget();
            if (empty($target)) {
                return (object) [];
            }

            $targetType = $definitions->getType($target);
            $hasGenerics = TypeUtil::contains($targetType, GenericPropertyType::class);

            if ($hasGenerics) {
                // in case the referenced type has generics we resolve
                return $this->generateType($targetType, $definitions, $type->getTemplate());
            } else {
                if ($this->inlineDefinitions === false) {
                    [$ns, $name] = TypeUtil::split($target);

                    return [
                        '$ref' => $this->refBase . $name
                    ];
                } else {
                    return $this->generateType($targetType, $definitions);
                }
            }
        } elseif ($type instanceof AnyPropertyType) {
            if ($this->anyValueAsString) {
                $data['type'] = 'string';

                return (object) $data;
            } else {
                return (object) [];
            }
        } elseif ($type instanceof GenericPropertyType) {
            $target = $template[$type->getName()] ?? throw new GeneratorException('Could not resolve generic type ' . $type->getName());

            return $this->generateType(PropertyTypeFactory::getReference($target), $definitions, $template);
        } else {
            return $data;
        }
    }

    private function resolveDiscriminatedUnion(string $discriminator, array $mapping): array
    {
        $items = [];
        $mappingValues = [];
        foreach ($mapping as $mappingTypeName => $mappingValue) {
            $ref = $this->refBase . $mappingTypeName;

            $items[] = [
                '$ref' => $ref,
            ];

            $mappingValues[$mappingValue] = $ref;
        }

        return [
            'oneOf' => $items,
            'discriminator' => $discriminator,
            'mapping' => $mappingValues,
        ];
    }

    private function resolveAnyOfDiscriminatedUnion(array $mapping): array
    {
        $items = [];
        foreach ($mapping as $mappingTypeName => $mappingValue) {
            $ref = $this->refBase . $mappingTypeName;

            $items[] = [
                '$ref' => $ref,
            ];
        }

        return [
            'anyOf' => $items,
        ];
    }

    private function setDiscriminatorType(StructDefinitionType $type, DefinitionsInterface $definitions): void
    {
        $discriminator = $type->getDiscriminator();
        $mapping = $type->getMapping();

        if (empty($discriminator) || empty($mapping)) {
            return;
        }

        foreach ($mapping as $mappingTypeName => $mappingValue) {
            $type = $definitions->getType($mappingTypeName);
            if (!$type instanceof StructDefinitionType) {
                continue;
            }

            $type->setAttribute(self::ATTRIBUTE_DISCRIMINATOR_TYPE, $discriminator);
            $type->setAttribute(self::ATTRIBUTE_DISCRIMINATOR_VALUE, $mappingValue);
        }
    }

    public static function normalizePropertyName(string $propertyName): string
    {
        $propertyName = preg_replace('/[^A-Za-z0-9_-]/', '_', $propertyName);
        $propertyName = preg_replace('/_+/', '_', $propertyName);

        if (strlen($propertyName) > 64) {
            $propertyName = substr($propertyName, 0, 64);
        }

        return rtrim($propertyName, '_');
    }
}
