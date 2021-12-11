<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * ReferenceType
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ReferenceType extends TypeAbstract
{
    /**
     * @var string
     */
    protected $ref;

    /**
     * @var array
     */
    protected $template;

    /**
     * @return string
     */
    public function getRef(): ?string
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     * @return self
     */
    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }

    /**
     * @return array
     */
    public function getTemplate(): ?array
    {
        return $this->template;
    }

    /**
     * @param array $template
     */
    public function setTemplate(array $template): void
    {
        $this->template = $template;
    }

    /**
     * The type which is used in case the resolved reference contains a
     * $generic keyword
     * 
     * @param string $type
     * @param string $template
     * @return self
     */
    public function addTemplate(string $type, string $template): self
    {
        $this->template[$type] = $template;

        return $this;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), array_filter([
            '$ref' => $this->ref,
            '$template' => $this->template,
        ], function($value){
            return $value !== null;
        }));
    }

    public function __clone()
    {
        if ($this->template !== null) {
            $templates = $this->template;
            $this->template = [];

            foreach ($templates as $name => $template) {
                $this->template[$name] = clone $templates[$name];
            }
        }
    }
}
