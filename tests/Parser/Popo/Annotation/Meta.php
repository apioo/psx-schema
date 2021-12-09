<?php

namespace PSX\Schema\Tests\Parser\Popo\Annotation;

use PSX\Schema\Annotation as Schema;

/**
 * @extends \PSX\Record\Record<string>
 * @Schema\MinProperties(1)
 * @Schema\MaxProperties(6)
 */
class Meta extends \PSX\Record\Record
{
}
