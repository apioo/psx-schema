<?php

declare(strict_types = 1);

use PSX\Schema\Attribute\Description;

#[Description('Represents a reference to a definition type')]
class ReferencePropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?string $type = null;
    #[Description('Name of the target reference, must a key from the definitions map')]
    protected ?string $target = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setTarget(?string $target) : void
    {
        $this->target = $target;
    }
    public function getTarget() : ?string
    {
        return $this->target;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('target', $this->target);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

