<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

#[Description('Describes arguments of the operation')]
class Argument implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('In case the data is not a JSON payload which you can describe with a schema you can select a content type')]
    protected ?string $contentType = null;
    #[Description('The location where the value can be found either in the path, query, header or body. If you choose path, then your path must have a fitting variable path fragment')]
    protected ?string $in = null;
    #[Description('Optional the actual path, query or header name. If not provided the key of the argument map is used')]
    protected ?string $name = null;
    #[Description('Schema of the JSON payload')]
    protected ?PropertyType $schema = null;
    public function setContentType(?string $contentType): void
    {
        $this->contentType = $contentType;
    }
    public function getContentType(): ?string
    {
        return $this->contentType;
    }
    public function setIn(?string $in): void
    {
        $this->in = $in;
    }
    public function getIn(): ?string
    {
        return $this->in;
    }
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setSchema(?PropertyType $schema): void
    {
        $this->schema = $schema;
    }
    public function getSchema(): ?PropertyType
    {
        return $this->schema;
    }
    /**
     * @return \PSX\Record\RecordInterface<mixed>
     */
    public function toRecord(): \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('contentType', $this->contentType);
        $record->put('in', $this->in);
        $record->put('name', $this->name);
        $record->put('schema', $this->schema);
        return $record;
    }
    public function jsonSerialize(): object
    {
        return (object) $this->toRecord()->getAll();
    }
}

