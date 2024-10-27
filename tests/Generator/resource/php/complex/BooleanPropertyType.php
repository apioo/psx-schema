<?php

declare(strict_types = 1);

use PSX\Schema\Attribute\Description;

#[Description('Represents a boolean value')]
class BooleanPropertyType extends ScalarPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
}

