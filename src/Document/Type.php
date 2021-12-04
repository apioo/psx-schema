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

namespace PSX\Schema\Document;

/**
 * Type
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Type implements \JsonSerializable
{
    public const TYPE_OBJECT = 'object';
    public const TYPE_MAP = 'map';
    public const TYPE_REFERENCE = 'reference';

    private $name;
    private $type;
    private $description;
    private $parent;
    private $ref;
    private $template;

    /**
     * @var Property[]
     */
    private $properties;

    public function __construct(array $entity)
    {
        $this->name = $entity['name'] ?? null;
        $this->type = $entity['type'] ?? null;
        $this->description = $entity['description'] ?? null;
        $this->parent = $entity['parent'] ?? null;
        $this->ref = $entity['ref'] ?? null;
        $this->template = $entity['template'] ?? null;
        $this->properties = $this->convertProperties($entity['properties']);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    /**
     * @return Property[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    public function getProperty(int $index): ?Property
    {
        return $this->properties[$index] ?? null;
    }

    public function indexOf(string $propertyName): ?int
    {
        foreach ($this->properties as $index => $property) {
            if ($property->getName() === $propertyName) {
                return $index;
            }
        }

        return null;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'parent' => $this->parent,
            'ref' => $this->ref,
            'template' => $this->template,
            'properties' => $this->properties,
        ];
    }

    private function convertProperties(array $properties): array
    {
        $result = [];
        foreach ($properties as $property) {
            if ($property instanceof \stdClass) {
                $result[] = new Property((array) $property);
            } elseif (is_array($property)) {
                $result[] = new Property($property);
            }
        }

        return $result;
    }
}
