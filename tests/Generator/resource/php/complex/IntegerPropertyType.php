<?php

declare(strict_types = 1);

use PSX\Schema\Attribute\Description;

#[Description('Represents an integer value')]
class IntegerPropertyType extends ScalarPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
}

