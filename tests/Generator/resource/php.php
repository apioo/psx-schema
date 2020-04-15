/**
 * Location of the person
 */
class Location
{
    protected $lat;
    protected $long;
    /**
     * @param float $lat
     */
    public function setLat(?float $lat)
    {
        $this->lat = $lat;
    }
    /**
     * @return float
     */
    public function getLat() : ?float
    {
        return $this->lat;
    }
    /**
     * @param float $long
     */
    public function setLong(?float $long)
    {
        $this->long = $long;
    }
    /**
     * @return float
     */
    public function getLong() : ?float
    {
        return $this->long;
    }
}
/**
 * An application
 */
class Web
{
    protected $name;
    protected $url;
    /**
     * @param string $name
     */
    public function setName(?string $name)
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getName() : ?string
    {
        return $this->name;
    }
    /**
     * @param string $url
     */
    public function setUrl(?string $url)
    {
        $this->url = $url;
    }
    /**
     * @return string
     */
    public function getUrl() : ?string
    {
        return $this->url;
    }
}
/**
 * Array of locations
 */
class Author
{
    protected $title;
    protected $email;
    protected $categories;
    protected $locations;
    protected $origin;
    /**
     * @param string $title
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;
    }
    /**
     * @return string
     */
    public function getTitle() : ?string
    {
        return $this->title;
    }
    /**
     * @param string $email
     */
    public function setEmail(?string $email)
    {
        $this->email = $email;
    }
    /**
     * @return string
     */
    public function getEmail() : ?string
    {
        return $this->email;
    }
    /**
     * @param array<string> $categories
     */
    public function setCategories(?array $categories)
    {
        $this->categories = $categories;
    }
    /**
     * @return array<string>
     */
    public function getCategories() : ?array
    {
        return $this->categories;
    }
    /**
     * @param array<Location> $locations
     */
    public function setLocations(?array $locations)
    {
        $this->locations = $locations;
    }
    /**
     * @return array<Location>
     */
    public function getLocations() : ?array
    {
        return $this->locations;
    }
    /**
     * @param Location $origin
     */
    public function setOrigin(?Location $origin)
    {
        $this->origin = $origin;
    }
    /**
     * @return Location
     */
    public function getOrigin() : ?Location
    {
        return $this->origin;
    }
}

/**
 * Contains the main content of the news entry
 */
class RootSchema
{
    protected $config;
    protected $tags;
    protected $receiver;
    protected $resources;
    protected $profileImage;
    protected $read;
    protected $source;
    protected $author;
    protected $meta;
    protected $sendDate;
    protected $readDate;
    protected $expires;
    protected $price;
    protected $rating;
    protected $content;
    protected $question;
    protected $version;
    protected $coffeeTime;
    protected $profileUri;
    protected $captcha;
    /**
     * @param array<string, string> $config
     */
    public function setConfig(?array $config)
    {
        $this->config = $config;
    }
    /**
     * @return array<string, string>
     */
    public function getConfig() : ?array
    {
        return $this->config;
    }
    /**
     * @param array<string> $tags
     */
    public function setTags(?array $tags)
    {
        $this->tags = $tags;
    }
    /**
     * @return array<string>
     */
    public function getTags() : ?array
    {
        return $this->tags;
    }
    /**
     * @param array<Author> $receiver
     */
    public function setReceiver(?array $receiver)
    {
        $this->receiver = $receiver;
    }
    /**
     * @return array<Author>
     */
    public function getReceiver() : ?array
    {
        return $this->receiver;
    }
    /**
     * @param array<Location|Web> $resources
     */
    public function setResources(?array $resources)
    {
        $this->resources = $resources;
    }
    /**
     * @return array<Location|Web>
     */
    public function getResources() : ?array
    {
        return $this->resources;
    }
    /**
     * @param string $profileImage
     */
    public function setProfileImage(?string $profileImage)
    {
        $this->profileImage = $profileImage;
    }
    /**
     * @return string
     */
    public function getProfileImage() : ?string
    {
        return $this->profileImage;
    }
    /**
     * @param bool $read
     */
    public function setRead(?bool $read)
    {
        $this->read = $read;
    }
    /**
     * @return bool
     */
    public function getRead() : ?bool
    {
        return $this->read;
    }
    /**
     * @param Author|Web $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }
    /**
     * @return Author|Web
     */
    public function getSource()
    {
        return $this->source;
    }
    /**
     * @param Author $author
     */
    public function setAuthor(?Author $author)
    {
        $this->author = $author;
    }
    /**
     * @return Author
     */
    public function getAuthor() : ?Author
    {
        return $this->author;
    }
    /**
     * @param array<string, string> $meta
     */
    public function setMeta(?array $meta)
    {
        $this->meta = $meta;
    }
    /**
     * @return array<string, string>
     */
    public function getMeta() : ?array
    {
        return $this->meta;
    }
    /**
     * @param \DateTime $sendDate
     */
    public function setSendDate(?\DateTime $sendDate)
    {
        $this->sendDate = $sendDate;
    }
    /**
     * @return \DateTime
     */
    public function getSendDate() : ?\DateTime
    {
        return $this->sendDate;
    }
    /**
     * @param \DateTime $readDate
     */
    public function setReadDate(?\DateTime $readDate)
    {
        $this->readDate = $readDate;
    }
    /**
     * @return \DateTime
     */
    public function getReadDate() : ?\DateTime
    {
        return $this->readDate;
    }
    /**
     * @param \DateInterval $expires
     */
    public function setExpires(?\DateInterval $expires)
    {
        $this->expires = $expires;
    }
    /**
     * @return \DateInterval
     */
    public function getExpires() : ?\DateInterval
    {
        return $this->expires;
    }
    /**
     * @param float $price
     */
    public function setPrice(?float $price)
    {
        $this->price = $price;
    }
    /**
     * @return float
     */
    public function getPrice() : ?float
    {
        return $this->price;
    }
    /**
     * @param int $rating
     */
    public function setRating(?int $rating)
    {
        $this->rating = $rating;
    }
    /**
     * @return int
     */
    public function getRating() : ?int
    {
        return $this->rating;
    }
    /**
     * @param string $content
     */
    public function setContent(?string $content)
    {
        $this->content = $content;
    }
    /**
     * @return string
     */
    public function getContent() : ?string
    {
        return $this->content;
    }
    /**
     * @param string $question
     */
    public function setQuestion(?string $question)
    {
        $this->question = $question;
    }
    /**
     * @return string
     */
    public function getQuestion() : ?string
    {
        return $this->question;
    }
    /**
     * @param string $version
     */
    public function setVersion(?string $version)
    {
        $this->version = $version;
    }
    /**
     * @return string
     */
    public function getVersion() : ?string
    {
        return $this->version;
    }
    /**
     * @param \DateTime $coffeeTime
     */
    public function setCoffeeTime(?\DateTime $coffeeTime)
    {
        $this->coffeeTime = $coffeeTime;
    }
    /**
     * @return \DateTime
     */
    public function getCoffeeTime() : ?\DateTime
    {
        return $this->coffeeTime;
    }
    /**
     * @param string $profileUri
     */
    public function setProfileUri(?string $profileUri)
    {
        $this->profileUri = $profileUri;
    }
    /**
     * @return string
     */
    public function getProfileUri() : ?string
    {
        return $this->profileUri;
    }
    /**
     * @param string $captcha
     */
    public function setCaptcha(?string $captcha)
    {
        $this->captcha = $captcha;
    }
    /**
     * @return string
     */
    public function getCaptcha() : ?string
    {
        return $this->captcha;
    }
}