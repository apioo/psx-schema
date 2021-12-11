<?php

namespace PSX\Schema\Tests\Parser\Popo;

use PSX\Schema\Attribute\Discriminator;

class Form_Container
{
    /**
     * @var array<Form_Element_Input|Form_Element_Select|Form_Element_Tag|Form_Element_TextArea>
     */
    #[Discriminator('element', [
        'http://fusio-project.org/ns/2015/form/input' => 'Form_Element_Input',
        'http://fusio-project.org/ns/2015/form/select' => 'Form_Element_Select',
        'http://fusio-project.org/ns/2015/form/tag' => 'Form_Element_Tag',
        'http://fusio-project.org/ns/2015/form/textarea' => 'Form_Element_TextArea',
    ])]
    private array $elements;
}
