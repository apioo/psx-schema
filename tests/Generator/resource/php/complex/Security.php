<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Discriminator;

#[Description('')]
#[Discriminator('type')]
#[DerivedType('SecurityHttpBasic', 'httpBasic')]
#[DerivedType('SecurityHttpBearer', 'httpBearer')]
#[DerivedType('SecurityApiKey', 'apiKey')]
#[DerivedType('SecurityOAuth', 'oauth2')]
abstract class Security implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('The global security type of the API must be one of: httpBasic, httpBearer, apiKey or oauth2')]
    protected ?string $type = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('type', $this->type);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

