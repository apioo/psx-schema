<?php

namespace PSX\Schema\Tests\Parser\Popo\Attribute;

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Nullable;

#[Description('An simple author element with some description')]
class Author
{
    protected ?string $title = null;

    #[Description('We will send no spam to this address')]
    #[Nullable(true)]
    protected ?string $email = null;

    /**
     * @var array<string>
     */
    protected ?array $categories = null;

    /**
     * @var array<Location>
     */
    #[Description('Array of locations')]
    protected ?array $locations = null;

    protected ?Location $origin = null;

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

    public function setOrigin(?Location $origin)
    {
        $this->origin = $origin;
    }

    public function getOrigin() : ?Location
    {
        return $this->origin;
    }
}
