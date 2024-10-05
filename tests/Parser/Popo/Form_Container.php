<?php

namespace PSX\Schema\Tests\Parser\Popo;

class Form_Container
{
    /**
     * @var array<Form_Element>
     */
    private array $elements;

    public function getElements(): array
    {
        return $this->elements;
    }

    public function setElements(array $elements): void
    {
        $this->elements = $elements;
    }
}
