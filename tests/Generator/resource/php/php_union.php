use PSX\Schema\Attribute\Required;

#[Required(array('kind'))]
class Creature implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?string $kind = null;
    public function setKind(?string $kind) : void
    {
        $this->kind = $kind;
    }
    public function getKind() : ?string
    {
        return $this->kind;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('kind', $this->kind);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

class Human extends Creature implements \JsonSerializable, \PSX\Record\RecordableInterface
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('firstName', $this->firstName);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

class Animal extends Creature implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?string $nickname = null;
    public function setNickname(?string $nickname) : void
    {
        $this->nickname = $nickname;
    }
    public function getNickname() : ?string
    {
        return $this->nickname;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('nickname', $this->nickname);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

use PSX\Schema\Attribute\Discriminator;

class Union implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected Human|Animal|null $union = null;
    protected ?Human&Animal $intersection = null;
    #[Discriminator('kind', array('Human', 'Animal'))]
    protected Human|Animal|null $discriminator = null;
    public function setUnion(Human|Animal|null $union) : void
    {
        $this->union = $union;
    }
    public function getUnion() : Human|Animal|null
    {
        return $this->union;
    }
    public function setIntersection(?Human&Animal $intersection) : void
    {
        $this->intersection = $intersection;
    }
    public function getIntersection() : ?Human&Animal
    {
        return $this->intersection;
    }
    public function setDiscriminator(Human|Animal|null $discriminator) : void
    {
        $this->discriminator = $discriminator;
    }
    public function getDiscriminator() : Human|Animal|null
    {
        return $this->discriminator;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('union', $this->union);
        $record->put('intersection', $this->intersection);
        $record->put('discriminator', $this->discriminator);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}
