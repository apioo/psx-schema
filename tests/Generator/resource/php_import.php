class Import implements \JsonSerializable
{
    /**
     * @var StudentMap|null
     */
    protected $students;
    /**
     * @var Student|null
     */
    protected $student;
    /**
     * @param StudentMap|null $students
     */
    public function setStudents(?StudentMap $students) : void
    {
        $this->students = $students;
    }
    /**
     * @return StudentMap|null
     */
    public function getStudents() : ?StudentMap
    {
        return $this->students;
    }
    /**
     * @param Student|null $student
     */
    public function setStudent(?Student $student) : void
    {
        $this->student = $student;
    }
    /**
     * @return Student|null
     */
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