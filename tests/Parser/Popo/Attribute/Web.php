<?php

namespace PSX\Schema\Tests\Parser\Popo\Attribute;

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\Required;

#[Description('An application')]
#[Required(['name', 'url'])]
class Web
{
    protected ?string $name = null;
    protected ?string $url = null;

    public function setName(?string $name)
    {
        $this->name = $name;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function setUrl(?string $url)
    {
        $this->url = $url;
    }

    public function getUrl() : ?string
    {
        return $this->url;
    }
}
