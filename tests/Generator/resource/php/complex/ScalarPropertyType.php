<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Discriminator;

#[Description('Base scalar property type')]
#[Discriminator('type')]
#[DerivedType('StringPropertyType', 'string')]
#[DerivedType('IntegerPropertyType', 'integer')]
#[DerivedType('NumberPropertyType', 'number')]
#[DerivedType('BooleanPropertyType', 'boolean')]
abstract class ScalarPropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
}

