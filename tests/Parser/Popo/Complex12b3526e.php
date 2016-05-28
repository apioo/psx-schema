<?php

namespace PSX\Schema\Tests\Parser\Popo;

/**
 * @Title("config")
 * @AdditionalProperties("string")
 */
class Complex72828040 extends \ArrayObject
{
}
/**
 * @Title("location")
 * @Description("Location of the person")
 * @AdditionalProperties(true)
 */
class Complexb33b896f extends \ArrayObject
{
    /**
     * @Key("lat")
     * @Type("float")
     */
    public $lat;
    /**
     * @Key("long")
     * @Type("float")
     */
    public $long;
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
 */
class Complex4770be5a
{
    /**
     * @Key("title")
     * @Type("string")
     * @Required
     * @Pattern("[A-z]{3,16}")
     */
    public $title;
    /**
     * @Key("email")
     * @Type("string")
     * @Description("We will send no spam to this addresss")
     */
    public $email;
    /**
     * @Key("categories")
     * @Type("array<string>")
     * @MaxItems(8)
     */
    public $categories;
    /**
     * @Key("locations")
     * @Type("array<PSX\Schema\Tests\Parser\Popo\Complexb33b896f>")
     * @Description("Array of locations")
     */
    public $locations;
    /**
     * @Key("origin")
     * @Type("PSX\Schema\Tests\Parser\Popo\Complexb33b896f")
     * @Description("Location of the person")
     */
    public $origin;
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
 * @Title("web")
 * @Description("An application")
 * @AdditionalProperties("string")
 * @MinProperties(2)
 * @MaxProperties(8)
 */
class Complex57c64cac extends \ArrayObject
{
    /**
     * @Key("name")
     * @Type("string")
     */
    public $name;
    /**
     * @Key("url")
     * @Type("string")
     */
    public $url;
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
 * @Title("meta")
 * @Description("Some meta data")
 * @AdditionalProperties(false)
 * @PatternProperty(pattern="^tags_\d$", type="string")
 * @PatternProperty(pattern="^location_\d$", type="PSX\Schema\Tests\Parser\Popo\Complexb33b896f")
 */
class Complex68a5de10 extends \ArrayObject
{
    /**
     * @Key("createDate")
     * @Type("dateTime")
     */
    public $createDate;
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
 * @Title("news")
 * @Description("An general news entry")
 * @AdditionalProperties(false)
 */
class Complex12b3526e
{
    /**
     * @Key("config")
     * @Type("PSX\Schema\Tests\Parser\Popo\Complex72828040")
     */
    public $config;
    /**
     * @Key("tags")
     * @Type("array<string>")
     * @MinItems(1)
     * @MaxItems(6)
     */
    public $tags;
    /**
     * @Key("receiver")
     * @Type("array<PSX\Schema\Tests\Parser\Popo\Complex4770be5a>")
     * @Required
     * @MinItems(1)
     */
    public $receiver;
    /**
     * @Key("resources")
     * @Type("array<choice<PSX\Schema\Tests\Parser\Popo\Complexb33b896f,PSX\Schema\Tests\Parser\Popo\Complex57c64cac>>")
     */
    public $resources;
    /**
     * @Key("profileImage")
     * @Type("binary")
     */
    public $profileImage;
    /**
     * @Key("read")
     * @Type("boolean")
     */
    public $read;
    /**
     * @Key("source")
     * @Type("choice<PSX\Schema\Tests\Parser\Popo\Complex4770be5a,PSX\Schema\Tests\Parser\Popo\Complex57c64cac>")
     */
    public $source;
    /**
     * @Key("author")
     * @Type("PSX\Schema\Tests\Parser\Popo\Complex4770be5a")
     * @Description("An simple author element with some description")
     */
    public $author;
    /**
     * @Key("meta")
     * @Type("PSX\Schema\Tests\Parser\Popo\Complex68a5de10")
     * @Description("Some meta data")
     */
    public $meta;
    /**
     * @Key("sendDate")
     * @Type("date")
     */
    public $sendDate;
    /**
     * @Key("readDate")
     * @Type("dateTime")
     */
    public $readDate;
    /**
     * @Key("expires")
     * @Type("duration")
     */
    public $expires;
    /**
     * @Key("price")
     * @Type("float")
     * @Required
     * @Minimum(1)
     * @Maximum(100)
     */
    public $price;
    /**
     * @Key("rating")
     * @Type("integer")
     * @Minimum(1)
     * @Maximum(5)
     */
    public $rating;
    /**
     * @Key("content")
     * @Type("string")
     * @Required
     * @Description("Contains the main content of the news entry")
     * @MinLength(3)
     * @MaxLength(512)
     */
    public $content;
    /**
     * @Key("question")
     * @Type("string")
     * @Enum({"foo", "bar"})
     */
    public $question;
    /**
     * @Key("coffeeTime")
     * @Type("time")
     */
    public $coffeeTime;
    /**
     * @Key("profileUri")
     * @Type("uri")
     */
    public $profileUri;
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