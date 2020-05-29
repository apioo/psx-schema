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
class Animal
{
    /**
     * @var string
     */
    protected $nickname;
    /**
     * @param string $nickname
     */
    public function setNickname(?string $nickname)
    {
        $this->nickname = $nickname;
    }
    /**
     * @return string
     */
    public function getNickname() : ?string
    {
        return $this->nickname;
    }
}