<?php

namespace PSX\Schema\Tests\Parser\Popo;

class Form_Element_Input extends Form_Element
{
    private ?string $type;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }
}
