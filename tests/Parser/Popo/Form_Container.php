<?php

namespace PSX\Schema\Tests\Parser\Popo;

class Form_Container
{
    /**
     * @var array<Form_Element>
     */
    private array $elements;

    /**
     * @return array<Form_Element>
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * @param array<Form_Element> $elements
     */
    public function setElements(array $elements): void
    {
        $this->elements = $elements;
    }
}
