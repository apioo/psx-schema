<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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
 * Document
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Document implements \JsonSerializable
{
    /**
     * @var Type[]
     */
    private array $types;

    /**
     * @var Import[]
     */
    private array $imports;

    private ?int $root;

    public function __construct(array $types, ?array $imports = null, ?int $root = null)
    {
        $this->types = $this->convertTypes($types);
        $this->imports = $imports !== null ? $this->convertImports($imports) : [];
        $this->root = $root;
    }

    /**
     * @return Type[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    public function getType(int $index): ?Type
    {
        return $this->types[$index] ?? null;
    }

    public function indexOf(string $typeName): ?int
    {
        foreach ($this->types as $index => $type) {
            if ($type->getName() === $typeName) {
                return $index;
            }
        }

        return null;
    }

    public function getImports(): ?array
    {
        return $this->imports;
    }

    public function getImport(string $alias): ?Import
    {
        foreach ($this->imports as $import) {
            if ($import->getAlias() === $alias) {
                return $import;
            }
        }

        return null;
    }

    public function getRoot(): ?int
    {
        return $this->root;
    }

    public function jsonSerialize(): array
    {
        return [
            'imports' => $this->imports,
            'types' => $this->types,
            'root' => $this->root,
        ];
    }

    private function convertTypes(array $types): array
    {
        $result = [];
        foreach ($types as $type) {
            if ($type instanceof \stdClass) {
                $result[] = new Type((array) $type);
            } elseif (is_array($type)) {
                $result[] = new Type($type);
            }
        }

        return $result;
    }

    private function convertImports(array $imports): array
    {
        $result = [];
        foreach ($imports as $import) {
            if ($import instanceof \stdClass) {
                $result[] = new Import((array) $import);
            } elseif (is_array($import)) {
                $result[] = new Import($import);
            }
        }

        return $result;
    }

    public static function from($document): self
    {
        if (is_string($document)) {
            $document = \json_decode($document);
        }

        if (is_array($document)) {
            if (isset($document['types'])) {
                return new self($document['types'] ?? [], $document['imports'] ?? [], $document['root'] ?? null);
            } else {
                return new self($document);
            }
        } elseif ($document instanceof \stdClass) {
            return new self($document->types ?? [], $document->imports ?? [], $document->root ?? null);
        } elseif ($document === null) {
            return new self([]);
        } else {
            throw new \InvalidArgumentException('Provided an invalid spec got: ' . (is_object($document) ? get_class($document) : gettype($document)));
        }
    }
}
