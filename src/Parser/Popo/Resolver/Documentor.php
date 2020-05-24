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

namespace PSX\Schema\Parser\Popo\Resolver;

use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types;
use phpDocumentor\Reflection\Types\ContextFactory;
use PSX\DateTime\Date;
use PSX\DateTime\Time;
use PSX\Schema\Parser\Popo\ResolverInterface;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\TypeFactory;
use PSX\Schema\TypeInterface;
use PSX\Uri\Uri;

/**
 * Documentor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Documentor implements ResolverInterface
{
    /**
     * @var ContextFactory
     */
    private $contextFactory;

    /**
     * @var TypeResolver
     */
    private $typeResolver;

    public function __construct()
    {
        $this->contextFactory = new ContextFactory();
        $this->typeResolver   = new TypeResolver();
    }

    /**
     * @inheritDoc
     */
    public function resolveClass(\ReflectionClass $reflection): ?TypeInterface
    {
        if ($reflection->implementsInterface(\ArrayAccess::class)) {
            $tag = $this->getTag('extends', $reflection->getDocComment());
            if (!empty($tag)) {
                $context = $this->contextFactory->createFromReflector($reflection);
                $type = $this->buildType($this->typeResolver->resolve($tag, $context));

                return $type;
            } else {
                throw new \RuntimeException('Could not determine type of map');
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
            if ($fqsen === '\\' . Date::class) {
                return TypeFactory::getString()->setFormat(TypeAbstract::FORMAT_DATE);
            } elseif ($fqsen === '\\' . \DateTime::class) {
                return TypeFactory::getString()->setFormat(TypeAbstract::FORMAT_DATETIME);
            } elseif ($fqsen === '\\' . Time::class) {
                return TypeFactory::getString()->setFormat(TypeAbstract::FORMAT_TIME);
            } elseif ($fqsen === '\\' . \DateInterval::class) {
                return TypeFactory::getString()->setFormat(TypeAbstract::FORMAT_DURATION);
            } elseif ($fqsen === '\\' . Uri::class) {
                return TypeFactory::getString()->setFormat(TypeAbstract::FORMAT_URI);
            } elseif (!empty($fqsen)) {
                if (class_exists($fqsen)) {
                    return TypeFactory::getReference($fqsen);
                } else {
                    return TypeFactory::getGeneric($type->getFqsen()->getName());
                }
            }
        } elseif ($type instanceof Types\AbstractList) {
            $key = $type->getKeyType();
            $value = $type->getValueType();

            if ($key instanceof Types\Compound) {
                $items = $this->buildType($value);
                if ($items instanceof TypeInterface) {
                    return TypeFactory::getArray()->setItems($items);
                } else {
                    throw new \RuntimeException('Array without type hint');
                }
            } else {
                $additionalProperties = $this->buildType($value);
                if ($additionalProperties instanceof TypeInterface) {
                    return TypeFactory::getMap()->setAdditionalProperties($additionalProperties);
                } else {
                    throw new \RuntimeException('Array without type hint');
                }
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
            return TypeFactory::getString()->setFormat(TypeAbstract::FORMAT_BINARY);
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
