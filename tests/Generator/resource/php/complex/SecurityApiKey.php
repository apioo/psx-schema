<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

class SecurityApiKey extends Security implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('Must be either "header" or "query"')]
    protected ?string $in = null;
    #[Description('The name of the header or query parameter i.e. "X-Api-Key"')]
    protected ?string $name = null;
    public function setIn(?string $in): void
    {
        $this->in = $in;
    }
    public function getIn(): ?string
    {
        return $this->in;
    }
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    /**
     * @return \PSX\Record\RecordInterface<mixed>
     */
    public function toRecord(): \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('in', $this->in);
        $record->put('name', $this->name);
        return $record;
    }
    public function jsonSerialize(): object
    {
        return (object) $this->toRecord()->getAll();
    }
}

