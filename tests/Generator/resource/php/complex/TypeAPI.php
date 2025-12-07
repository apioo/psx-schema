<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

#[Description('The TypeAPI Root')]
class TypeAPI extends TypeSchema implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('Optional the base url of the service, if provided the user does not need to provide a base url for your client')]
    protected ?string $baseUrl = null;
    /**
     * @var \PSX\Record\Record<Operation>|null
     */
    #[Description('A map of operations which are provided by the API. The key of the operation should be separated by a dot to group operations into logical units i.e. product.getAll or enterprise.product.execute')]
    protected ?\PSX\Record\Record $operations = null;
    #[Description('Describes the authorization mechanism which is used by your API')]
    protected ?Security $security = null;
    public function setBaseUrl(?string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }
    public function getBaseUrl(): ?string
    {
        return $this->baseUrl;
    }
    /**
     * @param \PSX\Record\Record<Operation>|null $operations
     */
    public function setOperations(?\PSX\Record\Record $operations): void
    {
        $this->operations = $operations;
    }
    /**
     * @return \PSX\Record\Record<Operation>|null
     */
    public function getOperations(): ?\PSX\Record\Record
    {
        return $this->operations;
    }
    public function setSecurity(?Security $security): void
    {
        $this->security = $security;
    }
    public function getSecurity(): ?Security
    {
        return $this->security;
    }
    /**
     * @return \PSX\Record\RecordInterface<mixed>
     */
    public function toRecord(): \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('baseUrl', $this->baseUrl);
        $record->put('operations', $this->operations);
        $record->put('security', $this->security);
        return $record;
    }
    public function jsonSerialize(): object
    {
        return (object) $this->toRecord()->getAll();
    }
}

