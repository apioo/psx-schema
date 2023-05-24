<?php
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
class News implements \JsonSerializable, \PSX\Record\RecordableInterface
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
    protected ?\PSX\DateTime\LocalDate $sendDate = null;
    protected ?\PSX\DateTime\LocalDateTime $readDate = null;
    protected ?\PSX\DateTime\Period $expires = null;
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
    protected ?\PSX\DateTime\LocalTime $coffeeTime = null;
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
    public function setSendDate(?\PSX\DateTime\LocalDate $sendDate) : void
    {
        $this->sendDate = $sendDate;
    }
    public function getSendDate() : ?\PSX\DateTime\LocalDate
    {
        return $this->sendDate;
    }
    public function setReadDate(?\PSX\DateTime\LocalDateTime $readDate) : void
    {
        $this->readDate = $readDate;
    }
    public function getReadDate() : ?\PSX\DateTime\LocalDateTime
    {
        return $this->readDate;
    }
    public function setExpires(?\PSX\DateTime\Period $expires) : void
    {
        $this->expires = $expires;
    }
    public function getExpires() : ?\PSX\DateTime\Period
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
    public function setCoffeeTime(?\PSX\DateTime\LocalTime $coffeeTime) : void
    {
        $this->coffeeTime = $coffeeTime;
    }
    public function getCoffeeTime() : ?\PSX\DateTime\LocalTime
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('config', $this->config);
        $record->put('inlineConfig', $this->inlineConfig);
        $record->put('tags', $this->tags);
        $record->put('receiver', $this->receiver);
        $record->put('resources', $this->resources);
        $record->put('profileImage', $this->profileImage);
        $record->put('read', $this->read);
        $record->put('source', $this->source);
        $record->put('author', $this->author);
        $record->put('meta', $this->meta);
        $record->put('sendDate', $this->sendDate);
        $record->put('readDate', $this->readDate);
        $record->put('expires', $this->expires);
        $record->put('price', $this->price);
        $record->put('rating', $this->rating);
        $record->put('content', $this->content);
        $record->put('question', $this->question);
        $record->put('version', $this->version);
        $record->put('coffeeTime', $this->coffeeTime);
        $record->put('profileUri', $this->profileUri);
        $record->put('g-recaptcha-response', $this->captcha);
        $record->put('payload', $this->payload);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}
