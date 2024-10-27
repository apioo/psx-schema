<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

#[Description('Represents a string value')]
class StringPropertyType extends ScalarPropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('Optional describes the format of the string. Supported are the following types: date, date-time and time. A code generator may use a fitting data type to represent such a format, if not supported it should fall back to a string.')]
    protected ?string $format = null;
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
        $record->put('format', $this->format);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

