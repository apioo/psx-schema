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

namespace PSX\Schema\Parser\Popo\Resolver;

use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types;
use phpDocumentor\Reflection\Types\ContextFactory;
use PSX\DateTime\Duration;
use PSX\DateTime\LocalDate;
use PSX\DateTime\LocalDateTime;
use PSX\DateTime\LocalTime;
use PSX\DateTime\Period;
use PSX\Record\RecordInterface;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\Format;
use PSX\Schema\Parser\Popo\ResolverInterface;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\TypeFactory;
use PSX\Schema\TypeInterface;
use PSX\Uri\Uri;

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

    /**
     * @inheritDoc
     */
    public function resolveClass(\ReflectionClass $reflection): ?TypeInterface
    {
        if ($reflection->implementsInterface(RecordInterface::class)) {
            $tag = $this->getTag('extends', $reflection->getDocComment());
            if (!empty($tag)) {
                $context = $this->contextFactory->createFromReflector($reflection);
                $type = $this->buildType($this->typeResolver->resolve($tag, $context));

                return $type;
            } else {
                throw new ParserException('Could not determine type of map');
            }
        } else {
            $tag = $this->getTag('extends', $reflection->getDocComment());
            if (!empty($tag)) {
                $parent = $reflection->getParentClass();
                if (!$parent instanceof \ReflectionClass) {
                    // we have no parent class
                    return TypeFactory::getStruct();
                }

                $values = $this->getTemplateValues($reflection, $tag);
                $keys = $this->getTemplateKeys($parent);
                $template = array_combine($keys, $values);

                $reference = TypeFactory::getReference();
                $reference->setRef($parent->getName());
                if (!empty($template)) {
                    $reference->setTemplate($template);
                }
                return $reference;
            } else {
                return TypeFactory::getStruct();
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function resolveProperty(\ReflectionProperty $reflection): ?TypeInterface
    {
        $tag = $this->getTag('var', $reflection->getDocComment());
        if (!empty($tag)) {
            $context = $this->contextFactory->createFromReflector($reflection);
            $type = $this->buildType($this->typeResolver->resolve($tag, $context));

            if ($type instanceof ScalarType) {
                $properties = $reflection->getDeclaringClass()->getDefaultProperties();
                if (isset($properties[$reflection->getName()])) {
                    $type->setConst($properties[$reflection->getName()]);
                }
            }

            return $type;
        }

        return null;
    }

    private function buildType(Type $type): ?TypeInterface
    {
        if ($type instanceof Types\Object_) {
            $fqsen = (string) $type->getFqsen();
            if ($fqsen === '\\' . LocalDate::class) {
                return TypeFactory::getString()->setFormat(Format::DATE);
            } elseif ($fqsen === '\\' . LocalDateTime::class || $fqsen === '\\' . \DateTime::class) {
                return TypeFactory::getString()->setFormat(Format::DATETIME);
            } elseif ($fqsen === '\\' . LocalTime::class) {
                return TypeFactory::getString()->setFormat(Format::TIME);
            } elseif ($fqsen === '\\' . Period::class || $fqsen === '\\' . \DateInterval::class) {
                return TypeFactory::getString()->setFormat(Format::DURATION);
            } elseif ($fqsen === '\\' . Duration::class) {
                return TypeFactory::getString()->setFormat(Format::DURATION);
            } elseif ($fqsen === '\\' . Uri::class) {
                return TypeFactory::getString()->setFormat(Format::URI);
            } elseif (!empty($fqsen)) {
                if (class_exists($fqsen)) {
                    return TypeFactory::getReference($fqsen);
                } else {
                    return TypeFactory::getGeneric($type->getFqsen()->getName());
                }
            }
        } elseif ($type instanceof Types\Collection) {
            $value = $type->getValueType();
            $additionalProperties = $this->buildType($value);
            if ($additionalProperties instanceof TypeInterface) {
                return TypeFactory::getMap($additionalProperties);
            } else {
                throw new ParserException('Map without type hint');
            }
        } elseif ($type instanceof Types\AbstractList) {
            $value = $type->getValueType();
            $items = $this->buildType($value);
            if ($items instanceof TypeInterface) {
                return TypeFactory::getArray($items);
            } else {
                throw new ParserException('Array without type hint');
            }
        } elseif ($type instanceof Types\Boolean) {
            return TypeFactory::getBoolean();
        } elseif ($type instanceof Types\Integer) {
            return TypeFactory::getInteger();
        } elseif ($type instanceof Types\Float_) {
            return TypeFactory::getNumber();
        } elseif ($type instanceof Types\String_) {
            return TypeFactory::getString();
        } elseif ($type instanceof Types\Mixed_) {
            return TypeFactory::getAny();
        } elseif ($type instanceof Types\Resource_) {
            return TypeFactory::getString()->setFormat(Format::BINARY);
        } elseif ($type instanceof Types\Nullable) {
            return $this->buildType($type->getActualType());
        } elseif ($type instanceof Types\Compound) {
            $oneOf = [];
            foreach ($type as $typ) {
                $property = $this->buildType($typ);
                if ($property instanceof TypeInterface) {
                    $oneOf[] = $property;
                }
            }

            if (count($oneOf) > 1) {
                return TypeFactory::getUnion($oneOf);
            } else {
                return reset($oneOf);
            }
        }

        return null;
    }

    private function getTag(string $tag, string $comment): ?string
    {
        preg_match('/@' . $tag . ' (.*)\R/', $comment, $matches);
        return $matches[1] ?? null;
    }

    private function getTemplateValues(\ReflectionClass $reflection, string $tag)
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

    private function getTemplateKeys(\ReflectionClass $reflection)
    {
        $tag = $this->getTag('template', $reflection->getDocComment());
        $keys = array_map('trim', explode(',', $tag));

        // currently we can handle only one type, since we pare also only one value
        return array_slice($keys, 0, 1);
    }
}
