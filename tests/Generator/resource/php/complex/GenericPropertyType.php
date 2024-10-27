<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

#[Description('Represents a generic value which can be replaced with a dynamic type')]
class GenericPropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('The name of the generic, it is recommended to use common generic names like T or TValue. These generics can then be replaced on usage with a concrete type through the template property at a reference.')]
    protected ?string $name = null;
    public function setName(?string $name) : void
    {
        $this->name = $name;
    }
    public function getName() : ?string
    {
        return $this->name;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('name', $this->name);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

