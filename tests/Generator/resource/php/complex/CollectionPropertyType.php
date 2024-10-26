<?php

declare(strict_types = 1);

use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Discriminator;

#[Description('Base collection property type')]
#[Discriminator('type')]
#[DerivedType('MapPropertyType', 'map')]
#[DerivedType('ArrayPropertyType', 'array')]
abstract class CollectionPropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?string $type = null;
    #[Description('')]
    protected ?PropertyType $schema = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
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
        $record->put('type', $this->type);
        $record->put('schema', $this->schema);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

