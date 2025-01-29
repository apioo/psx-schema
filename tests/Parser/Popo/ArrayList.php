<?php

namespace PSX\Schema\Tests\Parser\Popo;

/**
 * @extends \ArrayIterator<string>
 */
class ArrayList extends \ArrayIterator implements \JsonSerializable
{
    public function jsonSerialize(): mixed
    {
        return iterator_to_array($this, false);
    }
}
