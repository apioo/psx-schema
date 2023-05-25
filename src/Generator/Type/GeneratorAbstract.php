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

    protected function getDate(): string
    {
        return $this->getString();
    }

    protected function getDateTime(): string
    {
        return $this->getString();
    }

    protected function getTime(): string
    {
        return $this->getString();
    }

    protected function getPeriod(): string
    {
        return $this->getString();
    }

    protected function getDuration(): string
    {
        return $this->getString();
    }

    protected function getUri(): string
    {
        return $this->getString();
    }

    protected function getBinary(): string
    {
        return $this->getString();
    }

    abstract protected function getString(): string;

    protected function getInteger32(): string
    {
        return $this->getInteger();
    }

    protected function getInteger64(): string
    {
        return $this->getInteger();
    }

    abstract protected function getInteger(): string;

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
        if ($format === Format::DATE) {
            return $this->getDate();
        } elseif ($format === Format::DATETIME) {
            return  $this->getDateTime();
        } elseif ($format === Format::TIME) {
            return  $this->getTime();
        } elseif ($format === Format::PERIOD) {
            return  $this->getPeriod();
        } elseif ($format === Format::DURATION) {
            return  $this->getDuration();
        } elseif ($format === Format::URI) {
            return  $this->getUri();
        } elseif ($format === Format::BINARY) {
            return  $this->getBinary();
        } else {
            return $this->getString();
        }
    }

    private function getIntegerType(IntegerType $type): string
    {
        $format = $type->getFormat();
        if ($format === Format::INT32) {
            return $this->getInteger32();
        } elseif ($format === Format::INT64) {
            return $this->getInteger64();
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
