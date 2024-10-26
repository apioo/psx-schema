<?php

declare(strict_types = 1);

use PSX\Schema\Attribute\Description;

#[Description('Represents a string value')]
class StringPropertyType extends ScalarPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?string $type = null;
    #[Description('')]
    protected ?string $format = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setFormat(?string $format) : void
    {
        $this->format = $format;
    }
    public function getFormat() : ?string
    {
        return $this->format;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('format', $this->format);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

