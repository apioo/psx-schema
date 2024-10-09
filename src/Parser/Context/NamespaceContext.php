<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PSX\Schema\Parser\Context;

use PSX\Schema\Parser\ContextInterface;

/**
 * NamespaceContext
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class NamespaceContext implements ContextInterface
{
    private int $level;

    /**
     * The level variable indicates how many parts of the class name is included in the type name. I.e. for a class
     * "Acme\My\SubSystem\Model" separate levels would result in the following names:
     *
     * - level 1 => "Model"
     * - level 2 => "SubSystem_Model"
     * - level 3 => "My_SubSystem_Model"
     */
    public function __construct(int $level = 1)
    {
        $this->level = $level;
    }

    public function getLevel(): int
    {
        return $this->level;
    }
}
