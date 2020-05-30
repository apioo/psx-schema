class Human
{
    /**
     * @var string|null
     */
    protected $firstName;
    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName) : void
    {
        $this->firstName = $firstName;
    }
    /**
     * @return string|null
     */
    public function getFirstName() : ?string
    {
        return $this->firstName;
    }
}
class Student extends Human
{
    /**
     * @var string|null
     */
    protected $matricleNumber;
    /**
     * @param string|null $matricleNumber
     */
    public function setMatricleNumber(?string $matricleNumber) : void
    {
        $this->matricleNumber = $matricleNumber;
    }
    /**
     * @return string|null
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
     * @var int|null
     */
    protected $totalResults;
    /**
     * @var array<T>|null
     */
    protected $entries;
    /**
     * @param int|null $totalResults
     */
    public function setTotalResults(?int $totalResults) : void
    {
        $this->totalResults = $totalResults;
    }
    /**
     * @return int|null
     */
    public function getTotalResults() : ?int
    {
        return $this->totalResults;
    }
    /**
     * @param array<T>|null $entries
     */
    public function setEntries(?array $entries) : void
    {
        $this->entries = $entries;
    }
    /**
     * @return array<T>|null
     */
    public function getEntries() : ?array
    {
        return $this->entries;
    }
}
class RootSchema
{
    /**
     * @var StudentMap|null
     */
    protected $students;
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
}