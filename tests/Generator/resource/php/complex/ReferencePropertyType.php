<?php

declare(strict_types = 1);

namespace TypeAPI\Model;

use PSX\Schema\Attribute\Description;

#[Description('Represents a reference to a definition type')]
class ReferencePropertyType extends PropertyType implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    #[Description('The target type, this must be a key which is available under the definitions keyword.')]
    protected ?string $target = null;
    /**
     * @var \PSX\Record\Record<string>|null
     */
    #[Description('A map where the key is the name of the generic and the value must point to a key under the definitions keyword. This can be used in case the target points to a type which contains generics, then it is possible to replace those generics with a concrete type.')]
    protected ?\PSX\Record\Record $template = null;
    public function setTarget(?string $target) : void
    {
        $this->target = $target;
    }
    public function getTarget() : ?string
    {
        return $this->target;
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
        $record->put('target', $this->target);
        $record->put('template', $this->template);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}

