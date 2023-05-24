<?php
use PSX\Schema\Attribute\MaxProperties;
use PSX\Schema\Attribute\MinProperties;
/**
 * @extends \PSX\Record\Record<string>
 */
#[MinProperties(1)]
#[MaxProperties(6)]
class Meta extends \PSX\Record\Record
{
}
