<?php

declare(strict_types = 1);

use PSX\Schema\Attribute\Description;

#[Description('Represents a map which contains a dynamic set of key value entries of the same type')]
class MapDefinitionType extends CollectionDefinitionType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
}

