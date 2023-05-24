<?php
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Required;

#[Description('Location of the person')]
#[Required(array('lat', 'long'))]
class Location implements \JsonSerializable, \PSX\Record\RecordableInterface
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('lat', $this->lat);
        $record->put('long', $this->long);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}
