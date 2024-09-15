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

namespace PSX\Schema\Generator\Type;

use PSX\Schema\ContentType;
use PSX\Schema\Exception\GeneratorException;
use PSX\Schema\Format;
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\GenericType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeInterface;
use PSX\Schema\TypeUtil;

/**
 * GeneratorAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class GeneratorAbstract implements GeneratorInterface
{
    private array $mapping;
    private NormalizerInterface $normalizer;

    public function __construct(array $mapping, NormalizerInterface $normalizer)
    {
        $this->mapping = $mapping;
        $this->normalizer = $normalizer;
    }

    public function getType(TypeInterface $type): string
    {
        if ($type instanceof StringType) {
            return $this->getStringType($type);
        } elseif ($type instanceof IntegerType) {
            return $this->getIntegerType($type);
        } elseif ($type instanceof NumberType) {
            return $this->getNumber();
        } elseif ($type instanceof BooleanType) {
            return $this->getBoolean();
        } elseif ($type instanceof ArrayType) {
            return $this->getArray($this->getType($type->getItems()));
        } elseif ($type instanceof StructType) {
            throw new GeneratorException('Could not determine name of anonymous struct, use a reference to the definitions instead');
        } elseif ($type instanceof MapType) {
            return $this->getMap($this->getType($type->getAdditionalProperties()));
        } elseif ($type instanceof UnionType) {
            return $this->getUnion($this->getCombinationType($type->getOneOf()));
        } elseif ($type instanceof IntersectionType) {
            return $this->getIntersection($this->getCombinationType($type->getAllOf()));
        } elseif ($type instanceof ReferenceType) {
            $template = $type->getTemplate();
            if (!empty($template)) {
                $types = [];
                foreach ($template as $value) {
                    $types[] = $this->getReference($value);
                }
                return $this->getReference($type->getRef()) . $this->getGeneric($types);
            } else {
                return $this->getReference($type->getRef());
            }
        } elseif ($type instanceof GenericType) {
            return $type->getGeneric() ?? '';
        }

        return $this->getAny();
    }

    public function getDocType(TypeInterface $type): string
    {
        return $this->getType($type);
    }

    public function getContentType(ContentType $contentType, int $context): string
    {
        return $this->getString();
    }

    abstract protected function getString(): string;

    protected function getStringFormat(Format $format): string
    {
        return $this->getString();
    }

    abstract protected function getInteger(): string;

    protected function getIntegerFormat(Format $format): string
    {
        return $this->getNumber();
    }

    abstract protected function getNumber(): string;

    abstract protected function getBoolean(): string;

    abstract protected function getArray(string $type): string;

    abstract protected function getMap(string $type): string;

    abstract protected function getUnion(array $types): string;

    abstract protected function getIntersection(array $types): string;

    abstract protected function getGroup(string $type): string;

    protected function getReference(string $ref): string
    {
        [$ns, $name] = TypeUtil::split($ref);

        if (!empty($ns) && isset($this->mapping[$ns])) {
            $name = $this->getNamespaced($this->mapping[$ns], $this->normalizer->class($name));
        } else {
            $name = $this->normalizer->class($name);
        }

        return $name;
    }

    abstract protected function getGeneric(array $types): string;

    abstract protected function getAny(): string;

    abstract protected function getNamespaced(string $namespace, string $name): string;

    private function getStringType(StringType $type): string
    {
        $format = $type->getFormat();
        if ($format !== null) {
            return $this->getStringFormat($format);
        } else {
            return $this->getString();
        }
    }

    private function getIntegerType(IntegerType $type): string
    {
        $format = $type->getFormat();
        if ($format !== null) {
            return $this->getIntegerFormat($format);
        } else {
            return $this->getInteger();
        }
    }

    private function getCombinationType(array $properties): array
    {
        $types = [];
        foreach ($properties as $property) {
            $type = $this->getType($property);
            if ($property instanceof UnionType || $property instanceof IntersectionType) {
                $types[] = $this->getGroup($type);
            } else {
                $types[] = $type;
            }
        }

        return $types;
    }
}
