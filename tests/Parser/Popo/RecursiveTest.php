<?php

namespace PSX\Schema\Tests\Parser\Popo;

/**
 * @JS\AdditionalProperties(false)
 */
class RecursiveTest
{
    /**
     * @JS\Ref("PSX\Schema\Tests\Parser\Popo\RecursiveTest")
     */
    protected $foo;
}
