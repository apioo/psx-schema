/**
 * @Title("news")
 * @Description("An general news entry")
 * @AdditionalProperties(false)
 * @Required({"receiver", "price", "content"})
 */
class News
{
    /**
     * @Key("config")
     * @Ref("\Config")
     */
    protected $config;
    /**
     * @Key("tags")
     * @Type("array")
     * @Items(@Schema(type="string"))
     * @MaxItems(6)
     * @MinItems(1)
     */
    protected $tags;
    /**
     * @Key("receiver")
     * @Type("array")
     * @Items(@Ref("\Author"))
     * @MinItems(1)
     */
    protected $receiver;
    /**
     * @Key("resources")
     * @Type("array")
     * @Items(@Schema(title="resource", oneOf={@Ref("\Location"), @Ref("\Web")}))
     */
    protected $resources;
    /**
     * @Key("profileImage")
     * @Type("string")
     * @Format("base64")
     */
    protected $profileImage;
    /**
     * @Key("read")
     * @Type("boolean")
     */
    protected $read;
    /**
     * @Key("source")
     * @Title("source")
     * @OneOf(@Ref("\Author"), @Ref("\Web"))
     */
    protected $source;
    /**
     * @Key("author")
     * @Ref("\Author")
     */
    protected $author;
    /**
     * @Key("meta")
     * @Ref("\Meta")
     */
    protected $meta;
    /**
     * @Key("sendDate")
     * @Type("string")
     * @Format("date")
     */
    protected $sendDate;
    /**
     * @Key("readDate")
     * @Type("string")
     * @Format("date-time")
     */
    protected $readDate;
    /**
     * @Key("expires")
     * @Type("string")
     * @Format("duration")
     */
    protected $expires;
    /**
     * @Key("price")
     * @Type("number")
     * @Maximum(100)
     * @Minimum(1)
     */
    protected $price;
    /**
     * @Key("rating")
     * @Type("integer")
     * @Maximum(5)
     * @Minimum(1)
     */
    protected $rating;
    /**
     * @Key("content")
     * @Description("Contains the main content of the news entry")
     * @Type("string")
     * @MaxLength(512)
     * @MinLength(3)
     */
    protected $content;
    /**
     * @Key("question")
     * @Enum({"foo", "bar"})
     * @Type("string")
     */
    protected $question;
    /**
     * @Key("version")
     * @Type("string")
     */
    protected $version;
    /**
     * @Key("coffeeTime")
     * @Type("string")
     * @Format("time")
     */
    protected $coffeeTime;
    /**
     * @Key("profileUri")
     * @Type("string")
     * @Format("uri")
     */
    protected $profileUri;
    /**
     * @Key("g-recaptcha-response")
     * @Type("string")
     */
    protected $captcha;
    /**
     * @param Config $config
     */
    public function setConfig(?Config $config)
    {
        $this->config = $config;
    }
    /**
     * @return Config
     */
    public function getConfig() : ?Config
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
     * @param Meta $meta
     */
    public function setMeta(?Meta $meta)
    {
        $this->meta = $meta;
    }
    /**
     * @return Meta
     */
    public function getMeta() : ?Meta
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
/**
 * @Title("config")
 * @AdditionalProperties(@Schema(type="string"))
 */
class Config extends \ArrayObject
{
}
/**
 * @Title("author")
 * @Description("An simple author element with some description")
 * @AdditionalProperties(false)
 * @Required({"title"})
 */
class Author
{
    /**
     * @Key("title")
     * @Type("string")
     * @Pattern("[A-z]{3,16}")
     */
    protected $title;
    /**
     * @Key("email")
     * @Description("We will send no spam to this address")
     * @Type({"string", "null"})
     */
    protected $email;
    /**
     * @Key("categories")
     * @Type("array")
     * @Items(@Schema(type="string"))
     * @MaxItems(8)
     */
    protected $categories;
    /**
     * @Key("locations")
     * @Description("Array of locations")
     * @Type("array")
     * @Items(@Ref("\Location"))
     */
    protected $locations;
    /**
     * @Key("origin")
     * @Ref("\Location")
     */
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
     * @param string|null $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * @return string|null
     */
    public function getEmail()
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
 * @Title("location")
 * @Description("Location of the person")
 * @AdditionalProperties(true)
 * @Required({"lat", "long"})
 */
class Location
{
    /**
     * @Key("lat")
     * @Type("number")
     */
    protected $lat;
    /**
     * @Key("long")
     * @Type("number")
     */
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
 * @Title("web")
 * @Description("An application")
 * @AdditionalProperties(@Schema(type="string"))
 * @Required({"name", "url"})
 * @MinProperties(2)
 * @MaxProperties(8)
 */
class Web
{
    /**
     * @Key("name")
     * @Type("string")
     */
    protected $name;
    /**
     * @Key("url")
     * @Type("string")
     */
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
 * @Title("meta")
 * @Description("Some meta data")
 * @PatternProperties(pattern="^tags_\d$", property=@Schema(type="string"))
 * @PatternProperties(pattern="^location_\d$", property=@Ref("\Location"))
 * @AdditionalProperties(false)
 */
class Meta
{
    /**
     * @Key("createDate")
     * @Type("string")
     * @Format("date-time")
     */
    protected $createDate;
    /**
     * @param \DateTime $createDate
     */
    public function setCreateDate(?\DateTime $createDate)
    {
        $this->createDate = $createDate;
    }
    /**
     * @return \DateTime
     */
    public function getCreateDate() : ?\DateTime
    {
        return $this->createDate;
    }
}