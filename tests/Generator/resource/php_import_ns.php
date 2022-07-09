namespace Foo\Bar;


class Import implements \JsonSerializable
{
    protected ?\My\Import\StudentMap $students = null;
    protected ?\My\Import\Student $student = null;
    public function setStudents(?\My\Import\StudentMap $students) : void
    {
        $this->students = $students;
    }
    public function getStudents() : ?\My\Import\StudentMap
    {
        return $this->students;
    }
    public function setStudent(?\My\Import\Student $student) : void
    {
        $this->student = $student;
    }
    public function getStudent() : ?\My\Import\Student
    {
        return $this->student;
    }
    public function jsonSerialize() : object
    {
        return (object) array_filter(array('students' => $this->students, 'student' => $this->student), static function ($value) : bool {
            return $value !== null;
        });
    }
}

namespace Foo\Bar;


class MyMap extends \My\Import\Student implements \JsonSerializable
{
}
