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

namespace PSX\Schema\Type;

/**
 * ArrayDefinitionType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class CollectionDefinitionType extends DefinitionTypeAbstract implements CollectionTypeInterface
{
    protected ?PropertyTypeAbstract $schema = null;

    public function getSchema(): ?PropertyTypeAbstract
    {
        return $this->schema;
    }

    public function setSchema(PropertyTypeAbstract $schema): self
    {
        $this->schema = $schema;

        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), array_filter([
            'schema' => $this->schema,
        ], function($value){
            return $value !== null;
        }));
    }

    public function __clone()
    {
        if ($this->schema !== null) {
            $schema = $this->schema;
            $this->schema = clone $schema;
        }
    }
}
