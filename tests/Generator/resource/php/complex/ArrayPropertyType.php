<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

#[Description('Represents an array which contains a dynamic list of values of the same type')]
class ArrayPropertyType extends CollectionPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
}

