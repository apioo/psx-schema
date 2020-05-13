class Human
{
    /**
     * @var string
     */
    protected $firstName;
    /**
     * @param string $firstName
     */
    public function setFirstName(?string $firstName)
    {
        $this->firstName = $firstName;
    }
    /**
     * @return string
     */
    public function getFirstName() : ?string
    {
        return $this->firstName;
    }
}
class Student extends Human
{
    /**
     * @var string
     */
    protected $matricleNumber;
    /**
     * @param string $matricleNumber
     */
    public function setMatricleNumber(?string $matricleNumber)
    {
        $this->matricleNumber = $matricleNumber;
    }
    /**
     * @return string
     */
    public function getMatricleNumber() : ?string
    {
        return $this->matricleNumber;
    }
}
/**
 * @extends Map<Student>
 */
class StudentMap extends Map
{
}
/**
 * @template T
 */
class Map
{
    /**
     * @var int
     */
    protected $totalResults;
    /**
     * @var array<T>
     */
    protected $entries;
    /**
     * @param int $totalResults
     */
    public function setTotalResults(?int $totalResults)
    {
        $this->totalResults = $totalResults;
    }
    /**
     * @return int
     */
    public function getTotalResults() : ?int
    {
        return $this->totalResults;
    }
    /**
     * @param array<T> $entries
     */
    public function setEntries(?array $entries)
    {
        $this->entries = $entries;
    }
    /**
     * @return array<T>
     */
    public function getEntries() : ?array
    {
        return $this->entries;
    }
}
class RootSchema
{
    /**
     * @var StudentMap
     */
    protected $students;
    /**
     * @param StudentMap $students
     */
    public function setStudents(?StudentMap $students)
    {
        $this->students = $students;
    }
    /**
     * @return StudentMap
     */
    public function getStudents() : ?StudentMap
    {
        return $this->students;
    }
}