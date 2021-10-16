<?php

namespace PSX\Schema\Tests\Parser\Popo;

/**
 * @Schema\Required({"element"})
 */
class Form_Element
{
    /**
     * @var string
     */
    private $element;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $help;

    /**
     * @var Form_Element_Input
     */
    private $parent;

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
