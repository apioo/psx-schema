<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

#[Description('')]
class Operation implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('The HTTP method which is associated with this operation, must be a valid HTTP method i.e. GET, POST, PUT etc.')]
    protected ?string $method = null;
    #[Description('The HTTP path which is associated with this operation. A path can also include variable path fragments i.e. /my/path/:year then you can map the variable year path fragment to a specific argument')]
    protected ?string $path = null;
    #[Description('The return type of this operation. The return has also an assigned HTTP success status code which is by default 200')]
    protected ?Response $return = null;
    /**
     * @var \PSX\Record\Record<Argument>|null
     */
    #[Description('All arguments provided to this operation. Each argument is mapped to a location from the HTTP request i.e. query or body')]
    protected ?\PSX\Record\Record $arguments = null;
    /**
     * @var array<Response>|null
     */
    #[Description('All exceptional states which can occur in case the operation fails. Each exception is assigned to an HTTP error status code')]
    protected ?array $throws = null;
    #[Description('A short description of this operation. The generated code will include this description at the method so it is recommend to use simple alphanumeric characters and no new lines')]
    protected ?string $description = null;
    #[Description('Indicates the stability of this operation: 0 - Deprecated, 1 - Experimental, 2 - Stable, 3 - Legacy. If not explicit provided the operation is by default experimental.')]
    protected ?int $stability = null;
    /**
     * @var array<string>|null
     */
    #[Description('An array of scopes which are required to access this operation')]
    protected ?array $security = null;
    #[Description('Indicates whether this operation needs authorization, if set to false the client will not send an authorization header, default it is true')]
    protected ?bool $authorization = null;
    /**
     * @var array<string>|null
     */
    #[Description('Optional an array of tags to group operations')]
    protected ?array $tags = null;
    public function setMethod(?string $method) : void
    {
        $this->method = $method;
    }
    public function getMethod() : ?string
    {
        return $this->method;
    }
    public function setPath(?string $path) : void
    {
        $this->path = $path;
    }
    public function getPath() : ?string
    {
        return $this->path;
    }
    public function setReturn(?Response $return) : void
    {
        $this->return = $return;
    }
    public function getReturn() : ?Response
    {
        return $this->return;
    }
    /**
     * @param \PSX\Record\Record<Argument>|null $arguments
     */
    public function setArguments(?\PSX\Record\Record $arguments) : void
    {
        $this->arguments = $arguments;
    }
    /**
     * @return \PSX\Record\Record<Argument>|null
     */
    public function getArguments() : ?\PSX\Record\Record
    {
        return $this->arguments;
    }
    /**
     * @param array<Response>|null $throws
     */
    public function setThrows(?array $throws) : void
    {
        $this->throws = $throws;
    }
    /**
     * @return array<Response>|null
     */
    public function getThrows() : ?array
    {
        return $this->throws;
    }
    public function setDescription(?string $description) : void
    {
        $this->description = $description;
    }
    public function getDescription() : ?string
    {
        return $this->description;
    }
    public function setStability(?int $stability) : void
    {
        $this->stability = $stability;
    }
    public function getStability() : ?int
    {
        return $this->stability;
    }
    /**
     * @param array<string>|null $security
     */
    public function setSecurity(?array $security) : void
    {
        $this->security = $security;
    }
    /**
     * @return array<string>|null
     */
    public function getSecurity() : ?array
    {
        return $this->security;
    }
    public function setAuthorization(?bool $authorization) : void
    {
        $this->authorization = $authorization;
    }
    public function getAuthorization() : ?bool
    {
        return $this->authorization;
    }
    /**
     * @param array<string>|null $tags
     */
    public function setTags(?array $tags) : void
    {
        $this->tags = $tags;
    }
    /**
     * @return array<string>|null
     */
    public function getTags() : ?array
    {
        return $this->tags;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('method', $this->method);
        $record->put('path', $this->path);
        $record->put('return', $this->return);
        $record->put('arguments', $this->arguments);
        $record->put('throws', $this->throws);
        $record->put('description', $this->description);
        $record->put('stability', $this->stability);
        $record->put('security', $this->security);
        $record->put('authorization', $this->authorization);
        $record->put('tags', $this->tags);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

