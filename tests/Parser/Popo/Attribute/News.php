<?php

namespace PSX\Schema\Tests\Parser\Popo\Attribute;

use PSX\Record\Record;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Enum;
use PSX\Schema\Attribute\Key;
use PSX\Schema\Attribute\Maximum;
use PSX\Schema\Attribute\MaxItems;
use PSX\Schema\Attribute\MaxLength;
use PSX\Schema\Attribute\Minimum;
use PSX\Schema\Attribute\MinItems;
use PSX\Schema\Attribute\MinLength;
use PSX\Schema\Attribute\Required;

#[Description('An general news entry')]
#[Required(['receiver', 'price', 'content'])]
class News
{
    protected ?Meta $config = null;

    /**
     * @var Record<string>|null
     */
    protected ?Record $inlineConfig = null;

    /**
     * @var Record<string>
     */
    protected ?array $mapTags = null;

    /**
     * @var Record<Author>
     */
    protected ?Record $mapReceiver = null;

    /**
     * @var Record<Location|Web>
     */
    protected ?Record $mapResources = null;

    /**
     * @var array<string>
     */
    #[MinItems(1)]
    #[MaxItems(6)]
    protected ?array $tags = null;

    /**
     * @var array<Author>
     */
    #[MinItems(1)]
    protected ?array $receiver = null;

    /**
     * @var array<Location|Web>
     */
    protected ?array $resources = null;

    /**
     * @var resource
     */
    protected $profileImage;

    protected ?bool $read;
    protected Author|Web $source;
    protected ?Author $author;
    protected ?Meta $meta;
    protected ?\PSX\DateTime\LocalDate $sendDate;
    protected ?\PSX\DateTime\LocalDateTime $readDate;
    protected ?\PSX\DateTime\Period $expires;
    protected ?\PSX\DateTime\Duration $range;

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

    #[Enum(['foo', 'bar'])]
    protected ?string $question = null;

    protected ?string $version = 'http://foo.bar';
    protected ?\PSX\DateTime\LocalTime $coffeeTime = null;
    protected ?\PSX\Uri\Uri $profileUri = null;

    #[Key('g-recaptcha-response')]
    protected ?string $captcha = null;
    #[Key('media.fields')]
    protected ?string $mediaFields = null;
    protected mixed $payload = null;

    public function setConfig(?Meta $config)
    {
        $this->config = $config;
    }

    public function getConfig() : ?Meta
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

    public function setSendDate(?\PSX\DateTime\LocalDate $sendDate)
    {
        $this->sendDate = $sendDate;
    }

    public function getSendDate() : ?\PSX\DateTime\LocalDate
    {
        return $this->sendDate;
    }

    public function setReadDate(?\PSX\DateTime\LocalDateTime $readDate)
    {
        $this->readDate = $readDate;
    }

    public function getReadDate() : ?\PSX\DateTime\LocalDateTime
    {
        return $this->readDate;
    }

    public function setExpires(?\PSX\DateTime\Period $expires)
    {
        $this->expires = $expires;
    }

    public function getExpires() : ?\PSX\DateTime\Period
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

    public function setCoffeeTime(?\PSX\DateTime\LocalTime $coffeeTime)
    {
        $this->coffeeTime = $coffeeTime;
    }

    public function getCoffeeTime() : ?\PSX\DateTime\LocalTime
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

    public function setMediaFields(?string $mediaFields)
    {
        $this->mediaFields = $mediaFields;
    }

    public function getMediaFields() : ?string
    {
        return $this->mediaFields;
    }

    public function getPayload(): mixed
    {
        return $this->payload;
    }

    public function setPayload(mixed $payload): void
    {
        $this->payload = $payload;
    }
}
