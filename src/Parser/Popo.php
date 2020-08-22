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

namespace PSX\Schema\Parser;

use Doctrine\Common\Annotations\Reader;
use PSX\Schema\Annotation;
use PSX\Schema\Definitions;
use PSX\Schema\DefinitionsInterface;
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
 * @link    http://phpsx.org
 */
class Popo implements ParserInterface
{
    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    protected $reader;

    /**
     * @var \PSX\Schema\Parser\Popo\Resolver\Composite
     */
    protected $resolver;

    /**
     * @param \Doctrine\Common\Annotations\Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader   = $reader;
        $this->resolver = self::createDefaultResolver();
    }

    /**
     * @inheritDoc
     */
    public function parse(string $className): SchemaInterface
    {
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
        $annotations = $this->reader->getClassAnnotations($class);

        if ($type instanceof StructType) {
            $parent = $class->getParentClass();
            if ($parent instanceof \ReflectionClass) {
                $extends = $this->parseClass($parent->getName(), $definitions);
                if ($extends instanceof StructType) {
                    $type->setExtends($parent->getShortName());
                }
            }
        }

        $definitions->addType($class->getShortName(), $type);

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
            throw new \RuntimeException('Could not determine class type');
        }

        $type->setAttribute(TypeAbstract::ATTR_CLASS, $class->getName());

        return $type;
    }

    private function parseProperties(ReflectionClass $class, StructType $property, DefinitionsInterface $definitions)
    {
        $properties = Popo\ObjectReader::getProperties($this->reader, $class);
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
        $annotations = $this->reader->getPropertyAnnotations($reflection);

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
            if ($annotation instanceof Annotation\Title) {
                $type->setTitle($annotation->getTitle());
            } elseif ($annotation instanceof Annotation\Description) {
                $type->setDescription($annotation->getDescription());
            } elseif ($annotation instanceof Annotation\Nullable) {
                $type->setNullable($annotation->isNullable());
            } elseif ($annotation instanceof Annotation\Deprecated) {
                $type->setDeprecated($annotation->isDeprecated());
            } elseif ($annotation instanceof Annotation\Readonly) {
                $type->setReadonly($annotation->isReadonly());
            }
        }
    }

    private function parseScalarAnnotations(array $annotations, ScalarType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Format) {
                $type->setFormat($annotation->getFormat());
            } elseif ($annotation instanceof Annotation\Enum) {
                $type->setEnum($annotation->getEnum());
            }
        }
    }

    private function parseStructAnnotations(array $annotations, StructType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Required) {
                $type->setRequired($annotation->getRequired());
            }
        }
    }

    private function parseMapAnnotations(array $annotations, MapType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\MinProperties) {
                $type->setMinProperties($annotation->getMinProperties());
            } elseif ($annotation instanceof Annotation\MaxProperties) {
                $type->setMaxProperties($annotation->getMaxProperties());
            }
        }
    }

    private function parseArrayAnnotations(array $annotations, ArrayType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\MinItems) {
                $type->setMinItems($annotation->getMinItems());
            } elseif ($annotation instanceof Annotation\MaxItems) {
                $type->setMaxItems($annotation->getMaxItems());
            } elseif ($annotation instanceof Annotation\UniqueItems) {
                $type->setUniqueItems($annotation->getUniqueItems());
            }
        }
    }

    private function parseStringAnnotations(array $annotations, StringType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\MinLength) {
                $type->setMinLength($annotation->getMinLength());
            } elseif ($annotation instanceof Annotation\MaxLength) {
                $type->setMaxLength($annotation->getMaxLength());
            } elseif ($annotation instanceof Annotation\Pattern) {
                $type->setPattern($annotation->getPattern());
            } elseif ($annotation instanceof Annotation\Format) {
                $type->setFormat($annotation->getFormat());
            }
        }
    }

    private function parseNumberAnnotations(array $annotations, NumberType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Minimum) {
                $type->setMinimum($annotation->getMinimum());
            } elseif ($annotation instanceof Annotation\Maximum) {
                $type->setMaximum($annotation->getMaximum());
            } elseif ($annotation instanceof Annotation\ExclusiveMinimum) {
                $type->setExclusiveMinimum($annotation->getExclusiveMinimum());
            } elseif ($annotation instanceof Annotation\ExclusiveMaximum) {
                $type->setExclusiveMaximum($annotation->getExclusiveMaximum());
            } elseif ($annotation instanceof Annotation\MultipleOf) {
                $type->setMultipleOf($annotation->getMultipleOf());
            }
        }
    }

    private function parseUnionAnnotations(array $annotations, UnionType $type)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Discriminator) {
                $type->setDiscriminator($annotation->getPropertyName(), $annotation->getMapping() ?: null);
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
