/**
 * @Description("Location of the person")
 * @Required({"lat", "long"})
 */
class Location
{
    /**
     * @var float|null
     */
    protected $lat;
    /**
     * @var float|null
     */
    protected $long;
    /**
     * @param float|null $lat
     */
    public function setLat(?float $lat) : void
    {
        $this->lat = $lat;
    }
    /**
     * @return float|null
     */
    public function getLat() : ?float
    {
        return $this->lat;
    }
    /**
     * @param float|null $long
     */
    public function setLong(?float $long) : void
    {
        $this->long = $long;
    }
    /**
     * @return float|null
     */
    public function getLong() : ?float
    {
        return $this->long;
    }
}
/**
 * @Description("An application")
 * @Required({"name", "url"})
 */
class Web
{
    /**
     * @var string|null
     */
    protected $name;
    /**
     * @var string|null
     */
    protected $url;
    /**
     * @param string|null $name
     */
    public function setName(?string $name) : void
    {
        $this->name = $name;
    }
    /**
     * @return string|null
     */
    public function getName() : ?string
    {
        return $this->name;
    }
    /**
     * @param string|null $url
     */
    public function setUrl(?string $url) : void
    {
        $this->url = $url;
    }
    /**
     * @return string|null
     */
    public function getUrl() : ?string
    {
        return $this->url;
    }
}
/**
 * @Description("An simple author element with some description")
 * @Required({"title"})
 */
class Author
{
    /**
     * @var string|null
     * @Pattern("[A-z]{3,16}")
     */
    protected $title;
    /**
     * @var string|null
     * @Description("We will send no spam to this address")
     * @Nullable(true)
     */
    protected $email;
    /**
     * @var array<string>|null
     * @MaxItems(8)
     */
    protected $categories;
    /**
     * @var array<Location>|null
     * @Description("Array of locations")
     */
    protected $locations;
    /**
     * @var Location|null
     */
    protected $origin;
    /**
     * @param string|null $title
     */
    public function setTitle(?string $title) : void
    {
        $this->title = $title;
    }
    /**
     * @return string|null
     */
    public function getTitle() : ?string
    {
        return $this->title;
    }
    /**
     * @param string|null $email
     */
    public function setEmail(?string $email) : void
    {
        $this->email = $email;
    }
    /**
     * @return string|null
     */
    public function getEmail() : ?string
    {
        return $this->email;
    }
    /**
     * @param array<string>|null $categories
     */
    public function setCategories(?array $categories) : void
    {
        $this->categories = $categories;
    }
    /**
     * @return array<string>|null
     */
    public function getCategories() : ?array
    {
        return $this->categories;
    }
    /**
     * @param array<Location>|null $locations
     */
    public function setLocations(?array $locations) : void
    {
        $this->locations = $locations;
    }
    /**
     * @return array<Location>|null
     */
    public function getLocations() : ?array
    {
        return $this->locations;
    }
    /**
     * @param Location|null $origin
     */
    public function setOrigin(?Location $origin) : void
    {
        $this->origin = $origin;
    }
    /**
     * @return Location|null
     */
    public function getOrigin() : ?Location
    {
        return $this->origin;
    }
}
/**
 * @extends \PSX\Record\Record<string>
 * @MinProperties(1)
 * @MaxProperties(6)
 */
class Meta extends \PSX\Record\Record
{
}
/**
 * @Description("An general news entry")
 * @Required({"receiver", "price", "content"})
 */
class News
{
    /**
     * @var Meta|null
     */
    protected $config;
    /**
     * @var array<string>|null
     * @MinItems(1)
     * @MaxItems(6)
     */
    protected $tags;
    /**
     * @var array<Author>|null
     * @MinItems(1)
     */
    protected $receiver;
    /**
     * @var array<Location|Web>|null
     */
    protected $resources;
    /**
     * @var resource|null
     */
    protected $profileImage;
    /**
     * @var bool|null
     */
    protected $read;
    /**
     * @var Author|Web|null
     */
    protected $source;
    /**
     * @var Author|null
     */
    protected $author;
    /**
     * @var Meta|null
     */
    protected $meta;
    /**
     * @var \PSX\DateTime\Date|null
     */
    protected $sendDate;
    /**
     * @var \DateTime|null
     */
    protected $readDate;
    /**
     * @var \DateInterval|null
     */
    protected $expires;
    /**
     * @var float|null
     * @Minimum(1)
     * @Maximum(100)
     */
    protected $price;
    /**
     * @var int|null
     * @Minimum(1)
     * @Maximum(5)
     */
    protected $rating;
    /**
     * @var string|null
     * @Description("Contains the main content of the news entry")
     * @MinLength(3)
     * @MaxLength(512)
     */
    protected $content;
    /**
     * @var string|null
     * @Enum({"foo", "bar"})
     */
    protected $question;
    /**
     * @var string|null
     */
    protected $version = 'http://foo.bar';
    /**
     * @var \PSX\DateTime\Time|null
     */
    protected $coffeeTime;
    /**
     * @var \PSX\Uri\Uri|null
     */
    protected $profileUri;
    /**
     * @var string|null
     * @Key("g-recaptcha-response")
     */
    protected $captcha;
    /**
     * @param Meta|null $config
     */
    public function setConfig(?Meta $config) : void
    {
        $this->config = $config;
    }
    /**
     * @return Meta|null
     */
    public function getConfig() : ?Meta
    {
        return $this->config;
    }
    /**
     * @param array<string>|null $tags
     */
    public function setTags(?array $tags) : void
    {
        $this->tags = $tags;
    }
    /**
     * @return array<string>|null
     */
    public function getTags() : ?array
    {
        return $this->tags;
    }
    /**
     * @param array<Author>|null $receiver
     */
    public function setReceiver(?array $receiver) : void
    {
        $this->receiver = $receiver;
    }
    /**
     * @return array<Author>|null
     */
    public function getReceiver() : ?array
    {
        return $this->receiver;
    }
    /**
     * @param array<Location|Web>|null $resources
     */
    public function setResources(?array $resources) : void
    {
        $this->resources = $resources;
    }
    /**
     * @return array<Location|Web>|null
     */
    public function getResources() : ?array
    {
        return $this->resources;
    }
    /**
     * @param resource|null $profileImage
     */
    public function setProfileImage($profileImage) : void
    {
        $this->profileImage = $profileImage;
    }
    /**
     * @return resource|null
     */
    public function getProfileImage()
    {
        return $this->profileImage;
    }
    /**
     * @param bool|null $read
     */
    public function setRead(?bool $read) : void
    {
        $this->read = $read;
    }
    /**
     * @return bool|null
     */
    public function getRead() : ?bool
    {
        return $this->read;
    }
    /**
     * @param Author|Web|null $source
     */
    public function setSource($source) : void
    {
        $this->source = $source;
    }
    /**
     * @return Author|Web|null
     */
    public function getSource()
    {
        return $this->source;
    }
    /**
     * @param Author|null $author
     */
    public function setAuthor(?Author $author) : void
    {
        $this->author = $author;
    }
    /**
     * @return Author|null
     */
    public function getAuthor() : ?Author
    {
        return $this->author;
    }
    /**
     * @param Meta|null $meta
     */
    public function setMeta(?Meta $meta) : void
    {
        $this->meta = $meta;
    }
    /**
     * @return Meta|null
     */
    public function getMeta() : ?Meta
    {
        return $this->meta;
    }
    /**
     * @param \PSX\DateTime\Date|null $sendDate
     */
    public function setSendDate(?\PSX\DateTime\Date $sendDate) : void
    {
        $this->sendDate = $sendDate;
    }
    /**
     * @return \PSX\DateTime\Date|null
     */
    public function getSendDate() : ?\PSX\DateTime\Date
    {
        return $this->sendDate;
    }
    /**
     * @param \DateTime|null $readDate
     */
    public function setReadDate(?\DateTime $readDate) : void
    {
        $this->readDate = $readDate;
    }
    /**
     * @return \DateTime|null
     */
    public function getReadDate() : ?\DateTime
    {
        return $this->readDate;
    }
    /**
     * @param \DateInterval|null $expires
     */
    public function setExpires(?\DateInterval $expires) : void
    {
        $this->expires = $expires;
    }
    /**
     * @return \DateInterval|null
     */
    public function getExpires() : ?\DateInterval
    {
        return $this->expires;
    }
    /**
     * @param float|null $price
     */
    public function setPrice(?float $price) : void
    {
        $this->price = $price;
    }
    /**
     * @return float|null
     */
    public function getPrice() : ?float
    {
        return $this->price;
    }
    /**
     * @param int|null $rating
     */
    public function setRating(?int $rating) : void
    {
        $this->rating = $rating;
    }
    /**
     * @return int|null
     */
    public function getRating() : ?int
    {
        return $this->rating;
    }
    /**
     * @param string|null $content
     */
    public function setContent(?string $content) : void
    {
        $this->content = $content;
    }
    /**
     * @return string|null
     */
    public function getContent() : ?string
    {
        return $this->content;
    }
    /**
     * @param string|null $question
     */
    public function setQuestion(?string $question) : void
    {
        $this->question = $question;
    }
    /**
     * @return string|null
     */
    public function getQuestion() : ?string
    {
        return $this->question;
    }
    /**
     * @param string|null $version
     */
    public function setVersion(?string $version) : void
    {
        $this->version = $version;
    }
    /**
     * @return string|null
     */
    public function getVersion() : ?string
    {
        return $this->version;
    }
    /**
     * @param \PSX\DateTime\Time|null $coffeeTime
     */
    public function setCoffeeTime(?\PSX\DateTime\Time $coffeeTime) : void
    {
        $this->coffeeTime = $coffeeTime;
    }
    /**
     * @return \PSX\DateTime\Time|null
     */
    public function getCoffeeTime() : ?\PSX\DateTime\Time
    {
        return $this->coffeeTime;
    }
    /**
     * @param \PSX\Uri\Uri|null $profileUri
     */
    public function setProfileUri(?\PSX\Uri\Uri $profileUri) : void
    {
        $this->profileUri = $profileUri;
    }
    /**
     * @return \PSX\Uri\Uri|null
     */
    public function getProfileUri() : ?\PSX\Uri\Uri
    {
        return $this->profileUri;
    }
    /**
     * @param string|null $captcha
     */
    public function setCaptcha(?string $captcha) : void
    {
        $this->captcha = $captcha;
    }
    /**
     * @return string|null
     */
    public function getCaptcha() : ?string
    {
        return $this->captcha;
    }
}