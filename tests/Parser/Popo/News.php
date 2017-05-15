<?php

namespace PSX\Schema\Tests\Parser\Popo;

use PSX\Schema\Parser\Popo\Annotation as JS;

/**
 * @JS\Title("meta")
 * @JS\Description("Some meta data")
 * @JS\PatternProperties(pattern="^tags_\d$", property=@JS\Schema(type="string"))
 * @JS\PatternProperties(pattern="^location_\d$", property=@JS\Ref("PSX\Schema\Tests\Parser\Popo\Location"))
 * @JS\AdditionalProperties(false)
 */
class Meta extends \ArrayObject
{
    /**
     * @JS\Key("createDate")
     * @JS\Type("string")
     * @JS\Format("date-time")
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
 * @JS\Title("web")
 * @JS\Description("An application")
 * @JS\AdditionalProperties(@JS\Schema(type="string"))
 * @JS\Required({"name", "url"})
 * @JS\MinProperties(2)
 * @JS\MaxProperties(8)
 */
class Web extends \ArrayObject
{
    /**
     * @JS\Key("name")
     * @JS\Type("string")
     */
    public $name;
    /**
     * @JS\Key("url")
     * @JS\Type("string")
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
 * @JS\Title("location")
 * @JS\Description("Location of the person")
 * @JS\AdditionalProperties(true)
 * @JS\Required({"lat", "long"})
 */
class Location extends \ArrayObject
{
    /**
     * @JS\Key("lat")
     * @JS\Type("number")
     */
    public $lat;
    /**
     * @JS\Key("long")
     * @JS\Type("number")
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
 * @JS\Title("author")
 * @JS\Description("An simple author element with some description")
 * @JS\AdditionalProperties(false)
 * @JS\Required({"title"})
 */
class Author
{
    /**
     * @JS\Key("title")
     * @JS\Type("string")
     * @JS\Pattern("[A-z]{3,16}")
     */
    public $title;
    /**
     * @JS\Key("email")
     * @JS\Description("We will send no spam to this addresss")
     * @JS\Type("string")
     */
    public $email;
    /**
     * @JS\Key("categories")
     * @JS\Type("array")
     * @JS\Items(@JS\Schema(type="string"))
     * @JS\MaxItems(8)
     */
    public $categories;
    /**
     * @JS\Key("locations")
     * @JS\Description("Array of locations")
     * @JS\Type("array")
     * @JS\Items(@JS\Ref("PSX\Schema\Tests\Parser\Popo\Location"))
     */
    public $locations;
    /**
     * @JS\Key("origin")
     * @JS\Ref("PSX\Schema\Tests\Parser\Popo\Location")
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
 * @JS\Title("config")
 * @JS\AdditionalProperties(@JS\Schema(type="string"))
 */
class Config extends \ArrayObject
{
}
/**
 * @JS\Title("news")
 * @JS\Description("An general news entry")
 * @JS\AdditionalProperties(false)
 * @JS\Required({"receiver", "price", "content"})
 */
class News
{
    /**
     * @JS\Key("config")
     * @JS\Ref("PSX\Schema\Tests\Parser\Popo\Config")
     */
    public $config;
    /**
     * @JS\Key("tags")
     * @JS\Type("array")
     * @JS\Items(@JS\Schema(type="string"))
     * @JS\MaxItems(6)
     * @JS\MinItems(1)
     */
    public $tags;
    /**
     * @JS\Key("receiver")
     * @JS\Type("array")
     * @JS\Items(@JS\Ref("PSX\Schema\Tests\Parser\Popo\Author"))
     * @JS\MinItems(1)
     */
    public $receiver;
    /**
     * @JS\Key("resources")
     * @JS\Type("array")
     * @JS\Items(@JS\Schema(oneOf={@JS\Ref("PSX\Schema\Tests\Parser\Popo\Location"), @JS\Ref("PSX\Schema\Tests\Parser\Popo\Web")}))
     */
    public $resources;
    /**
     * @JS\Key("profileImage")
     * @JS\Type("string")
     * @JS\Format("base64")
     */
    public $profileImage;
    /**
     * @JS\Key("read")
     * @JS\Type("boolean")
     */
    public $read;
    /**
     * @JS\Key("source")
     * @JS\OneOf(@JS\Ref("PSX\Schema\Tests\Parser\Popo\Author"), @JS\Ref("PSX\Schema\Tests\Parser\Popo\Web"))
     */
    public $source;
    /**
     * @JS\Key("author")
     * @JS\Ref("PSX\Schema\Tests\Parser\Popo\Author")
     */
    public $author;
    /**
     * @JS\Key("meta")
     * @JS\Ref("PSX\Schema\Tests\Parser\Popo\Meta")
     */
    public $meta;
    /**
     * @JS\Key("sendDate")
     * @JS\Type("string")
     * @JS\Format("date")
     */
    public $sendDate;
    /**
     * @JS\Key("readDate")
     * @JS\Type("string")
     * @JS\Format("date-time")
     */
    public $readDate;
    /**
     * @JS\Key("expires")
     * @JS\Type("string")
     * @JS\Format("duration")
     */
    public $expires;
    /**
     * @JS\Key("price")
     * @JS\Type("number")
     * @JS\Maximum(100)
     * @JS\Minimum(1)
     */
    public $price;
    /**
     * @JS\Key("rating")
     * @JS\Type("integer")
     * @JS\Maximum(5)
     * @JS\Minimum(1)
     */
    public $rating;
    /**
     * @JS\Key("content")
     * @JS\Description("Contains the main content of the news entry")
     * @JS\Type("string")
     * @JS\MaxLength(512)
     * @JS\MinLength(3)
     */
    public $content;
    /**
     * @JS\Key("question")
     * @JS\Enum({"foo", "bar"})
     * @JS\Type("string")
     */
    public $question;
    /**
     * @JS\Key("coffeeTime")
     * @JS\Type("string")
     * @JS\Format("time")
     */
    public $coffeeTime;
    /**
     * @JS\Key("profileUri")
     * @JS\Type("string")
     * @JS\Format("uri")
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
