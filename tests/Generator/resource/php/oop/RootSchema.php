<?php

declare(strict_types = 1);

class RootSchema implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?StudentMap $students = null;
    public function setStudents(?StudentMap $students) : void
    {
        $this->students = $students;
    }
    public function getStudents() : ?StudentMap
    {
        return $this->students;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('students', $this->students);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

