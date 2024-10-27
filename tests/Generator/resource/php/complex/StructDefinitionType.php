<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

#[Description('A struct represents a class/structure with a fix set of defined properties.')]
class StructDefinitionType extends DefinitionType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('Defines a parent type for this structure. Some programming languages like Go do not support the concept of an extends, in this case the code generator simply copies all properties into this structure.')]
    protected ?ReferencePropertyType $parent = null;
    #[Description('Indicates whether this is a base structure, default is false. If true the structure is used a base type, this means it is not possible to create an instance from this structure.')]
    protected ?bool $base = null;
    /**
     * @var \PSX\Record\Record<PropertyType>|null
     */
    #[Description('Contains a map of available properties for this struct.')]
    protected ?\PSX\Record\Record $properties = null;
    #[Description('Optional the property name of a discriminator property. This should be only used in case this is also a base structure.')]
    protected ?string $discriminator = null;
    /**
     * @var \PSX\Record\Record<string>|null
     */
    #[Description('In case a discriminator is configured it is required to configure a mapping. The mapping is a map where the key is the type name and the value the actual discriminator type value.')]
    protected ?\PSX\Record\Record $mapping = null;
    public function setParent(?ReferencePropertyType $parent) : void
    {
        $this->parent = $parent;
    }
    public function getParent() : ?ReferencePropertyType
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
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = parent::toRecord();
        $record->put('parent', $this->parent);
        $record->put('base', $this->base);
        $record->put('properties', $this->properties);
        $record->put('discriminator', $this->discriminator);
        $record->put('mapping', $this->mapping);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

