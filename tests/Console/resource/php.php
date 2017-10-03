<?php

namespace PSX\Generation;

/**
 * @Title("meta")
 * @Description("Some meta data")
 * @PatternProperties(pattern="^tags_\d$", property=@Schema(type="string"))
 * @PatternProperties(pattern="^location_\d$", property=@Ref("PSX\Generation\Location"))
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
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }
    public function getCreateDate()
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
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
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
    public function setLat($lat)
    {
        $this->lat = $lat;
    }
    public function getLat()
    {
        return $this->lat;
    }
    public function setLong($long)
    {
        $this->long = $long;
    }
    public function getLong()
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
     * @Description("We will send no spam to this addresss")
     * @Type("string")
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
     * @Items(@Ref("PSX\Generation\Location"))
     */
    protected $locations;
    /**
     * @Key("origin")
     * @Ref("PSX\Generation\Location")
     */
    protected $origin;
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
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
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }
    public function getCategories()
    {
        return $this->categories;
    }
    public function setLocations($locations)
    {
        $this->locations = $locations;
    }
    public function getLocations()
    {
        return $this->locations;
    }
    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }
    public function getOrigin()
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
     * @Ref("PSX\Generation\Config")
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
     * @Items(@Ref("PSX\Generation\Author"))
     * @MinItems(1)
     */
    protected $receiver;
    /**
     * @Key("resources")
     * @Type("array")
     * @Items(@Schema(oneOf={@Ref("PSX\Generation\Location"), @Ref("PSX\Generation\Web")}))
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
     * @OneOf(@Ref("PSX\Generation\Author"), @Ref("PSX\Generation\Web"))
     */
    protected $source;
    /**
     * @Key("author")
     * @Ref("PSX\Generation\Author")
     */
    protected $author;
    /**
     * @Key("meta")
     * @Ref("PSX\Generation\Meta")
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
    public function setConfig($config)
    {
        $this->config = $config;
    }
    public function getConfig()
    {
        return $this->config;
    }
    public function setTags($tags)
    {
        $this->tags = $tags;
    }
    public function getTags()
    {
        return $this->tags;
    }
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }
    public function getReceiver()
    {
        return $this->receiver;
    }
    public function setResources($resources)
    {
        $this->resources = $resources;
    }
    public function getResources()
    {
        return $this->resources;
    }
    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;
    }
    public function getProfileImage()
    {
        return $this->profileImage;
    }
    public function setRead($read)
    {
        $this->read = $read;
    }
    public function getRead()
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
    public function setAuthor($author)
    {
        $this->author = $author;
    }
    public function getAuthor()
    {
        return $this->author;
    }
    public function setMeta($meta)
    {
        $this->meta = $meta;
    }
    public function getMeta()
    {
        return $this->meta;
    }
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;
    }
    public function getSendDate()
    {
        return $this->sendDate;
    }
    public function setReadDate($readDate)
    {
        $this->readDate = $readDate;
    }
    public function getReadDate()
    {
        return $this->readDate;
    }
    public function setExpires($expires)
    {
        $this->expires = $expires;
    }
    public function getExpires()
    {
        return $this->expires;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
    public function getRating()
    {
        return $this->rating;
    }
    public function setContent($content)
    {
        $this->content = $content;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function setQuestion($question)
    {
        $this->question = $question;
    }
    public function getQuestion()
    {
        return $this->question;
    }
    public function setCoffeeTime($coffeeTime)
    {
        $this->coffeeTime = $coffeeTime;
    }
    public function getCoffeeTime()
    {
        return $this->coffeeTime;
    }
    public function setProfileUri($profileUri)
    {
        $this->profileUri = $profileUri;
    }
    public function getProfileUri()
    {
        return $this->profileUri;
    }
}