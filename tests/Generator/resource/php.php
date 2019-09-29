<?php

namespace PSX\Schema\Tests\Generator;

/**
 * @Title("meta")
 * @Description("Some meta data")
 * @PatternProperties(pattern="^tags_\d$", property=@Schema(type="string"))
 * @PatternProperties(pattern="^location_\d$", property=@Ref("PSX\Schema\Tests\Generator\Location"))
 * @AdditionalProperties(false)
 */
class Meta extends \ArrayObject
{
    /**
     * @Key("createDate")
     * @Type("string")
     * @Format("date-time")
     */
    protected $createDate;
    public function setCreateDate(?\DateTime $createDate)
    {
        $this->createDate = $createDate;
    }
    public function getCreateDate() : ?\DateTime
    {
        return $this->createDate;
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
class Web extends \ArrayObject
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
    public function setName(?string $name)
    {
        $this->name = $name;
    }
    public function getName() : ?string
    {
        return $this->name;
    }
    public function setUrl(?string $url)
    {
        $this->url = $url;
    }
    public function getUrl() : ?string
    {
        return $this->url;
    }
}
/**
 * @Title("location")
 * @Description("Location of the person")
 * @AdditionalProperties(true)
 * @Required({"lat", "long"})
 */
class Location extends \ArrayObject
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
    public function setLat(?float $lat)
    {
        $this->lat = $lat;
    }
    public function getLat() : ?float
    {
        return $this->lat;
    }
    public function setLong(?float $long)
    {
        $this->long = $long;
    }
    public function getLong() : ?float
    {
        return $this->long;
    }
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
     * @Items(@Ref("PSX\Schema\Tests\Generator\Location"))
     */
    protected $locations;
    /**
     * @Key("origin")
     * @Ref("PSX\Schema\Tests\Generator\Location")
     */
    protected $origin;
    public function setTitle(?string $title)
    {
        $this->title = $title;
    }
    public function getTitle() : ?string
    {
        return $this->title;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setCategories(?array $categories)
    {
        $this->categories = $categories;
    }
    public function getCategories() : ?array
    {
        return $this->categories;
    }
    public function setLocations(?array $locations)
    {
        $this->locations = $locations;
    }
    public function getLocations() : ?array
    {
        return $this->locations;
    }
    public function setOrigin(?Location $origin)
    {
        $this->origin = $origin;
    }
    public function getOrigin() : ?Location
    {
        return $this->origin;
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
 * @Title("news")
 * @Description("An general news entry")
 * @AdditionalProperties(false)
 * @Required({"receiver", "price", "content"})
 */
class News
{
    /**
     * @Key("config")
     * @Ref("PSX\Schema\Tests\Generator\Config")
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
     * @Items(@Ref("PSX\Schema\Tests\Generator\Author"))
     * @MinItems(1)
     */
    protected $receiver;
    /**
     * @Key("resources")
     * @Type("array")
     * @Items(@Schema(title="resource", oneOf={@Ref("PSX\Schema\Tests\Generator\Location"), @Ref("PSX\Schema\Tests\Generator\Web")}))
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
     * @OneOf(@Ref("PSX\Schema\Tests\Generator\Author"), @Ref("PSX\Schema\Tests\Generator\Web"))
     */
    protected $source;
    /**
     * @Key("author")
     * @Ref("PSX\Schema\Tests\Generator\Author")
     */
    protected $author;
    /**
     * @Key("meta")
     * @Ref("PSX\Schema\Tests\Generator\Meta")
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
    public function setConfig(?Config $config)
    {
        $this->config = $config;
    }
    public function getConfig() : ?Config
    {
        return $this->config;
    }
    public function setTags(?array $tags)
    {
        $this->tags = $tags;
    }
    public function getTags() : ?array
    {
        return $this->tags;
    }
    public function setReceiver(?array $receiver)
    {
        $this->receiver = $receiver;
    }
    public function getReceiver() : ?array
    {
        return $this->receiver;
    }
    public function setResources(?array $resources)
    {
        $this->resources = $resources;
    }
    public function getResources() : ?array
    {
        return $this->resources;
    }
    public function setProfileImage(?string $profileImage)
    {
        $this->profileImage = $profileImage;
    }
    public function getProfileImage() : ?string
    {
        return $this->profileImage;
    }
    public function setRead(?bool $read)
    {
        $this->read = $read;
    }
    public function getRead() : ?bool
    {
        return $this->read;
    }
    public function setSource($source)
    {
        $this->source = $source;
    }
    public function getSource()
    {
        return $this->source;
    }
    public function setAuthor(?Author $author)
    {
        $this->author = $author;
    }
    public function getAuthor() : ?Author
    {
        return $this->author;
    }
    public function setMeta(?Meta $meta)
    {
        $this->meta = $meta;
    }
    public function getMeta() : ?Meta
    {
        return $this->meta;
    }
    public function setSendDate(?\DateTime $sendDate)
    {
        $this->sendDate = $sendDate;
    }
    public function getSendDate() : ?\DateTime
    {
        return $this->sendDate;
    }
    public function setReadDate(?\DateTime $readDate)
    {
        $this->readDate = $readDate;
    }
    public function getReadDate() : ?\DateTime
    {
        return $this->readDate;
    }
    public function setExpires(?\DateInterval $expires)
    {
        $this->expires = $expires;
    }
    public function getExpires() : ?\DateInterval
    {
        return $this->expires;
    }
    public function setPrice(?float $price)
    {
        $this->price = $price;
    }
    public function getPrice() : ?float
    {
        return $this->price;
    }
    public function setRating(?int $rating)
    {
        $this->rating = $rating;
    }
    public function getRating() : ?int
    {
        return $this->rating;
    }
    public function setContent(?string $content)
    {
        $this->content = $content;
    }
    public function getContent() : ?string
    {
        return $this->content;
    }
    public function setQuestion(?string $question)
    {
        $this->question = $question;
    }
    public function getQuestion() : ?string
    {
        return $this->question;
    }
    public function setVersion(?string $version)
    {
        $this->version = $version;
    }
    public function getVersion() : ?string
    {
        return $this->version;
    }
    public function setCoffeeTime(?\DateTime $coffeeTime)
    {
        $this->coffeeTime = $coffeeTime;
    }
    public function getCoffeeTime() : ?\DateTime
    {
        return $this->coffeeTime;
    }
    public function setProfileUri(?string $profileUri)
    {
        $this->profileUri = $profileUri;
    }
    public function getProfileUri() : ?string
    {
        return $this->profileUri;
    }
    public function setCaptcha(?string $captcha)
    {
        $this->captcha = $captcha;
    }
    public function getCaptcha() : ?string
    {
        return $this->captcha;
    }
}