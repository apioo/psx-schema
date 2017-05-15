<?php

namespace PSX\Schema\Tests\Parser\Popo;

use PSX\Schema\Parser\Popo\Annotation as JS;

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
