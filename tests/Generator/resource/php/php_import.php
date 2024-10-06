class Import implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?StudentMap $students = null;
    protected ?Student $student = null;
    public function setStudents(?StudentMap $students) : void
    {
        $this->students = $students;
    }
    public function getStudents() : ?StudentMap
    {
        return $this->students;
    }
    public function setStudent(?Student $student) : void
    {
        $this->student = $student;
    }
    public function getStudent() : ?Student
    {
        return $this->student;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('students', $this->students);
        $record->put('student', $this->student);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

class MyMap extends Student implements \JsonSerializable, \PSX\Record\RecordableInterface
{
}
