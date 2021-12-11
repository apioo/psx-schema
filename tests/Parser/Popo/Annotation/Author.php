<?php

namespace PSX\Schema\Tests\Parser\Popo\Annotation;

use PSX\Schema\Annotation as Schema;

/**
 * @Schema\Description("An simple author element with some description")
 * @Schema\Required({"title"})
 */
class Author
{
    /**
     * @var string
     * @Schema\Pattern("[A-z]{3,16}")
     */
    protected $title;
    /**
     * @var string
     * @Schema\Description("We will send no spam to this address")
     * @Schema\Nullable(true)
     */
    protected $email;
    /**
     * @var array<string>
     * @Schema\MaxItems(8)
     */
    protected $categories;
    /**
     * @var array<Location>
     * @Schema\Description("Array of locations")
     */
    protected $locations;
    /**
     * @var Location
     */
    protected $origin;
    /**
     * @param string $title
     */
    public function setTitle(?string $title)
    {
        $this->title = $title;
    }
    /**
     * @return string
     */
    public function getTitle() : ?string
    {
        return $this->title;
    }
    /**
     * @param string $email
     */
    public function setEmail(?string $email)
    {
        $this->email = $email;
    }
    /**
     * @return string
     */
    public function getEmail() : ?string
    {
        return $this->email;
    }
    /**
     * @param array<string> $categories
     */
    public function setCategories(?array $categories)
    {
        $this->categories = $categories;
    }
    /**
     * @return array<string>
     */
    public function getCategories() : ?array
    {
        return $this->categories;
    }
    /**
     * @param array<Location> $locations
     */
    public function setLocations(?array $locations)
    {
        $this->locations = $locations;
    }
    /**
     * @return array<Location>
     */
    public function getLocations() : ?array
    {
        return $this->locations;
    }
    /**
     * @param Location $origin
     */
    public function setOrigin(?Location $origin)
    {
        $this->origin = $origin;
    }
    /**
     * @return Location
     */
    public function getOrigin() : ?Location
    {
        return $this->origin;
    }
}
