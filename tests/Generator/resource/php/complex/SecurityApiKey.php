<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

class SecurityApiKey extends Security implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('The name of the header or query parameter i.e. "X-Api-Key"')]
    protected ?string $name = null;
    #[Description('Must be either "header" or "query"')]
    protected ?string $in = null;
    public function setName(?string $name) : void
    {
        $this->name = $name;
    }
    public function getName() : ?string
    {
        return $this->name;
    }
    public function setIn(?string $in) : void
    {
        $this->in = $in;
    }
    public function getIn() : ?string
    {
        return $this->in;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('name', $this->name);
        $record->put('in', $this->in);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

