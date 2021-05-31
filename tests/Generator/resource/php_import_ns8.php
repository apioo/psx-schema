namespace Foo\Bar;


class Import implements \JsonSerializable
{
    /**
     * @var \My\Import\StudentMap|null
     */
    protected $students;
    /**
     * @var \My\Import\Student|null
     */
    protected $student;
    /**
     * @param \My\Import\StudentMap|null $students
     */
    public function setStudents(?\My\Import\StudentMap $students) : void
    {
        $this->students = $students;
    }
    /**
     * @return \My\Import\StudentMap|null
     */
    public function getStudents() : ?\My\Import\StudentMap
    {
        return $this->students;
    }
    /**
     * @param \My\Import\Student|null $student
     */
    public function setStudent(?\My\Import\Student $student) : void
    {
        $this->student = $student;
    }
    /**
     * @return \My\Import\Student|null
     */
    public function getStudent() : ?\My\Import\Student
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

namespace Foo\Bar;


class MyMap extends \My\Import\Student implements \JsonSerializable
{
}
