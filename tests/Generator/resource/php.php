use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Required;

#[Description('Location of the person')]
#[Required(array('lat', 'long'))]
class Location implements \JsonSerializable
{
    protected ?float $lat = null;
    protected ?float $long = null;
    public function setLat(?float $lat) : void
    {
        $this->lat = $lat;
    }
    public function getLat() : ?float
    {
        return $this->lat;
    }
    public function setLong(?float $long) : void
    {
        $this->long = $long;
    }
    public function getLong() : ?float
    {
        return $this->long;
    }
    public function jsonSerialize() : object
    {
        return (object) array_filter(array('lat' => $this->lat, 'long' => $this->long), static function ($value) : bool {
            return $value !== null;
        });
    }
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Required;

#[Description('An application')]
#[Required(array('name', 'url'))]
class Web implements \JsonSerializable
{
    protected ?string $name = null;
    protected ?string $url = null;
    public function setName(?string $name) : void
    {
        $this->name = $name;
    }
    public function getName() : ?string
    {
        return $this->name;
    }
    public function setUrl(?string $url) : void
    {
        $this->url = $url;
    }
    public function getUrl() : ?string
    {
        return $this->url;
    }
    public function jsonSerialize() : object
    {
        return (object) array_filter(array('name' => $this->name, 'url' => $this->url), static function ($value) : bool {
            return $value !== null;
        });
    }
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\MaxItems;
use PSX\Schema\Attribute\Nullable;
use PSX\Schema\Attribute\Pattern;
use PSX\Schema\Attribute\Required;

#[Description('An simple author element with some description')]
#[Required(array('title'))]
class Author implements \JsonSerializable
{
    #[Pattern('[A-z]{3,16}')]
    protected ?string $title = null;
    #[Description('We will send no spam to this address')]
    #[Nullable(true)]
    protected ?string $email = null;
    /**
     * @var array<string>|null
     */
    #[MaxItems(8)]
    protected ?array $categories = null;
    /**
     * @var array<Location>|null
     */
    #[Description('Array of locations')]
    protected ?array $locations = null;
    protected ?Location $origin = null;
    public function setTitle(?string $title) : void
    {
        $this->title = $title;
    }
    public function getTitle() : ?string
    {
        return $this->title;
    }
    public function setEmail(?string $email) : void
    {
        $this->email = $email;
    }
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
    public function getLocations() : ?array
    {
        return $this->locations;
    }
    public function setOrigin(?Location $origin) : void
    {
        $this->origin = $origin;
    }
    public function getOrigin() : ?Location
    {
        return $this->origin;
    }
    public function jsonSerialize() : object
    {
        return (object) array_filter(array('title' => $this->title, 'email' => $this->email, 'categories' => $this->categories, 'locations' => $this->locations, 'origin' => $this->origin), static function ($value) : bool {
            return $value !== null;
        });
    }
}

use PSX\Schema\Attribute\MaxProperties;
use PSX\Schema\Attribute\MinProperties;
/**
 * @extends \PSX\Record\Record<string>
 */
#[MinProperties(1)]
#[MaxProperties(6)]
class Meta extends \PSX\Record\Record
{
}

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Key;
use PSX\Schema\Attribute\MaxItems;
use PSX\Schema\Attribute\MaxLength;
use PSX\Schema\Attribute\Maximum;
use PSX\Schema\Attribute\MinItems;
use PSX\Schema\Attribute\MinLength;
use PSX\Schema\Attribute\Minimum;
use PSX\Schema\Attribute\Required;

#[Description('An general news entry')]
#[Required(array('receiver', 'price', 'content'))]
class News implements \JsonSerializable
{
    protected ?Meta $config = null;
    /**
     * @var \PSX\Record\Record<string>|null
     */
    protected ?\PSX\Record\Record $inlineConfig = null;
    /**
     * @var array<string>|null
     */
    #[MinItems(1)]
    #[MaxItems(6)]
    protected ?array $tags = null;
    /**
     * @var array<Author>|null
     */
    #[MinItems(1)]
    protected ?array $receiver = null;
    /**
     * @var array<Location|Web>|null
     */
    protected ?array $resources = null;
    /**
     * @var resource|null
     */
    protected $profileImage = null;
    protected ?bool $read = null;
    protected Author|Web|null $source = null;
    protected ?Author $author = null;
    protected ?Meta $meta = null;
    protected ?\PSX\DateTime\Date $sendDate = null;
    protected ?\DateTime $readDate = null;
    protected ?\DateInterval $expires = null;
    #[Minimum(1)]
    #[Maximum(100)]
    protected ?float $price = null;
    #[Minimum(1)]
    #[Maximum(5)]
    protected ?int $rating = null;
    #[Description('Contains the main content of the news entry')]
    #[MinLength(3)]
    #[MaxLength(512)]
    protected ?string $content = null;
    #[Enum(array('foo', 'bar'))]
    protected ?string $question = null;
    protected ?string $version = 'http://foo.bar';
    protected ?\PSX\DateTime\Time $coffeeTime = null;
    protected ?\PSX\Uri\Uri $profileUri = null;
    #[Key('g-recaptcha-response')]
    protected ?string $captcha = null;
    protected mixed $payload = null;
    public function setConfig(?Meta $config) : void
    {
        $this->config = $config;
    }
    public function getConfig() : ?Meta
    {
        return $this->config;
    }
    public function setInlineConfig(?\PSX\Record\Record $inlineConfig) : void
    {
        $this->inlineConfig = $inlineConfig;
    }
    public function getInlineConfig() : ?\PSX\Record\Record
    {
        return $this->inlineConfig;
    }
    /**
     * @param array<string>|null $tags
     */
    public function setTags(?array $tags) : void
    {
        $this->tags = $tags;
    }
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
    public function getResources() : ?array
    {
        return $this->resources;
    }
    public function setProfileImage($profileImage) : void
    {
        $this->profileImage = $profileImage;
    }
    public function getProfileImage()
    {
        return $this->profileImage;
    }
    public function setRead(?bool $read) : void
    {
        $this->read = $read;
    }
    public function getRead() : ?bool
    {
        return $this->read;
    }
    public function setSource(Author|Web|null $source) : void
    {
        $this->source = $source;
    }
    public function getSource() : Author|Web|null
    {
        return $this->source;
    }
    public function setAuthor(?Author $author) : void
    {
        $this->author = $author;
    }
    public function getAuthor() : ?Author
    {
        return $this->author;
    }
    public function setMeta(?Meta $meta) : void
    {
        $this->meta = $meta;
    }
    public function getMeta() : ?Meta
    {
        return $this->meta;
    }
    public function setSendDate(?\PSX\DateTime\Date $sendDate) : void
    {
        $this->sendDate = $sendDate;
    }
    public function getSendDate() : ?\PSX\DateTime\Date
    {
        return $this->sendDate;
    }
    public function setReadDate(?\DateTime $readDate) : void
    {
        $this->readDate = $readDate;
    }
    public function getReadDate() : ?\DateTime
    {
        return $this->readDate;
    }
    public function setExpires(?\DateInterval $expires) : void
    {
        $this->expires = $expires;
    }
    public function getExpires() : ?\DateInterval
    {
        return $this->expires;
    }
    public function setPrice(?float $price) : void
    {
        $this->price = $price;
    }
    public function getPrice() : ?float
    {
        return $this->price;
    }
    public function setRating(?int $rating) : void
    {
        $this->rating = $rating;
    }
    public function getRating() : ?int
    {
        return $this->rating;
    }
    public function setContent(?string $content) : void
    {
        $this->content = $content;
    }
    public function getContent() : ?string
    {
        return $this->content;
    }
    public function setQuestion(?string $question) : void
    {
        $this->question = $question;
    }
    public function getQuestion() : ?string
    {
        return $this->question;
    }
    public function setVersion(?string $version) : void
    {
        $this->version = $version;
    }
    public function getVersion() : ?string
    {
        return $this->version;
    }
    public function setCoffeeTime(?\PSX\DateTime\Time $coffeeTime) : void
    {
        $this->coffeeTime = $coffeeTime;
    }
    public function getCoffeeTime() : ?\PSX\DateTime\Time
    {
        return $this->coffeeTime;
    }
    public function setProfileUri(?\PSX\Uri\Uri $profileUri) : void
    {
        $this->profileUri = $profileUri;
    }
    public function getProfileUri() : ?\PSX\Uri\Uri
    {
        return $this->profileUri;
    }
    public function setCaptcha(?string $captcha) : void
    {
        $this->captcha = $captcha;
    }
    public function getCaptcha() : ?string
    {
        return $this->captcha;
    }
    public function setPayload(mixed $payload) : void
    {
        $this->payload = $payload;
    }
    public function getPayload() : mixed
    {
        return $this->payload;
    }
    public function jsonSerialize() : object
    {
        return (object) array_filter(array('config' => $this->config, 'inlineConfig' => $this->inlineConfig, 'tags' => $this->tags, 'receiver' => $this->receiver, 'resources' => $this->resources, 'profileImage' => $this->profileImage, 'read' => $this->read, 'source' => $this->source, 'author' => $this->author, 'meta' => $this->meta, 'sendDate' => $this->sendDate, 'readDate' => $this->readDate, 'expires' => $this->expires, 'price' => $this->price, 'rating' => $this->rating, 'content' => $this->content, 'question' => $this->question, 'version' => $this->version, 'coffeeTime' => $this->coffeeTime, 'profileUri' => $this->profileUri, 'g-recaptcha-response' => $this->captcha, 'payload' => $this->payload), static function ($value) : bool {
            return $value !== null;
        });
    }
}
