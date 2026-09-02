<?php

namespace PSX\Schema\Tests\Parser\Popo\Attribute;

use PSX\Schema\Attribute\Description;

#[Description('Location of the person')]
class Location
{
    protected ?float $lat = null;
    protected ?float $long = null;

    public function setLat(?float $lat): void
    {
        $this->lat = $lat;
    }

    public function getLat() : ?float
    {
        return $this->lat;
    }

    public function setLong(?float $long): void
    {
        $this->long = $long;
    }

    public function getLong() : ?float
    {
        return $this->long;
    }
}

