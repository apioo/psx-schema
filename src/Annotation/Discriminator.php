<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Annotation;

/**
 * Discriminator
 *
 * @Annotation
 * @Target({"PROPERTY"})
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Discriminator
{
    /**
     * @var string
     */
    protected $propertyName;

    /**
     * @var array
     */
    protected $mapping;

    public function __construct(array $values)
    {
        $value = reset($values);
        $this->propertyName = $value[0] ?? null;
        $this->mapping = $value[1] ?? null;

        if (!is_string($this->propertyName)) {
            throw new \InvalidArgumentException('Discriminator annotation first argument must be a string');
        }

        if (!is_array($this->mapping)) {
            throw new \InvalidArgumentException('Discriminator annotation second argument must be an array');
        }
    }

    /**
     * @return string
     */
    public function getPropertyName(): ?string
    {
        return $this->propertyName;
    }
    
    /**
     * @return array
     */
    public function getMapping(): ?array
    {
        return $this->mapping;
    }
}
