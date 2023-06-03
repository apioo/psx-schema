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

namespace PSX\Schema\Parser;

use PSX\Schema\Attribute;
use PSX\Schema\Definitions;
use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\Format;
use PSX\Schema\Parser\Popo\ResolverInterface;
use PSX\Schema\ParserInterface;
use PSX\Schema\Schema;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeFactory;
use PSX\Schema\TypeInterface;
use ReflectionClass;

/**
 * Tries to import the data into a plain old php object
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Popo implements ParserInterface
{
    private ResolverInterface $resolver;

    public function __construct()
    {
        $this->resolver = self::createDefaultResolver();
    }

    /**
     * @inheritDoc
     */
    public function parse(string $schema, ?ContextInterface $context = null): SchemaInterface
    {
        $className = str_replace('.', '\\', $schema);
        $definitions = new Definitions();

        $this->parseClass($className, $definitions);

        $name = (new ReflectionClass($className))->getShortName();
        $type = TypeFactory::getReference($name);

        return new Schema($type, $definitions);
    }

    protected function parseClass(string $className, DefinitionsInterface $definitions): TypeInterface
    {
        $class = new ReflectionClass($className);

        if ($definitions->hasType($class->getShortName())) {
            return $definitions->getType($class->getShortName());
        }

        $type = $this->resolver->resolveClass($class);

        $annotations = [];
        foreach ($class->getAttributes() as $attribute) {
            $annotations[] = $attribute->newInstance();
        }

        $definitions->addType($class->getShortName(), $type);

        if ($type instanceof StructType) {
            $parent = $class->getParentClass();
            if ($parent instanceof \ReflectionClass) {
                $extends = $this->parseClass($parent->getName(), $definitions);
                if ($extends instanceof StructType) {
                    $type->setExtends($parent->getShortName());
                }
            }
        }

        if ($type instanceof TypeAbstract) {
            $this->parseCommonAnnotations($annotations, $type);
        }

        if ($type instanceof StructType) {
            $this->parseStructAnnotations($annotations, $type);
            $this->parseProperties($class, $type, $definitions);
        } elseif ($type instanceof MapType) {
            $this->parseMapAnnotations($annotations, $type);
            $this->parseReferences($type, $definitions);
        } elseif ($type instanceof ReferenceType) {
            $this->parseReferences($type, $definitions);
        } else {
            throw new ParserException('Could not determine class type');
        }

        $type->setAttribute(TypeAbstract::ATTR_CLASS, $class->getName());

        return $type;
    }

    private function parseProperties(ReflectionClass $class, StructType $property, DefinitionsInterface $definitions)
    {
        $properties = Popo\ObjectReader::getProperties($class);
        $mapping    = [];

        foreach ($properties as $key => $reflection) {
            if ($reflection->getDeclaringClass()->getName() !== $class->getName()) {
                // skip properties from inherited classes
                continue;
            }

            if ($key != $reflection->getName()) {
                $mapping[$key] = $reflection->getName();
            }

            $type = $this->parseProperty($reflection);
            if ($type instanceof TypeInterface) {
                $this->parseReferences($type, $definitions);

                $property->addProperty($key, $type);
            }
        }

        if (!empty($mapping)) {
            $property->setAttribute(TypeAbstract::ATTR_MAPPING, $mapping);
        }
    }

    private function parseProperty(\ReflectionProperty $reflection): ?TypeInterface
    {
        $type = $this->resolver->resolveProperty($reflection);

        $annotations = [];
        foreach ($reflection->getAttributes() as $attribute) {
            $annotations[] = $attribute->newInstance();
        }

        if ($type instanceof TypeAbstract) {
            $this->parseCommonAnnotations($annotations, $type);
        }

        if ($type instanceof ScalarType) {
            $this->parseScalarAnnotations($annotations, $type);
        }

        if ($type instanceof MapType) {
            $this->parseMapAnnotations($annotations, $type);
        } elseif ($type instanceof ArrayType) {
            $this->parseArrayAnnotations($annotations, $type);

            // in case the array property contains an union parse the union annotations
            $items = $type->getItems();
            if ($items instanceof UnionType) {
                $this->parseUnionAnnotations($annotations, $items);
            }
        } elseif ($type instanceof StringType) {
            $this->parseStringAnnotations($annotations, $type);
        } elseif ($type instanceof NumberType) {
            $this->parseNumberAnnotations($annotations, $type);
        } elseif ($type instanceof UnionType) {
            $this->parseUnionAnnotations($annotations, $type);
        }

        return $type;
    }

    private function parseCommonAnnotations(array $annotations, TypeAbstract $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Attribute\Title) {
                $type->setTitle($annotation->title);
            } elseif ($annotation instanceof Attribute\Description) {
                $type->setDescription($annotation->description);
            } elseif ($annotation instanceof Attribute\Nullable) {
                $type->setNullable($annotation->nullable);
            } elseif ($annotation instanceof Attribute\Deprecated) {
                $type->setDeprecated($annotation->deprecated);
            } elseif ($annotation instanceof Attribute\Immutable) {
                $type->setReadonly($annotation->readonly);
            }
        }
    }

    private function parseScalarAnnotations(array $annotations, ScalarType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Attribute\Format) {
                $format = Format::tryFrom($annotation->format);
                if ($format !== null) {
                    $type->setFormat($format);
                }
            } elseif ($annotation instanceof Attribute\Enum) {
                $type->setEnum($annotation->enum);
            }
        }
    }

    private function parseStructAnnotations(array $annotations, StructType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Attribute\Required) {
                $type->setRequired($annotation->required);
            }
        }
    }

    private function parseMapAnnotations(array $annotations, MapType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Attribute\MinProperties) {
                $type->setMinProperties($annotation->minProperties);
            } elseif ($annotation instanceof Attribute\MaxProperties) {
                $type->setMaxProperties($annotation->maxProperties);
            }
        }
    }

    private function parseArrayAnnotations(array $annotations, ArrayType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Attribute\MinItems) {
                $type->setMinItems($annotation->minItems);
            } elseif ($annotation instanceof Attribute\MaxItems) {
                $type->setMaxItems($annotation->maxItems);
            } elseif ($annotation instanceof Attribute\UniqueItems) {
                $type->setUniqueItems($annotation->uniqueItems);
            }
        }
    }

    private function parseStringAnnotations(array $annotations, StringType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Attribute\MinLength) {
                $type->setMinLength($annotation->minLength);
            } elseif ($annotation instanceof Attribute\MaxLength) {
                $type->setMaxLength($annotation->maxLength);
            } elseif ($annotation instanceof Attribute\Pattern) {
                $type->setPattern($annotation->pattern);
            } elseif ($annotation instanceof Attribute\Format) {
                $format = Format::tryFrom($annotation->format);
                if ($format !== null) {
                    $type->setFormat($format);
                }
            }
        }
    }

    private function parseNumberAnnotations(array $annotations, NumberType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Attribute\Minimum) {
                $type->setMinimum($annotation->minimum);
            } elseif ($annotation instanceof Attribute\Maximum) {
                $type->setMaximum($annotation->maximum);
            } elseif ($annotation instanceof Attribute\ExclusiveMinimum) {
                $type->setExclusiveMinimum($annotation->exclusiveMinimum);
            } elseif ($annotation instanceof Attribute\ExclusiveMaximum) {
                $type->setExclusiveMaximum($annotation->exclusiveMaximum);
            } elseif ($annotation instanceof Attribute\MultipleOf) {
                $type->setMultipleOf($annotation->multipleOf);
            }
        }
    }

    private function parseUnionAnnotations(array $annotations, UnionType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Attribute\Discriminator) {
                $type->setDiscriminator($annotation->propertyName, $annotation->mapping);
            }
        }
    }

    private function parseReferences(TypeInterface $type, DefinitionsInterface $definitions)
    {
        if ($type instanceof MapType) {
            $additionalProperties = $type->getAdditionalProperties();
            if ($additionalProperties instanceof TypeInterface) {
                $this->parseReferences($additionalProperties, $definitions);
            }
        } elseif ($type instanceof ArrayType) {
            $items = $type->getItems();
            if ($items instanceof TypeInterface) {
                $this->parseReferences($items, $definitions);
            }
        } elseif ($type instanceof UnionType) {
            $items = $type->getOneOf();
            foreach ($items as $item) {
                if ($item instanceof ReferenceType) {
                    $this->parseReferences($item, $definitions);
                }
            }
        } elseif ($type instanceof IntersectionType) {
            $items = $type->getAllOf();
            foreach ($items as $item) {
                if ($item instanceof ReferenceType) {
                    $this->parseReferences($item, $definitions);
                }
            }
        } elseif ($type instanceof ReferenceType) {
            $this->parseRef($type, $definitions);
        }
    }

    private function parseRef(ReferenceType $type, DefinitionsInterface $definitions)
    {
        $className = $type->getRef();
        try {
            $reflection = new ReflectionClass($className);
            $type->setRef($reflection->getShortName());

            $this->parseClass($className, $definitions);
        } catch (\ReflectionException $e) {
            // in this case the class does not exist
        }

        $template = $type->getTemplate();
        if (!empty($template)) {
            $result = [];
            foreach ($template as $key => $className) {
                try {
                    $reflection = new ReflectionClass($className);
                    $result[$key] = $reflection->getShortName();
                    $this->parseClass($className, $definitions);
                } catch (\ReflectionException $e) {
                    // in this case the class does not exist
                }
            }
            $type->setTemplate($result);
        }
    }

    public static function createDefaultResolver(): Popo\ResolverInterface
    {
        return new Popo\Resolver\Composite(
            new Popo\Resolver\Native(),
            new Popo\Resolver\Documentor()
        );
    }
}
