<?php
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\MaxItems;
use PSX\Schema\Attribute\Nullable;
use PSX\Schema\Attribute\Pattern;
use PSX\Schema\Attribute\Required;

#[Description('An simple author element with some description')]
#[Required(array('title'))]
class Author implements \JsonSerializable, \PSX\Record\RecordableInterface
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('title', $this->title);
        $record->put('email', $this->email);
        $record->put('categories', $this->categories);
        $record->put('locations', $this->locations);
        $record->put('origin', $this->origin);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}
