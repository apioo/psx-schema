<?php

namespace PSX\Schema\Tests\Parser\Popo;

/**
 * @AdditionalProperties(false)
 */
class RecursiveTest
{
    /**
     * @Ref("PSX\Schema\Tests\Parser\Popo\RecursiveTest")
     */
    protected $foo;
}
