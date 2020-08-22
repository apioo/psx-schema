/**
 * @Required({"kind"})
 */
class Creature implements \JsonSerializable
{
    /**
     * @var string|null
     */
    protected $kind;
    /**
     * @param string|null $kind
     */
    public function setKind(?string $kind) : void
    {
        $this->kind = $kind;
    }
    /**
     * @return string|null
     */
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
        return (object) array_merge((array) parent::jsonSerialize(), array_filter(array('firstName' => $this->firstName), static function ($value) : bool {
            return $value !== null;
        }));
    }
}
class Animal extends Creature implements \JsonSerializable
{
    /**
     * @var string|null
     */
    protected $nickname;
    /**
     * @param string|null $nickname
     */
    public function setNickname(?string $nickname) : void
    {
        $this->nickname = $nickname;
    }
    /**
     * @return string|null
     */
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
class Union implements \JsonSerializable
{
    /**
     * @var Human|Animal|null
     */
    protected $union;
    /**
     * @var Human&Animal|null
     */
    protected $intersection;
    /**
     * @var Human|Animal|null
     * @Discriminator("kind", {"foo": "Human", "bar": "Animal"})
     */
    protected $discriminator;
    /**
     * @param Human|Animal|null $union
     */
    public function setUnion($union) : void
    {
        $this->union = $union;
    }
    /**
     * @return Human|Animal|null
     */
    public function getUnion()
    {
        return $this->union;
    }
    /**
     * @param Human&Animal|null $intersection
     */
    public function setIntersection($intersection) : void
    {
        $this->intersection = $intersection;
    }
    /**
     * @return Human&Animal|null
     */
    public function getIntersection()
    {
        return $this->intersection;
    }
    /**
     * @param Human|Animal|null $discriminator
     */
    public function setDiscriminator($discriminator) : void
    {
        $this->discriminator = $discriminator;
    }
    /**
     * @return Human|Animal|null
     */
    public function getDiscriminator()
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