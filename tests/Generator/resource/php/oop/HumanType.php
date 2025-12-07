<?php

declare(strict_types = 1);

class HumanType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?string $firstName = null;
    protected ?HumanType $parent = null;
    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }
    public function setParent(?HumanType $parent): void
    {
        $this->parent = $parent;
    }
    public function getParent(): ?HumanType
    {
        return $this->parent;
    }
    /**
     * @return \PSX\Record\RecordInterface<mixed>
     */
    public function toRecord(): \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('firstName', $this->firstName);
        $record->put('parent', $this->parent);
        return $record;
    }
    public function jsonSerialize(): object
    {
        return (object) $this->toRecord()->getAll();
    }
}

