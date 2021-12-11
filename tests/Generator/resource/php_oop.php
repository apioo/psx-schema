class Human implements \JsonSerializable
{
    protected ?string $firstName = null;
    public function setFirstName(?string $firstName) : void
    {
        $this->firstName = $firstName;
    }
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
    protected ?string $matricleNumber = null;
    public function setMatricleNumber(?string $matricleNumber) : void
    {
        $this->matricleNumber = $matricleNumber;
    }
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
    protected ?int $totalResults = null;
    /**
     * @var array<T>|null
     */
    protected ?array $entries = null;
    public function setTotalResults(?int $totalResults) : void
    {
        $this->totalResults = $totalResults;
    }
    public function getTotalResults() : ?int
    {
        return $this->totalResults;
    }
    public function setEntries(?array $entries) : void
    {
        $this->entries = $entries;
    }
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
    protected ?StudentMap $students = null;
    public function setStudents(?StudentMap $students) : void
    {
        $this->students = $students;
    }
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
