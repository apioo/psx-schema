<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Discriminator;

#[Description('Base definition type')]
#[Discriminator('type')]
#[DerivedType(ArrayDefinitionType::class, 'array')]
#[DerivedType(MapDefinitionType::class, 'map')]
#[DerivedType(StructDefinitionType::class, 'struct')]
abstract class DefinitionType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?bool $deprecated = null;
    #[Description('')]
    protected ?string $description = null;
    #[Description('')]
    protected ?string $type = null;
    public function setDeprecated(?bool $deprecated): void
    {
        $this->deprecated = $deprecated;
    }
    public function getDeprecated(): ?bool
    {
        return $this->deprecated;
    }
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setType(?string $type): void
    {
        $this->type = $type;
    }
    public function getType(): ?string
    {
        return $this->type;
    }
    public function toRecord(): \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('deprecated', $this->deprecated);
        $record->put('description', $this->description);
        $record->put('type', $this->type);
        return $record;
    }
    public function jsonSerialize(): object
    {
        return (object) $this->toRecord()->getAll();
    }
}

