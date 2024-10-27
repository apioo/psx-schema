<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

#[Description('Base collection property type')]
abstract class CollectionPropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?PropertyType $schema = null;
    public function setSchema(?PropertyType $schema) : void
    {
        $this->schema = $schema;
    }
    public function getSchema() : ?PropertyType
    {
        return $this->schema;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('schema', $this->schema);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

