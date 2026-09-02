<?php

namespace PSX\Schema\Tests\Parser\Popo;

class PublicConstructorPropertiesDto
{
    public function __construct(
        public string $foo,
        public int $bar,
    ) {
    }
}
