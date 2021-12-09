<?php

namespace PSX\Schema\Tests\Parser\Popo\Annotation;

use PSX\Schema\Annotation as Schema;

/**
 * @Schema\Description("Location of the person")
 * @Schema\Required({"lat", "long"})
 */
class Location
{
    /**
     * @var float
     */
    protected $lat;
    /**
     * @var float
     */
    protected $long;
    /**
     * @param float $lat
     */
    public function setLat(?float $lat)
    {
        $this->lat = $lat;
    }
    /**
     * @return float
     */
    public function getLat() : ?float
    {
        return $this->lat;
    }
    /**
     * @param float $long
     */
    public function setLong(?float $long)
    {
        $this->long = $long;
    }
    /**
     * @return float
     */
    public function getLong() : ?float
    {
        return $this->long;
    }
}
