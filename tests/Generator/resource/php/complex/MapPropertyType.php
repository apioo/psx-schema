<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

#[Description('Represents a map which contains a dynamic set of key value entries of the same type')]
class MapPropertyType extends CollectionPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
}

