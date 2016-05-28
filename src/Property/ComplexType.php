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

use PSX\Schema\PropertyInterface;

/**
 * ComplexType
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ComplexType extends CompositeTypeAbstract
{
    /**
     * @var boolean|\PSX\Schema\PropertyInterface
     */
    protected $additionalProperties = false;

    /**
     * @var \PSX\Schema\PropertyInterface[]
     */
    protected $patternProperties = array();

    /**
     * @var integer
     */
    protected $minProperties;

    /**
     * @var integer
     */
    protected $maxProperties;

    public function setAdditionalProperties($value)
    {
        $this->additionalProperties = $value;

        return $this;
    }

    public function getAdditionalProperties()
    {
        return $this->additionalProperties;
    }

    public function setPatternProperties($patternProperties)
    {
        $this->patternProperties = $patternProperties;

        return $this;
    }

    public function getPatternProperties()
    {
        return $this->patternProperties;
    }

    public function addPatternProperty($pattern, PropertyInterface $prototype)
    {
        $this->patternProperties[$pattern] = $prototype;

        return $this;
    }

    /**
     * @return integer
     */
    public function getMinProperties()
    {
        return $this->minProperties;
    }

    /**
     * @param integer $minProperties
     */
    public function setMinProperties($minProperties)
    {
        $this->minProperties = $minProperties;
    }

    /**
     * @return integer
     */
    public function getMaxProperties()
    {
        return $this->maxProperties;
    }

    /**
     * @param integer $maxProperties
     */
    public function setMaxProperties($maxProperties)
    {
        $this->maxProperties = $maxProperties;
    }

    public function getId()
    {
        $result     = parent::getId();
        $properties = $this->patternProperties;

        ksort($properties);

        foreach ($properties as $pattern => $property) {
            $result.= $pattern . $property->getId();
        }

        if (is_bool($this->additionalProperties)) {
            $result.= $this->additionalProperties;
        } elseif ($this->additionalProperties instanceof PropertyInterface) {
            $result.= $this->additionalProperties->getId();
        }

        $result.= $this->minProperties;
        $result.= $this->maxProperties;

        return md5($result);
    }
}
