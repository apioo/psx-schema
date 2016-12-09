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

namespace PSX\Schema\Property;

use PSX\Schema\PropertyAbstract;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;

/**
 * ArrayType
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ArrayType extends PropertyType
{
    public function __construct()
    {
        $this->type = 'array';
    }

    /**
     * @param PropertyInterface $prototype
     * @return $this
     * @deprecated
     */
    public function setPrototype(PropertyInterface $prototype)
    {
        $this->items = $prototype;

        return $this;
    }

    /**
     * @return PropertyInterface|null
     * @deprecated
     */
    public function getPrototype()
    {
        if ($this->items instanceof PropertyInterface) {
            return $this->items;
        } else {
            return null;
        }
    }
}
