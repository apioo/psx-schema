<?php

declare(strict_types = 1);

class Student extends HumanType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?string $matricleNumber = null;
    public function setMatricleNumber(?string $matricleNumber) : void
    {
        $this->matricleNumber = $matricleNumber;
    }
    public function getMatricleNumber() : ?string
    {
        return $this->matricleNumber;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('matricleNumber', $this->matricleNumber);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

