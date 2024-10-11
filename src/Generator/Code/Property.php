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

namespace PSX\Schema\Generator\Code;

use PSX\Schema\Type\PropertyTypeAbstract;

/**
 * Property
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Property
{
    private Name $name;
    private string $type;
    private string $docType;
    private PropertyTypeAbstract $origin;

    public function __construct(Name $name, string $type, string $docType, PropertyTypeAbstract $origin)
    {
        $this->name = $name;
        $this->type = $type;
        $this->docType = $docType;
        $this->origin = $origin;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDocType(): string
    {
        return $this->docType;
    }

    public function getComment(): ?string
    {
        return $this->origin->getDescription();
    }

    public function isDeprecated(): ?bool
    {
        return $this->origin->isDeprecated();
    }

    public function isNullable(): ?bool
    {
        return $this->origin->isNullable();
    }

    public function getOrigin(): PropertyTypeAbstract
    {
        return $this->origin;
    }
}
