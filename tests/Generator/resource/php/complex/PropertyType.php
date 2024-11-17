<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Discriminator;

#[Description('Base property type')]
#[Discriminator('type')]
#[DerivedType(AnyPropertyType::class, 'any')]
#[DerivedType(ArrayPropertyType::class, 'array')]
#[DerivedType(BooleanPropertyType::class, 'boolean')]
#[DerivedType(GenericPropertyType::class, 'generic')]
#[DerivedType(IntegerPropertyType::class, 'integer')]
#[DerivedType(MapPropertyType::class, 'map')]
#[DerivedType(NumberPropertyType::class, 'number')]
#[DerivedType(ReferencePropertyType::class, 'reference')]
#[DerivedType(StringPropertyType::class, 'string')]
abstract class PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?bool $deprecated = null;
    #[Description('')]
    protected ?string $description = null;
    #[Description('')]
    protected ?bool $nullable = null;
    #[Description('')]
    protected ?string $type = null;
    public function setDeprecated(?bool $deprecated) : void
    {
        $this->deprecated = $deprecated;
    }
    public function getDeprecated() : ?bool
    {
        return $this->deprecated;
    }
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
    public function getDescription() : ?string
    {
        return $this->description;
    }
    public function setNullable(?bool $nullable) : void
    {
        $this->nullable = $nullable;
    }
    public function getNullable() : ?bool
    {
        return $this->nullable;
    }
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('deprecated', $this->deprecated);
        $record->put('description', $this->description);
        $record->put('nullable', $this->nullable);
        $record->put('type', $this->type);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

