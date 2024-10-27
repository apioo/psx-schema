<?php

declare(strict_types = 1);

use PSX\Schema\Attribute\Description;

#[Description('Represents a float value')]
class NumberPropertyType extends ScalarPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
}

