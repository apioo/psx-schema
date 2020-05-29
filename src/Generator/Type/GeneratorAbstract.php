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

namespace PSX\Schema\Generator\Type;

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
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeInterface;

/**
 * GeneratorAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
abstract class GeneratorAbstract implements GeneratorInterface
{
    /**
     * @inheritDoc
     */
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
            throw new \RuntimeException('Could not determine name of anonymous struct, use a reference to the definitions instead');
        } elseif ($type instanceof MapType) {
            return $this->getMap($this->getType($type->getAdditionalProperties()));
        } elseif ($type instanceof UnionType) {
            return $this->getUnion($this->getCombinationType($type->getOneOf()));
        } elseif ($type instanceof IntersectionType) {
            return $this->getIntersection($this->getCombinationType($type->getAllOf()));
        } elseif ($type instanceof ReferenceType) {
            $template = $type->getTemplate();
            if (!empty($template)) {
                return $this->getReference($type->getRef()) . $this->getGeneric(array_values($template));
            } else {
                return $this->getReference($type->getRef());
            }
        } elseif ($type instanceof GenericType) {
            return $type->getGeneric() ?? '';
        }

        return $this->getAny();
    }

    /**
     * @inheritDoc
     */
    public function getDocType(TypeInterface $type): string
    {
        return $this->getType($type);
    }

    /**
     * @return string
     */
    protected function getDate(): string
    {
        return $this->getString();
    }

    /**
     * @return string
     */
    protected function getDateTime(): string
    {
        return $this->getString();
    }

    /**
     * @return string
     */
    protected function getTime(): string
    {
        return $this->getString();
    }

    /**
     * @return string
     */
    protected function getDuration(): string
    {
        return $this->getString();
    }

    /**
     * @return string
     */
    protected function getUri(): string
    {
        return $this->getString();
    }

    /**
     * @return string
     */
    protected function getBinary(): string
    {
        return $this->getString();
    }

    /**
     * @return string
     */
    abstract protected function getString(): string;

    /**
     * @return string
     */
    protected function getInteger32(): string
    {
        return $this->getInteger();
    }

    /**
     * @return string
     */
    protected function getInteger64(): string
    {
        return $this->getInteger();
    }

    /**
     * @return string
     */
    abstract protected function getInteger(): string;

    /**
     * @return string
     */
    abstract protected function getNumber(): string;

    /**
     * @return string
     */
    abstract protected function getBoolean(): string;

    /**
     * @param string $type
     * @return string
     */
    abstract protected function getArray(string $type): string;

    /**
     * @param string $type
     * @return string
     */
    abstract protected function getMap(string $type): string;

    /**
     * @param array $types
     * @return string
     */
    abstract protected function getUnion(array $types): string;

    /**
     * @param array $types
     * @return string
     */
    abstract protected function getIntersection(array $types): string;

    /**
     * @param string $type
     * @return string
     */
    abstract protected function getGroup(string $type): string;

    /**
     * @param string $ref
     * @return string
     */
    protected function getReference(string $ref): string
    {
        return $ref;
    }

    /**
     * @param array $types
     * @return string
     */
    abstract protected function getGeneric(array $types): string;

    /**
     * @return string
     */
    abstract protected function getAny(): string;

    /**
     * @param StringType $type
     * @return string
     */
    private function getStringType(StringType $type): string
    {
        $format = $type->getFormat();
        if ($format === TypeAbstract::FORMAT_DATE) {
            return $this->getDate();
        } elseif ($format === TypeAbstract::FORMAT_DATETIME) {
            return  $this->getDateTime();
        } elseif ($format === TypeAbstract::FORMAT_TIME) {
            return  $this->getTime();
        } elseif ($format === TypeAbstract::FORMAT_DURATION) {
            return  $this->getDuration();
        } elseif ($format === TypeAbstract::FORMAT_URI) {
            return  $this->getUri();
        } elseif ($format === TypeAbstract::FORMAT_BINARY) {
            return  $this->getBinary();
        } else {
            return $this->getString();
        }
    }

    /**
     * @param IntegerType $type
     * @return string
     */
    private function getIntegerType(IntegerType $type): string
    {
        $format = $type->getFormat();
        if ($format === TypeAbstract::FORMAT_INT32) {
            return $this->getInteger32();
        } elseif ($format === TypeAbstract::FORMAT_INT64) {
            return $this->getInteger64();
        } else {
            return $this->getInteger();
        }
    }

    /**
     * @param array $properties
     * @return array
     */
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
