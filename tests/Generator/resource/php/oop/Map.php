<?php

declare(strict_types = 1);

/**
 * @template P
 * @template T
 */
class Map implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?int $totalResults = null;
    /**
     * @var P
     */
    protected mixed $parent = null;
    /**
     * @var array<T>|null
     */
    protected ?array $entries = null;
    public function setTotalResults(?int $totalResults): void
    {
        $this->totalResults = $totalResults;
    }
    public function getTotalResults(): ?int
    {
        return $this->totalResults;
    }
    /**
     * @param P $parent
     */
    public function setParent(mixed $parent): void
    {
        $this->parent = $parent;
    }
    /**
     * @return P
     */
    public function getParent(): mixed
    {
        return $this->parent;
    }
    /**
     * @param array<T>|null $entries
     */
    public function setEntries(?array $entries): void
    {
        $this->entries = $entries;
    }
    /**
     * @return array<T>|null
     */
    public function getEntries(): ?array
    {
        return $this->entries;
    }
    public function toRecord(): \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('totalResults', $this->totalResults);
        $record->put('parent', $this->parent);
        $record->put('entries', $this->entries);
        return $record;
    }
    public function jsonSerialize(): object
    {
        return (object) $this->toRecord()->getAll();
    }
}

