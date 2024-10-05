<?php

namespace PSX\Schema\Tests\Parser\Popo;

use PSX\Schema\Attribute\DerivedType;
use PSX\Schema\Attribute\Discriminator;

#[Discriminator('element')]
#[DerivedType(Form_Element_Input::class, 'http://fusio-project.org/ns/2015/form/input')]
#[DerivedType(Form_Element_Select::class, 'http://fusio-project.org/ns/2015/form/select')]
#[DerivedType(Form_Element_Tag::class, 'http://fusio-project.org/ns/2015/form/tag')]
#[DerivedType(Form_Element_TextArea::class, 'http://fusio-project.org/ns/2015/form/textarea')]
abstract class Form_Element
{
    private ?string $element;
    private ?string $name;
    private ?string $title;
    private ?string $help;
    private ?Form_Element_Input $parent;

    public function getElement(): ?string
    {
        return $this->element;
    }

    public function setElement(?string $element): void
    {
        $this->element = $element;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getHelp(): ?string
    {
        return $this->help;
    }

    public function setHelp(?string $help): void
    {
        $this->help = $help;
    }

    public function getParent(): ?Form_Element_Input
    {
        return $this->parent;
    }

    public function setParent(?Form_Element_Input $parent): void
    {
        $this->parent = $parent;
    }
}
