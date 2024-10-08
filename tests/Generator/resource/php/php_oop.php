class Human implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?string $firstName = null;
    protected ?Human $parent = null;
    public function setFirstName(?string $firstName) : void
    {
        $this->firstName = $firstName;
    }
    public function getFirstName() : ?string
    {
        return $this->firstName;
    }
    public function setParent(?Human $parent) : void
    {
        $this->parent = $parent;
    }
    public function getParent() : ?Human
    {
        return $this->parent;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('firstName', $this->firstName);
        $record->put('parent', $this->parent);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

class Student extends Human implements \JsonSerializable, \PSX\Record\RecordableInterface
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('matricleNumber', $this->matricleNumber);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

/**
 * @template P
 * @template T
 */
class Map implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?int $totalResults = null;
    /**
     * @var P
     */
    protected mixed $parent = null;
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
    /**
     * @param P $parent
     */
    public function setParent(mixed $parent) : void
    {
        $this->parent = $parent;
    }
    /**
     * @return P
     */
    public function getParent() : mixed
    {
        return $this->parent;
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('totalResults', $this->totalResults);
        $record->put('parent', $this->parent);
        $record->put('entries', $this->entries);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

/**
 * @extends Map<Human, Student>
 */
class StudentMap extends Map implements \JsonSerializable, \PSX\Record\RecordableInterface
{
}

/**
 * @extends Map<Human, Human>
 */
class HumanMap extends Map implements \JsonSerializable, \PSX\Record\RecordableInterface
{
}

class RootSchema implements \JsonSerializable, \PSX\Record\RecordableInterface
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('students', $this->students);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}
