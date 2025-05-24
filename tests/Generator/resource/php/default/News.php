<?php

declare(strict_types = 1);

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Key;
use PSX\Schema\Attribute\Nullable;

#[Description('An general news entry')]
class News implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?Meta $config = null;
    /**
     * @var \PSX\Record\Record<string>|null
     */
    protected ?\PSX\Record\Record $inlineConfig = null;
    /**
     * @var \PSX\Record\Record<string>|null
     */
    protected ?\PSX\Record\Record $mapTags = null;
    /**
     * @var \PSX\Record\Record<Author>|null
     */
    protected ?\PSX\Record\Record $mapReceiver = null;
    /**
     * @var array<string>|null
     */
    protected ?array $tags = null;
    /**
     * @var array<Author>|null
     */
    protected ?array $receiver = null;
    /**
     * @var array<array<float>>|null
     */
    protected ?array $data = null;
    protected ?bool $read = null;
    #[Nullable(false)]
    protected Author $author;
    protected ?Meta $meta = null;
    protected ?\PSX\DateTime\LocalDate $sendDate = null;
    protected ?\PSX\DateTime\LocalDateTime $readDate = null;
    protected ?float $price = null;
    protected ?int $rating = null;
    #[Description('Contains the "main" content of the news entry')]
    #[Nullable(false)]
    protected string $content;
    protected ?string $question = null;
    protected ?string $version = null;
    protected ?\PSX\DateTime\LocalTime $coffeeTime = null;
    #[Key('g-recaptcha-response')]
    protected ?string $captcha = null;
    #[Key('media.fields')]
    protected ?string $mediaFields = null;
    protected mixed $payload = null;
    public function setConfig(?Meta $config): void
    {
        $this->config = $config;
    }
    public function getConfig(): ?Meta
    {
        return $this->config;
    }
    /**
     * @param \PSX\Record\Record<string>|null $inlineConfig
     */
    public function setInlineConfig(?\PSX\Record\Record $inlineConfig): void
    {
        $this->inlineConfig = $inlineConfig;
    }
    /**
     * @return \PSX\Record\Record<string>|null
     */
    public function getInlineConfig(): ?\PSX\Record\Record
    {
        return $this->inlineConfig;
    }
    /**
     * @param \PSX\Record\Record<string>|null $mapTags
     */
    public function setMapTags(?\PSX\Record\Record $mapTags): void
    {
        $this->mapTags = $mapTags;
    }
    /**
     * @return \PSX\Record\Record<string>|null
     */
    public function getMapTags(): ?\PSX\Record\Record
    {
        return $this->mapTags;
    }
    /**
     * @param \PSX\Record\Record<Author>|null $mapReceiver
     */
    public function setMapReceiver(?\PSX\Record\Record $mapReceiver): void
    {
        $this->mapReceiver = $mapReceiver;
    }
    /**
     * @return \PSX\Record\Record<Author>|null
     */
    public function getMapReceiver(): ?\PSX\Record\Record
    {
        return $this->mapReceiver;
    }
    /**
     * @param array<string>|null $tags
     */
    public function setTags(?array $tags): void
    {
        $this->tags = $tags;
    }
    /**
     * @return array<string>|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }
    /**
     * @param array<Author>|null $receiver
     */
    public function setReceiver(?array $receiver): void
    {
        $this->receiver = $receiver;
    }
    /**
     * @return array<Author>|null
     */
    public function getReceiver(): ?array
    {
        return $this->receiver;
    }
    /**
     * @param array<array<float>>|null $data
     */
    public function setData(?array $data): void
    {
        $this->data = $data;
    }
    /**
     * @return array<array<float>>|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }
    public function setRead(?bool $read): void
    {
        $this->read = $read;
    }
    public function getRead(): ?bool
    {
        return $this->read;
    }
    public function setAuthor(Author $author): void
    {
        $this->author = $author;
    }
    public function getAuthor(): Author
    {
        return $this->author;
    }
    public function setMeta(?Meta $meta): void
    {
        $this->meta = $meta;
    }
    public function getMeta(): ?Meta
    {
        return $this->meta;
    }
    public function setSendDate(?\PSX\DateTime\LocalDate $sendDate): void
    {
        $this->sendDate = $sendDate;
    }
    public function getSendDate(): ?\PSX\DateTime\LocalDate
    {
        return $this->sendDate;
    }
    public function setReadDate(?\PSX\DateTime\LocalDateTime $readDate): void
    {
        $this->readDate = $readDate;
    }
    public function getReadDate(): ?\PSX\DateTime\LocalDateTime
    {
        return $this->readDate;
    }
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }
    public function getPrice(): ?float
    {
        return $this->price;
    }
    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }
    public function getRating(): ?int
    {
        return $this->rating;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    public function getContent(): string
    {
        return $this->content;
    }
    public function setQuestion(?string $question): void
    {
        $this->question = $question;
    }
    public function getQuestion(): ?string
    {
        return $this->question;
    }
    public function setVersion(?string $version): void
    {
        $this->version = $version;
    }
    public function getVersion(): ?string
    {
        return $this->version;
    }
    public function setCoffeeTime(?\PSX\DateTime\LocalTime $coffeeTime): void
    {
        $this->coffeeTime = $coffeeTime;
    }
    public function getCoffeeTime(): ?\PSX\DateTime\LocalTime
    {
        return $this->coffeeTime;
    }
    public function setCaptcha(?string $captcha): void
    {
        $this->captcha = $captcha;
    }
    public function getCaptcha(): ?string
    {
        return $this->captcha;
    }
    public function setMediaFields(?string $mediaFields): void
    {
        $this->mediaFields = $mediaFields;
    }
    public function getMediaFields(): ?string
    {
        return $this->mediaFields;
    }
    public function setPayload(mixed $payload): void
    {
        $this->payload = $payload;
    }
    public function getPayload(): mixed
    {
        return $this->payload;
    }
    public function toRecord(): \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('config', $this->config);
        $record->put('inlineConfig', $this->inlineConfig);
        $record->put('mapTags', $this->mapTags);
        $record->put('mapReceiver', $this->mapReceiver);
        $record->put('tags', $this->tags);
        $record->put('receiver', $this->receiver);
        $record->put('data', $this->data);
        $record->put('read', $this->read);
        $record->put('author', $this->author);
        $record->put('meta', $this->meta);
        $record->put('sendDate', $this->sendDate);
        $record->put('readDate', $this->readDate);
        $record->put('price', $this->price);
        $record->put('rating', $this->rating);
        $record->put('content', $this->content);
        $record->put('question', $this->question);
        $record->put('version', $this->version);
        $record->put('coffeeTime', $this->coffeeTime);
        $record->put('g-recaptcha-response', $this->captcha);
        $record->put('media.fields', $this->mediaFields);
        $record->put('payload', $this->payload);
        return $record;
    }
    public function jsonSerialize(): object
    {
        return (object) $this->toRecord()->getAll();
    }
}

