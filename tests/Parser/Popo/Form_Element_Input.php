<?php

namespace PSX\Schema\Tests\Parser\Popo;

use PSX\Schema\Annotation as Schema;

class Form_Element_Input extends Form_Element
{
    /**
     * @var string
     */
    private $type;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }
}
