class Human
{
    protected $firstName;
    /**
     * @param int $firstName
     */
    public function setFirstName(?int $firstName)
    {
        $this->firstName = $firstName;
    }
    /**
     * @return int
     */
    public function getFirstName() : ?int
    {
        return $this->firstName;
    }
}
class Student extends Human
{
    protected $matricleNumber;
    /**
     * @param int $matricleNumber
     */
    public function setMatricleNumber(?int $matricleNumber)
    {
        $this->matricleNumber = $matricleNumber;
    }
    /**
     * @return int
     */
    public function getMatricleNumber() : ?int
    {
        return $this->matricleNumber;
    }
}

class Map
{
    protected $totalResults;
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
    protected $students;
    /**
     * @param Map $students
     */
    public function setStudents(?Map $students)
    {
        $this->students = $students;
    }
    /**
     * @return Map
     */
    public function getStudents() : ?Map
    {
        return $this->students;
    }
}