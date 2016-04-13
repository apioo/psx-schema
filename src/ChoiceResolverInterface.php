<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

namespace PSX\Schema;

/**
 * ChoiceResolverInterface
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
interface ChoiceResolverInterface
{
    /**
     * Returns the name of a specific type
     *
     * @param mixed $data
     * @param string $path
     * @param \PSX\Schema\Property\ChoiceType $property
     * @return string
     */
    public function getType($data, $path, Property\ChoiceType $property);

    /**
     * Returns an associative array of all possible type name => class names
     *
     * @param \PSX\Schema\Property\ChoiceType $property
     * @return array
     */
    public function getTypes(Property\ChoiceType $property);
}
