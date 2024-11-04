<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Discriminator;

#[Description('Base scalar property type')]
#[Discriminator('type')]
#[DerivedType(StringPropertyType::class, 'string')]
#[DerivedType(IntegerPropertyType::class, 'integer')]
#[DerivedType(NumberPropertyType::class, 'number')]
#[DerivedType(BooleanPropertyType::class, 'boolean')]
abstract class ScalarPropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
}

