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
class Animal
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
}
class Union
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
}