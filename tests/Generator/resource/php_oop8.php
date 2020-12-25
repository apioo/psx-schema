class Human implements \JsonSerializable
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
    public function jsonSerialize()
    {
        return (object) array_filter(array('firstName' => $this->firstName), static function ($value) : bool {
            return $value !== null;
        });
    }
}
class Student extends Human implements \JsonSerializable
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
    public function jsonSerialize()
    {
        return (object) array_merge((array) parent::jsonSerialize(), array_filter(array('matricleNumber' => $this->matricleNumber), static function ($value) : bool {
            return $value !== null;
        }));
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
class Map implements \JsonSerializable
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
    public function jsonSerialize()
    {
        return (object) array_filter(array('totalResults' => $this->totalResults, 'entries' => $this->entries), static function ($value) : bool {
            return $value !== null;
        });
    }
}
class RootSchema implements \JsonSerializable
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
    public function jsonSerialize()
    {
        return (object) array_filter(array('students' => $this->students), static function ($value) : bool {
            return $value !== null;
        });
    }
}