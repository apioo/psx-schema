<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

#[Description('')]
class Argument implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('The location where the value can be found either in the path, query, header or body. If you choose path, then your path must have a fitting variable path fragment')]
    protected ?string $in = null;
    #[Description('')]
    protected ?PropertyType $schema = null;
    #[Description('In case the data is not a JSON payload which you can describe with a schema you can select a content type')]
    protected ?string $contentType = null;
    #[Description('Optional the actual path, query or header name. If not provided the key of the argument map is used')]
    protected ?string $name = null;
    public function setIn(?string $in) : void
    {
        $this->in = $in;
    }
    public function getIn() : ?string
    {
        return $this->in;
    }
    public function setSchema(?PropertyType $schema) : void
    {
        $this->schema = $schema;
    }
    public function getSchema() : ?PropertyType
    {
        return $this->schema;
    }
    public function setContentType(?string $contentType) : void
    {
        $this->contentType = $contentType;
    }
    public function getContentType() : ?string
    {
        return $this->contentType;
    }
    public function setName(?string $name) : void
    {
        $this->name = $name;
    }
    public function getName() : ?string
    {
        return $this->name;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('in', $this->in);
        $record->put('schema', $this->schema);
        $record->put('contentType', $this->contentType);
        $record->put('name', $this->name);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

