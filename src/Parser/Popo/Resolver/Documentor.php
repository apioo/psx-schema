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

namespace PSX\Schema\Parser\Popo\Resolver;

use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types;
use phpDocumentor\Reflection\Types\ContextFactory;
use PSX\DateTime\LocalDate;
use PSX\DateTime\LocalDateTime;
use PSX\DateTime\LocalTime;
use PSX\Record\ArrayList;
use PSX\Record\HashMap;
use PSX\Record\RecordInterface;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\Parser\Popo\ResolverInterface;
use PSX\Schema\Type\CollectionPropertyType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\Factory\DefinitionTypeFactory;
use PSX\Schema\Type\Factory\PropertyTypeFactory;
use PSX\Schema\Type\PropertyTypeAbstract;

/**
 * Documentor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Documentor implements ResolverInterface
{
    private ContextFactory $contextFactory;
    private TypeResolver $typeResolver;

    public function __construct()
    {
        $this->contextFactory = new ContextFactory();
        $this->typeResolver = new TypeResolver();
    }

    public function resolveClass(\ReflectionClass $reflection): ?DefinitionTypeAbstract
    {
        if ($this->hasParent($reflection, \ArrayObject::class) || $reflection->implementsInterface(RecordInterface::class)) {
            $tag = $this->getTag('extends', $reflection->getDocComment());
            if (empty($tag)) {
                throw new ParserException('Could not determine type of map');
            }

            $context = $this->contextFactory->createFromReflector($reflection);
            $schema = $this->buildPropertyType($this->typeResolver->resolve($tag, $context));

            if ($schema instanceof CollectionPropertyType) {
                return DefinitionTypeFactory::getMap($schema->getSchema());
            } else {
                return DefinitionTypeFactory::getMap($schema);
            }
        } elseif ($this->hasParent($reflection, \ArrayIterator::class)) {
            $tag = $this->getTag('extends', $reflection->getDocComment());
            if (empty($tag)) {
                throw new ParserException('Could not determine type of map');
            }

            $context = $this->contextFactory->createFromReflector($reflection);
            $schema = $this->buildPropertyType($this->typeResolver->resolve($tag, $context));

            if ($schema instanceof CollectionPropertyType) {
                return DefinitionTypeFactory::getArray($schema->getSchema());
            } else {
                return DefinitionTypeFactory::getArray($schema);
            }
        } else {
            $struct = DefinitionTypeFactory::getStruct();

            if ($reflection->isAbstract()) {
                $struct->setBase(true);
            }

            $parentClass = $reflection->getParentClass();
            if (!$parentClass instanceof \ReflectionClass) {
                // we have no parent class
                return $struct;
            }

            $parent = PropertyTypeFactory::getReference($parentClass->getName());

            $tag = $this->getTag('extends', $reflection->getDocComment());
            if (!empty($tag)) {
                $values = $this->getTemplateValues($reflection, $tag);
                $keys = $this->getTemplateKeys($parentClass);
                if (count($keys) > 0 && count($keys) === count($values)) {
                    $template = array_combine($keys, $values);
                    $parent->setTemplate($template);
                }
            }

            $struct->setParent($parent);

            return $struct;
        }
    }

    public function resolveProperty(\ReflectionProperty $reflection): ?PropertyTypeAbstract
    {
        $tag = $this->getTag('var', $reflection->getDocComment());
        if (empty($tag)) {
            return null;
        }

        $context = $this->contextFactory->createFromReflector($reflection);

        return $this->buildPropertyType($this->typeResolver->resolve($tag, $context));
    }

    private function buildPropertyType(Type $type): ?PropertyTypeAbstract
    {
        if ($type instanceof Types\Object_) {
            $fqsen = (string) $type->getFqsen();
            if ($fqsen === '\\' . LocalDate::class) {
                return PropertyTypeFactory::getDate();
            } elseif ($fqsen === '\\' . LocalDateTime::class || $fqsen === '\\' . \DateTime::class || $fqsen === '\\' . \DateTimeInterface::class) {
                return PropertyTypeFactory::getDateTime();
            } elseif ($fqsen === '\\' . LocalTime::class) {
                return PropertyTypeFactory::getTime();
            } elseif (!empty($fqsen)) {
                if (class_exists($fqsen)) {
                    return PropertyTypeFactory::getReference($fqsen);
                } else {
                    return PropertyTypeFactory::getGeneric($type->getFqsen()->getName());
                }
            }
        } elseif ($type instanceof Types\Collection) {
            $value = $type->getValueType();
            $schema = $this->buildPropertyType($value);
            if ($schema instanceof PropertyTypeAbstract) {
                return PropertyTypeFactory::getMap($schema);
            } else {
                throw new ParserException('Map without type hint');
            }
        } elseif ($type instanceof Types\AbstractList) {
            $value = $type->getValueType();
            $schema = $this->buildPropertyType($value);
            if ($schema instanceof PropertyTypeAbstract) {
                return PropertyTypeFactory::getArray($schema);
            } else {
                throw new ParserException('Array without type hint');
            }
        } elseif ($type instanceof Types\Boolean) {
            return PropertyTypeFactory::getBoolean();
        } elseif ($type instanceof Types\Integer) {
            return PropertyTypeFactory::getInteger();
        } elseif ($type instanceof Types\Float_) {
            return PropertyTypeFactory::getNumber();
        } elseif ($type instanceof Types\String_) {
            return PropertyTypeFactory::getString();
        } elseif ($type instanceof Types\Mixed_) {
            return PropertyTypeFactory::getAny();
        } elseif ($type instanceof Types\Nullable) {
            return $this->buildPropertyType($type->getActualType());
        } elseif ($type instanceof Types\Compound) {
            // compound types are only used i.e. array<string>|null so we always use the first type
            return $this->buildPropertyType($type->get(0));
        }

        return null;
    }

    private function getTag(string $tag, string $comment): ?string
    {
        preg_match('/@' . $tag . ' (.*)\R/', $comment, $matches);
        return $matches[1] ?? null;
    }

    private function getTemplateValues(\ReflectionClass $reflection, string $tag): array
    {
        $values = [];
        $context = $this->contextFactory->createFromReflector($reflection);
        $type = $this->typeResolver->resolve($tag, $context);

        if ($type instanceof Types\Collection) {
            $value = $type->getValueType();
            if ($value instanceof Types\Object_) {
                $values[] = (string) $value->getFqsen();
            }
        }

        return $values;
    }

    private function getTemplateKeys(\ReflectionClass $reflection): array
    {
        $tag = $this->getTag('template', $reflection->getDocComment());
        if (empty($tag)) {
            return [];
        }

        $keys = array_map('trim', explode(',', $tag));

        // currently we can handle only one type, since we pare also only one value
        return array_slice($keys, 0, 1);
    }

    private function hasParent(\ReflectionClass $reflection, string $class): bool
    {
        $parent = $reflection->getParentClass();
        if (!$parent instanceof \ReflectionClass) {
            return false;
        }

        return $parent->getName() === $class;
    }
}
