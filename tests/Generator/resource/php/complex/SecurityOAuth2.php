<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

class SecurityOAuth extends Security implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('The OAuth2 token endpoint')]
    protected ?string $tokenUrl = null;
    #[Description('Optional the OAuth2 authorization endpoint')]
    protected ?string $authorizationUrl = null;
    /**
     * @var array<string>|null
     */
    #[Description('Optional OAuth2 scopes')]
    protected ?array $scopes = null;
    public function setTokenUrl(?string $tokenUrl) : void
    {
        $this->tokenUrl = $tokenUrl;
    }
    public function getTokenUrl() : ?string
    {
        return $this->tokenUrl;
    }
    public function setAuthorizationUrl(?string $authorizationUrl) : void
    {
        $this->authorizationUrl = $authorizationUrl;
    }
    public function getAuthorizationUrl() : ?string
    {
        return $this->authorizationUrl;
    }
    /**
     * @param array<string>|null $scopes
     */
    public function setScopes(?array $scopes) : void
    {
        $this->scopes = $scopes;
    }
    /**
     * @return array<string>|null
     */
    public function getScopes() : ?array
    {
        return $this->scopes;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('tokenUrl', $this->tokenUrl);
        $record->put('authorizationUrl', $this->authorizationUrl);
        $record->put('scopes', $this->scopes);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

