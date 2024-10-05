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

namespace PSX\Schema\Inspector;

use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Type\AnyPropertyType;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\BooleanPropertyType;
use PSX\Schema\Type\CollectionPropertyType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\GenericPropertyType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\MapPropertyType;
use PSX\Schema\Type\MapTypeInterface;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\Type\PropertyTypeAbstract;
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

    public function generateDefinitionType(DefinitionTypeAbstract $leftType, DefinitionTypeAbstract $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        if ($leftType instanceof DefinitionTypeAbstract && $rightType instanceof DefinitionTypeAbstract) {
            yield from $this->generateCommon($leftType, $rightType, $typeName, $propertyName);
        }

        if ($leftType instanceof StructDefinitionType && $rightType instanceof StructDefinitionType) {
            yield from $this->generateStruct($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof MapDefinitionType && $rightType instanceof MapDefinitionType) {
            yield from $this->generateMap($leftType, $rightType, $typeName, $propertyName);
        }
    }

    public function generatePropertyType(PropertyTypeAbstract $leftType, PropertyTypeAbstract $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        if (get_class($leftType) !== get_class($rightType)) {
            yield SemVer::MAJOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'type', TypeUtil::getTypeName($leftType), TypeUtil::getTypeName($rightType));
            return;
        }

        if ($leftType instanceof PropertyTypeAbstract && $rightType instanceof PropertyTypeAbstract) {
            yield from $this->generateType($leftType, $rightType, $typeName, $propertyName);
        }

        if ($leftType instanceof CollectionPropertyType && $rightType instanceof CollectionPropertyType) {
            yield from $this->generateCollection($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof NumberPropertyType && $rightType instanceof NumberPropertyType) {
            yield from $this->generateNumber($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof BooleanPropertyType && $rightType instanceof BooleanPropertyType) {
            // nothing to diff here
        } elseif ($leftType instanceof StringPropertyType && $rightType instanceof StringPropertyType) {
            yield from $this->generateString($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof ReferencePropertyType && $rightType instanceof ReferencePropertyType) {
            yield from $this->generateReference($leftType, $rightType, $typeName, $propertyName);
        } elseif ($leftType instanceof AnyPropertyType && $rightType instanceof AnyPropertyType) {
            // nothing to diff here
        } elseif ($leftType instanceof GenericPropertyType && $rightType instanceof GenericPropertyType) {
            yield from $this->generateGeneric($leftType, $rightType, $typeName, $propertyName);
        }
    }

    private function generateStruct(StructDefinitionType $leftType, StructDefinitionType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        $left = $leftType->getProperties() ?? [];
        $right = $rightType->getProperties() ?? [];

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

    private function generateMap(MapDefinitionType $leftType, MapDefinitionType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        $left = $leftType->getSchema();
        $right = $rightType->getSchema();

        if ($left instanceof PropertyTypeAbstract && $right instanceof PropertyTypeAbstract) {
            yield from $this->generateType($left, $right, $typeName, $propertyName);
        }
    }

    private function generateType(PropertyTypeAbstract $leftType, PropertyTypeAbstract $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        if ($leftType->getDescription() !== $rightType->getDescription()) {
            yield SemVer::PATCH => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'description', $leftType->getDescription(), $rightType->getDescription());
        }

        if ($leftType->isDeprecated() !== $rightType->isDeprecated()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'deprecated', $leftType->isDeprecated(), $rightType->isDeprecated());
        }

        if ($leftType->isNullable() !== $rightType->isNullable()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'nullable', $leftType->isNullable(), $rightType->isNullable());
        }
    }

    private function generateCollection(CollectionPropertyType $leftType, CollectionPropertyType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        $left = $leftType->getSchema();
        $right = $rightType->getSchema();

        if ($left instanceof PropertyTypeAbstract && $right instanceof PropertyTypeAbstract) {
            yield from $this->generateType($left, $right, $typeName, $propertyName);
        }
    }

    private function generateReference(ReferencePropertyType $leftType, ReferencePropertyType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        if ($leftType->getTarget() !== $rightType->getTarget()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'target', $leftType->getTarget(), $rightType->getTarget());
        }
    }

    private function generateGeneric(GenericPropertyType $leftType, GenericPropertyType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        if ($leftType->getName() !== $rightType->getName()) {
            yield SemVer::PATCH => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'name', $leftType->getName(), $rightType->getName());
        }
    }

    private function generateString(StringPropertyType $leftType, StringPropertyType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        if ($leftType->getFormat() !== $rightType->getFormat()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'format', $leftType->getFormat(), $rightType->getFormat());
        }
    }

    private function generateNumber(NumberPropertyType $leftType, NumberPropertyType $rightType, string $typeName, ?string $propertyName = null): \Generator
    {
        if ($leftType->getFormat() !== $rightType->getFormat()) {
            yield SemVer::MINOR => $this->getMessageChanged($typeName, $propertyName, TypeUtil::getTypeName($leftType), 'format', $leftType->getFormat(), $rightType->getFormat());
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
