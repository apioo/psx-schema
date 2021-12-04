<?php

namespace PSX\Schema\Tests\Parser\Popo;

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Key;
use PSX\Schema\Attribute\Maximum;
use PSX\Schema\Attribute\MaxItems;
use PSX\Schema\Attribute\MaxLength;
use PSX\Schema\Attribute\MaxProperties;
use PSX\Schema\Attribute\Minimum;
use PSX\Schema\Attribute\MinItems;
use PSX\Schema\Attribute\MinLength;
use PSX\Schema\Attribute\MinProperties;
use PSX\Schema\Attribute\Nullable;
use PSX\Schema\Attribute\Pattern;
use PSX\Schema\Attribute\Required;

#[Description('Location of the person')]
#[Required(['lat', 'long'])]
class LocationAttribute
{
    protected ?float $lat;
    protected ?float $long;

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
#[Description('An application')]
#[Required(['name', 'url'])]
class WebAttribute
{
    protected ?string $name;
    protected ?string $url;

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
#[Description('An simple author element with some description')]
#[Required(['title'])]
class AuthorAttribute
{
    #[Pattern('[A-z]{3,16}')]
    protected ?string $title;

    #[Description('We will send no spam to this address')]
    #[Nullable(true)]
    protected $email;

    /**
     * @var array<string>
     */
    #[MaxItems(8)]
    protected array $categories;

    /**
     * @var array<LocationAttribute>
     */
    #[Description('Array of locations')]
    protected $locations;

    protected ?LocationAttribute $origin;

    public function setTitle(?string $title)
    {
        $this->title = $title;
    }

    public function getTitle() : ?string
    {
        return $this->title;
    }

    public function setEmail(?string $email)
    {
        $this->email = $email;
    }

    public function getEmail() : ?string
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

    public function setOrigin(?LocationAttribute $origin)
    {
        $this->origin = $origin;
    }

    public function getOrigin() : ?LocationAttribute
    {
        return $this->origin;
    }
}

/**
 * @extends \PSX\Record\Record<string>
 */
#[MinProperties(1)]
#[MaxProperties(6)]
class MetaAttribute extends \PSX\Record\Record
{
}

#[Description('An general news entry')]
#[Required(['receiver', 'price', 'content'])]
class NewsAttribute
{
    protected ?MetaAttribute $config;

    /**
     * @var array<string>
     */
    #[MinItems(1)]
    #[MaxItems(6)]
    protected $tags;

    /**
     * @var array<AuthorAttribute>
     */
    #[MinItems(1)]
    protected $receiver;

    /**
     * @var array<LocationAttribute|WebAttribute>
     */
    protected $resources;

    /**
     * @var resource
     */
    protected $profileImage;

    protected ?bool $read;
    /**
     * @var AuthorAttribute|WebAttribute
     */
    protected $source;

    protected ?AuthorAttribute $author;
    protected ?MetaAttribute $meta;
    protected ?\PSX\DateTime\Date $sendDate;
    protected ?\DateTime $readDate;
    protected ?\DateInterval $expires;

    #[Minimum(1)]
    #[Maximum(100)]
    protected ?float $price;

    #[Minimum(1)]
    #[Maximum(5)]
    protected ?int $rating;

    #[Description('Contains the main content of the news entry')]
    #[MinLength(3)]
    #[MaxLength(512)]
    protected ?string $content;

    #[Enum(['foo', 'bar'])]
    protected ?string $question;

    protected ?string $version = 'http://foo.bar';
    protected ?\PSX\DateTime\Time $coffeeTime;
    protected ?\PSX\Uri\Uri $profileUri;

    #[Key('g-recaptcha-response')]
    protected ?string $captcha;

    public function setConfig(?MetaAttribute $config)
    {
        $this->config = $config;
    }

    public function getConfig() : ?MetaAttribute
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

    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;
    }

    public function getProfileImage()
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

    public function setAuthor(?AuthorAttribute $author)
    {
        $this->author = $author;
    }

    public function getAuthor() : ?AuthorAttribute
    {
        return $this->author;
    }

    public function setMeta(?MetaAttribute $meta)
    {
        $this->meta = $meta;
    }

    public function getMeta() : ?MetaAttribute
    {
        return $this->meta;
    }

    public function setSendDate(?\PSX\DateTime\Date $sendDate)
    {
        $this->sendDate = $sendDate;
    }

    public function getSendDate() : ?\PSX\DateTime\Date
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

    public function setCoffeeTime(?\PSX\DateTime\Time $coffeeTime)
    {
        $this->coffeeTime = $coffeeTime;
    }

    public function getCoffeeTime() : ?\PSX\DateTime\Time
    {
        return $this->coffeeTime;
    }

    public function setProfileUri(?\PSX\Uri\Uri $profileUri)
    {
        $this->profileUri = $profileUri;
    }

    public function getProfileUri() : ?\PSX\Uri\Uri
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