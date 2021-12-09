<?php

namespace PSX\Schema\Tests\Parser\Popo\Annotation;

use PSX\Schema\Annotation as Schema;

/**
 * @Schema\Description("An application")
 * @Schema\Required({"name", "url"})
 */
class Web
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $url;
    /**
     * @param string $name
     */
    public function setName(?string $name)
    {
        $this->name = $name;
    }
    /**
     * @return string
     */
    public function getName() : ?string
    {
        return $this->name;
    }
    /**
     * @param string $url
     */
    public function setUrl(?string $url)
    {
        $this->url = $url;
    }
    /**
     * @return string
     */
    public function getUrl() : ?string
    {
        return $this->url;
    }
}
