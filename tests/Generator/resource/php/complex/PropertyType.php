<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Discriminator;

#[Description('Base property type')]
#[Discriminator('type')]
#[DerivedType('StringPropertyType', 'string')]
#[DerivedType('IntegerPropertyType', 'integer')]
#[DerivedType('NumberPropertyType', 'number')]
#[DerivedType('BooleanPropertyType', 'boolean')]
#[DerivedType('MapPropertyType', 'map')]
#[DerivedType('ArrayPropertyType', 'array')]
#[DerivedType('AnyPropertyType', 'any')]
#[DerivedType('GenericPropertyType', 'generic')]
#[DerivedType('ReferencePropertyType', 'reference')]
abstract class PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?string $description = null;
    protected ?string $type = null;
    protected ?bool $deprecated = null;
    protected ?bool $nullable = null;
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
    public function getDescription() : ?string
    {
        return $this->description;
    }
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setDeprecated(?bool $deprecated) : void
    {
        $this->deprecated = $deprecated;
    }
    public function getDeprecated() : ?bool
    {
        return $this->deprecated;
    }
    public function setNullable(?bool $nullable) : void
    {
        $this->nullable = $nullable;
    }
    public function getNullable() : ?bool
    {
        return $this->nullable;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('description', $this->description);
        $record->put('type', $this->type);
        $record->put('deprecated', $this->deprecated);
        $record->put('nullable', $this->nullable);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

