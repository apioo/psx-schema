<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Generator\Code;

use PSX\Schema\PropertyInterface;

/**
 * Map
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Map
{
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var string
     */
    private $type;
    
    /**
     * @var PropertyInterface
     */
    private $property;

    public function __construct(string $name, string $type, PropertyInterface $property)
    {
        $this->name = $name;
        $this->type = $type;
        $this->property = $property;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getComment(): ?string
    {
        return $this->property->getDescription();
    }

    /**
     * @return PropertyInterface
     */
    public function getProperty(): PropertyInterface
    {
        return $this->property;
    }
}
