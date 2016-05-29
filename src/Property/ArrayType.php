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

/**
 * ArrayType
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ArrayType extends PropertyAbstract
{
    /**
     * @var \PSX\Schema\PropertyInterface
     */
    protected $prototype;

    /**
     * @var integer
     */
    protected $minItems;

    /**
     * @var integer
     */
    protected $maxItems;

    public function setPrototype(PropertyInterface $prototype)
    {
        $this->prototype = $prototype;

        return $this;
    }

    public function getPrototype()
    {
        return $this->prototype;
    }

    /**
     * @param integer $minLength
     * @return $this
     * @deprecated
     */
    public function setMinLength($minLength)
    {
        $this->minItems = $minLength;

        return $this;
    }

    /**
     * @return integer
     * @deprecated
     */
    public function getMinLength()
    {
        return $this->minItems;
    }

    /**
     * @param integer $minItems
     * @return $this
     */
    public function setMinItems($minItems)
    {
        $this->minItems = $minItems;

        return $this;
    }

    /**
     * @return integer
     */
    public function getMinItems()
    {
        return $this->minItems;
    }

    /**
     * @param integer $maxLength
     * @return $this
     * @deprecated
     */
    public function setMaxLength($maxLength)
    {
        $this->maxItems = $maxLength;

        return $this;
    }

    /**
     * @return integer
     * @deprecated
     */
    public function getMaxLength()
    {
        return $this->maxItems;
    }

    /**
     * @param integer $maxItems
     * @return $this
     */
    public function setMaxItems($maxItems)
    {
        $this->maxItems = $maxItems;

        return $this;
    }

    /**
     * @return integer
     */
    public function getMaxItems()
    {
        return $this->maxItems;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return md5(
            ($this->prototype !== null ? $this->prototype->getId() : null) .
            $this->minItems .
            $this->maxItems
        );
    }

    public function __clone()
    {
        $prototype = $this->prototype;
        if ($prototype instanceof PropertyInterface) {
            $this->prototype = clone $prototype;
        }
    }
}
