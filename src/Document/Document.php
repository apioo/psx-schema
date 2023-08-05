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
 * A document represents a TypeSchema in an intermediate format which is used at the editor etc. to properly render a
 * specification. It uses arrays instead of objects so that it possible to explicit modify the property order
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Document implements \JsonSerializable
{
    /**
     * @var array<Import>
     */
    private array $imports;

    /**
     * @var array<Operation>
     */
    private array $operations;

    /**
     * @var array<Type>
     */
    private array $types;

    private ?int $root;

    public function __construct(?array $imports = null, ?array $operations = null, ?array $types = null, ?int $root = null)
    {
        $this->imports = $this->convertImports($imports ?? []);
        $this->operations = $this->convertOperations($operations ?? []);
        $this->types = $this->convertTypes($types ?? []);
        $this->root = $root;
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

    public function getOperations(): array
    {
        return $this->operations;
    }

    public function getOperation(int $index): ?Operation
    {
        return $this->operations[$index] ?? null;
    }

    public function indexOfOperation(string $operationName): ?int
    {
        foreach ($this->operations as $index => $operation) {
            if ($operation->getName() === $operationName) {
                return $index;
            }
        }

        return null;
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

    public function indexOfType(string $typeName): ?int
    {
        foreach ($this->types as $index => $type) {
            if ($type->getName() === $typeName) {
                return $index;
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
            'operations' => $this->operations,
            'types' => $this->types,
            'root' => $this->root,
        ];
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

    private function convertOperations(array $operations): array
    {
        $result = [];
        foreach ($operations as $operation) {
            if ($operation instanceof \stdClass) {
                $result[] = new Operation((array) $operation);
            } elseif (is_array($operation)) {
                $result[] = new Operation($operation);
            }
        }

        return $result;
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

    public static function from($document): self
    {
        if (is_string($document)) {
            $document = \json_decode($document);
        }

        if (is_array($document)) {
            if (isset($document['types'])) {
                return new self($document['imports'] ?? [], $document['operations'] ?? [], $document['types'] ?? [], $document['root'] ?? null);
            } else {
                return new self($document);
            }
        } elseif ($document instanceof \stdClass) {
            return new self($document->imports ?? [], $document->operations ?? [], $document->types ?? [], $document->root ?? null);
        } elseif ($document === null) {
            return new self([]);
        } else {
            throw new \InvalidArgumentException('Provided an invalid spec got: ' . (is_object($document) ? get_class($document) : gettype($document)));
        }
    }
}
