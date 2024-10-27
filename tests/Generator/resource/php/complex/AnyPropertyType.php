<?php

declare(strict_types = 1);

use PSX\Schema\Attribute\Description;

#[Description('Represents an any value which allows any kind of value')]
class AnyPropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
}

