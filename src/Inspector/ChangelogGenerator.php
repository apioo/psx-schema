<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Inspector;

use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Type\AnyType;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\GenericType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeInterface;
use PSX\Schema\TypeUtil;

/**
 * Generates a changelog about all changes between the left and right schema. It yields all changelog entries and the
 * key contains also the severity of the change
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ChangelogGenerator
{
    public function generate(DefinitionsInterface $left, DefinitionsInterface $right): \Generator
    {
        foreach ($left->getAllTypes() as $leftName => $leftType) {
            if ($right->hasType($leftName)) {
                yield from $this->generateType($leftType, $right->getType($leftName), $leftName);
            } else {
                yield SemVer::MAJOR => $this->getMessageRemoved($leftName, null);
            }
        }

        foreach ($right->getAllTypes() as $rightName => $rightType) {
            if (!$left->hasType($rightName)) {
                yield SemVer::PATCH => $this->getMessageAdded($rightName, null);
            }
        }
    }

    private function generateType(TypeInterface $leftType, TypeInterface $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        if (get_class($leftType) !== get_class($rightType)) {
            yield SemVer::MAJOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'type', TypeUtil::getTypeName($leftType), TypeUtil::getTypeName($rightType));
            return;
        }

        if ($leftType instanceof TypeAbstract && $rightType instanceof TypeAbstract) {
            yield from $this->generateCommon($leftType, $rightType, $typeName, $propertyName);
        }

        if ($leftType instanceof StructType && $rightType instanceof StructType) {
            yield from $this->generateStruct($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof MapType && $rightType instanceof MapType) {
            yield from $this->generateMap($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof ArrayType && $rightType instanceof ArrayType) {
            yield from $this->generateArray($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof NumberType && $rightType instanceof NumberType) {
            yield from $this->generateNumber($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof BooleanType && $rightType instanceof BooleanType) {
            // nothing to diff here
        } elseif ($leftType instanceof StringType && $rightType instanceof StringType) {
            yield from $this->generateString($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof IntersectionType && $rightType instanceof IntersectionType) {
            yield from $this->generateIntersection($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof UnionType && $rightType instanceof UnionType) {
            yield from $this->generateUnion($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof ReferenceType && $rightType instanceof ReferenceType) {
            yield from $this->generateReference($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof AnyType && $rightType instanceof AnyType) {
            // nothing to diff here
        } elseif ($leftType instanceof GenericType && $rightType instanceof GenericType) {
            // nothing to diff here
        }
    }

    private function generateCommon(TypeAbstract $leftType, TypeAbstract $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        if ($leftType->getDescription() !== $rightType->getDescription()) {
            yield SemVer::PATCH => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'description', $leftType->getDescription(), $rightType->getDescription());
        }

        if ($leftType->isNullable() !== $rightType->isNullable()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'nullable', $leftType->isNullable(), $rightType->isNullable());
        }

        if ($leftType->isDeprecated() !== $rightType->isDeprecated()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'deprecated', $leftType->isDeprecated(), $rightType->isDeprecated());
        }

        if ($leftType->isReadonly() !== $rightType->isReadonly()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'readonly', $leftType->isReadonly(), $rightType->isReadonly());
        }
    }

    private function generateStruct(StructType $leftType, StructType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        $left = $leftType->getProperties();
        $right = $rightType->getProperties();

        foreach ($left as $key => $property) {
            if (isset($right[$key])) {
                yield from $this->generateType($property, $right[$key], $typeName, $key);
            } else {
                yield SemVer::MAJOR => $this->getMessageRemoved($typeName, $key);
            }
        }

        foreach ($right as $key => $value) {
            if (!isset($left[$key])) {
                yield SemVer::PATCH => $this->getMessageAdded($typeName, $key);
            }
        }
    }

    private function generateMap(MapType $leftType, MapType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        $left = $leftType->getAdditionalProperties();
        $right = $rightType->getAdditionalProperties();

        if ($left instanceof TypeInterface && $right instanceof TypeInterface) {
            yield from $this->generateType($left, $right, $typeName);
        }
    }

    private function generateArray(ArrayType $leftType, ArrayType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        $left = $leftType->getItems();
        $right = $rightType->getItems();

        if ($left instanceof TypeInterface && $right instanceof TypeInterface) {
            yield from $this->generateType($left, $right, $typeName);
        }
    }

    private function generateIntersection(IntersectionType $leftType, IntersectionType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        $left = $leftType->getAllOf();
        $right = $rightType->getAllOf();

        foreach ($left as $index => $value) {
            if (isset($right[$index])) {
                yield from $this->generateType($value, $right[$index], $typeName, $propertyName);
            } else {
                yield $this->getMessageRemoved($typeName, $propertyName . '[' . $index . ']');
            }
        }

        foreach ($right as $index => $value) {
            if (!isset($left[$index])) {
                yield $this->getMessageAdded($typeName, $propertyName . '[' . $index . ']');
            }
        }
    }

    private function generateUnion(UnionType $leftType, UnionType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        $left = $leftType->getOneOf();
        $right = $rightType->getOneOf();

        foreach ($left as $index => $value) {
            if (isset($right[$index])) {
                yield from $this->generateType($value, $right[$index], $typeName, $propertyName);
            } else {
                yield $this->getMessageRemoved($typeName, $propertyName . '[' . $index . ']');
            }
        }

        foreach ($right as $index => $value) {
            if (!isset($left[$index])) {
                yield $this->getMessageAdded($typeName, $propertyName . '[' . $index . ']');
            }
        }
    }

    private function generateReference(ReferenceType $leftType, ReferenceType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        if ($leftType->getRef() !== $rightType->getRef()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'ref', $leftType->getRef(), $rightType->getRef());
        }
    }

    private function generateString(StringType $leftType, StringType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        if ($leftType->getPattern() !== $rightType->getPattern()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'pattern', $leftType->getPattern(), $rightType->getPattern());
        }

        if ($leftType->getMinLength() !== $rightType->getMinLength()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'min length', $leftType->getMinLength(), $rightType->getMinLength());
        }

        if ($leftType->getMaxLength() !== $rightType->getMaxLength()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'max length', $leftType->getMaxLength(), $rightType->getMaxLength());
        }
    }

    private function generateNumber(NumberType $leftType, NumberType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        if ($leftType->getMinimum() !== $rightType->getMinimum()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'minimum', $leftType->getMinimum(), $rightType->getMinimum());
        }

        if ($leftType->getMaximum() !== $rightType->getMaximum()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'maximum', $leftType->getMaximum(), $rightType->getMaximum());
        }

        if ($leftType->getExclusiveMinimum() !== $rightType->getExclusiveMinimum()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'exclusive minimum', $leftType->getExclusiveMinimum(), $rightType->getExclusiveMinimum());
        }

        if ($leftType->getExclusiveMaximum() !== $rightType->getExclusiveMaximum()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'exclusive maximum', $leftType->getExclusiveMaximum(), $rightType->getExclusiveMaximum());
        }
    }

    private function getMessageAdded(string $typeName, ?string $propertyName): string
    {
        [$ns, $name] = TypeUtil::split($typeName);

        if ($propertyName === null) {
            return 'Type "' . $name . '" was added';
        } else {
            return 'Property "' . $name . '.' . $propertyName . '" was added';
        }
    }

    private function getMessageRemoved(string $typeName, ?string $propertyName): string
    {
        [$ns, $name] = TypeUtil::split($typeName);

        if ($propertyName === null) {
            return 'Type "' . $name . '" was removed';
        } else {
            return 'Property "' . $name . '.' . $propertyName . '" was removed';
        }
    }

    private function getMessageChanged(string $typeName, ?string $propertyName, string $type, string $description, $from, $to): string
    {
        $from = $from ?? 'NULL';
        $to = $to ?? 'NULL';

        [$ns, $name] = TypeUtil::split($typeName);

        if ($propertyName === null) {
            return 'Type "' . $name . '" (' . $type . ') ' . $description . ' has changed from "' . $from . '" to "' . $to . '"';
        } else {
            return 'Property "' . $name . '.' . $propertyName . '" (' . $type . ') ' . $description . ' has changed from "' . $from . '" to "' . $to . '"';
        }
    }
}
