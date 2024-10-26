<?php

declare(strict_types = 1);

use PSX\Schema\Attribute\Description;

#[Description('Represents a struct which contains a fixed set of defined properties')]
class StructDefinitionType extends DefinitionType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('')]
    protected ?string $type = null;
    #[Description('The parent type of this struct. The struct inherits all properties from the parent type')]
    protected ?string $parent = null;
    #[Description('Indicates that this struct is a base type, this means it is an abstract type which is used by different types as parent')]
    protected ?bool $base = null;
    /**
     * @var \PSX\Record\Record<PropertyType>|null
     */
    #[Description('')]
    protected ?\PSX\Record\Record $properties = null;
    #[Description('In case this is a base type it is possible to specify a discriminator property')]
    protected ?string $discriminator = null;
    /**
     * @var \PSX\Record\Record<string>|null
     */
    #[Description('In case a discriminator property was set it is possible to specify a mapping. The key is the type name and the value the concrete value which is mapped to the type')]
    protected ?\PSX\Record\Record $mapping = null;
    /**
     * @var \PSX\Record\Record<string>|null
     */
    #[Description('In case the parent type contains generics it is possible to set a concrete type for each generic type')]
    protected ?\PSX\Record\Record $template = null;
    public function setType(?string $type) : void
    {
        $this->type = $type;
    }
    public function getType() : ?string
    {
        return $this->type;
    }
    public function setParent(?string $parent) : void
    {
        $this->parent = $parent;
    }
    public function getParent() : ?string
    {
        return $this->parent;
    }
    public function setBase(?bool $base) : void
    {
        $this->base = $base;
    }
    public function getBase() : ?bool
    {
        return $this->base;
    }
    /**
     * @param \PSX\Record\Record<PropertyType>|null $properties
     */
    public function setProperties(?\PSX\Record\Record $properties) : void
    {
        $this->properties = $properties;
    }
    /**
     * @return \PSX\Record\Record<PropertyType>|null
     */
    public function getProperties() : ?\PSX\Record\Record
    {
        return $this->properties;
    }
    public function setDiscriminator(?string $discriminator) : void
    {
        $this->discriminator = $discriminator;
    }
    public function getDiscriminator() : ?string
    {
        return $this->discriminator;
    }
    /**
     * @param \PSX\Record\Record<string>|null $mapping
     */
    public function setMapping(?\PSX\Record\Record $mapping) : void
    {
        $this->mapping = $mapping;
    }
    /**
     * @return \PSX\Record\Record<string>|null
     */
    public function getMapping() : ?\PSX\Record\Record
    {
        return $this->mapping;
    }
    /**
     * @param \PSX\Record\Record<string>|null $template
     */
    public function setTemplate(?\PSX\Record\Record $template) : void
    {
        $this->template = $template;
    }
    /**
     * @return \PSX\Record\Record<string>|null
     */
    public function getTemplate() : ?\PSX\Record\Record
    {
        return $this->template;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('type', $this->type);
        $record->put('parent', $this->parent);
        $record->put('base', $this->base);
        $record->put('properties', $this->properties);
        $record->put('discriminator', $this->discriminator);
        $record->put('mapping', $this->mapping);
        $record->put('template', $this->template);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

