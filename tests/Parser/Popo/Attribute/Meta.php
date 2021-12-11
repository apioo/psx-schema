<?php

namespace PSX\Schema\Tests\Parser\Popo\Attribute;

use PSX\Schema\Attribute\Description;
use PSX\Schema\Attribute\MaxProperties;
use PSX\Schema\Attribute\MinProperties;
use PSX\Schema\Attribute\Required;

/**
 * @extends \PSX\Record\Record<string>
 */
#[MinProperties(1)]
#[MaxProperties(6)]
class Meta extends \PSX\Record\Record
{
}
