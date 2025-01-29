<?php

declare(strict_types = 1);

namespace Foo\Bar;


class Import implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?\My\Import\StudentMap $students = null;
    protected ?\My\Import\Student $student = null;
    public function setStudents(?\My\Import\StudentMap $students): void
    {
        $this->students = $students;
    }
    public function getStudents(): ?\My\Import\StudentMap
    {
        return $this->students;
    }
    public function setStudent(?\My\Import\Student $student): void
    {
        $this->student = $student;
    }
    public function getStudent(): ?\My\Import\Student
    {
        return $this->student;
    }
    public function toRecord(): \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('students', $this->students);
        $record->put('student', $this->student);
        return $record;
    }
    public function jsonSerialize(): object
    {
        return (object) $this->toRecord()->getAll();
    }
}

