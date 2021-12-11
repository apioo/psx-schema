use PSX\Schema\Attribute\Required;

#[Required(array('kind'))]
class Creature implements \JsonSerializable
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
    public function jsonSerialize()
    {
        return (object) array_filter(array('kind' => $this->kind), static function ($value) : bool {
            return $value !== null;
        });
    }
}

class Human extends Creature implements \JsonSerializable
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
        return (object) array_merge((array) parent::jsonSerialize(), array_filter(array('firstName' => $this->firstName), static function ($value) : bool {
            return $value !== null;
        }));
    }
}

class Animal extends Creature implements \JsonSerializable
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
    public function jsonSerialize()
    {
        return (object) array_merge((array) parent::jsonSerialize(), array_filter(array('nickname' => $this->nickname), static function ($value) : bool {
            return $value !== null;
        }));
    }
}

use PSX\Schema\Attribute\Discriminator;

class Union implements \JsonSerializable
{
    protected Human|Animal|null $union = null;
    /**
     * @var Human&Animal|null
     */
    protected $intersection = null;
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
    public function setIntersection($intersection) : void
    {
        $this->intersection = $intersection;
    }
    public function getIntersection()
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
    public function jsonSerialize()
    {
        return (object) array_filter(array('union' => $this->union, 'intersection' => $this->intersection, 'discriminator' => $this->discriminator), static function ($value) : bool {
            return $value !== null;
        });
    }
}
