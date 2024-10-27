<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

#[Description('TypeSchema specification')]
class TypeSchema implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    /**
     * @var \PSX\Record\Record<string>|null
     */
    #[Description('Through the import keyword it is possible to import other TypeSchema documents. It contains a map where the key is the namespace and the value points to a remote document. The value is a URL and a code generator should support at least the following schemes: file, http, https.')]
    protected ?\PSX\Record\Record $import = null;
    /**
     * @var \PSX\Record\Record<DefinitionType>|null
     */
    protected ?\PSX\Record\Record $definitions = null;
    #[Description('Specifies the root type of your specification.')]
    protected ?string $root = null;
    /**
     * @param \PSX\Record\Record<string>|null $import
     */
    public function setImport(?\PSX\Record\Record $import) : void
    {
        $this->import = $import;
    }
    /**
     * @return \PSX\Record\Record<string>|null
     */
    public function getImport() : ?\PSX\Record\Record
    {
        return $this->import;
    }
    /**
     * @param \PSX\Record\Record<DefinitionType>|null $definitions
     */
    public function setDefinitions(?\PSX\Record\Record $definitions) : void
    {
        $this->definitions = $definitions;
    }
    /**
     * @return \PSX\Record\Record<DefinitionType>|null
     */
    public function getDefinitions() : ?\PSX\Record\Record
    {
        return $this->definitions;
    }
    public function setRoot(?string $root) : void
    {
        $this->root = $root;
    }
    public function getRoot() : ?string
    {
        return $this->root;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('import', $this->import);
        $record->put('definitions', $this->definitions);
        $record->put('root', $this->root);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

