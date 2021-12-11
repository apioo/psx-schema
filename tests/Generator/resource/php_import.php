class Import implements \JsonSerializable
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
    public function jsonSerialize()
    {
        return (object) array_filter(array('students' => $this->students, 'student' => $this->student), static function ($value) : bool {
            return $value !== null;
        });
    }
}

class MyMap extends Student implements \JsonSerializable
{
}
