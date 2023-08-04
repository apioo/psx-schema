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
 * Generator which transforms a document provided from an editor to an actual TypeSchema specification
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Generator
{
    /**
     * Generates a TypeSchema specification based on the document
     * 
     * @param Document $document
     * @return string
     */
    public function generate(Document $document): string
    {
        $schema = new \stdClass();
        $import = $this->generateImport($document->getImports());
        if (!empty($import)) {
            $schema->{'$import'} = $import;
        }

        $operations = new \stdClass();
        foreach ($document->getOperations() as $operation) {
            $operations->{$operation->getName()} = $this->generateOperation($operation);
        }
        $schema->operations = $operations;

        $definitions = new \stdClass();
        $types = $document->getTypes();
        foreach ($types as $type) {
            $definitions->{$type->getName()} = $this->generateType($type);
        }
        $schema->definitions = $definitions;

        if ($document->getRoot() !== null && isset($types[$document->getRoot()])) {
            $schema->{'$ref'} = $types[$document->getRoot()]->getName();
        }

        return \json_encode($schema, \JSON_PRETTY_PRINT);
    }

    private function generateImport(?array $imports): array
    {
        if (empty($imports)) {
            return [];
        }

        $import = [];
        foreach ($imports as $include) {
            $alias = $include->getAlias() ?? null;
            $user = $include->getDocument()->user->name ?? null;
            $document = $include->getDocument()->name ?? null;
            $version = $include->getVersion() ?? null;

            if (empty($alias) || empty($user) || empty($document) || empty($version)) {
                continue;
            }

            $import[$alias] = 'typehub://' . $user . ':' . $document . '@' . $version;
        }

        return $import;
    }

    private function generateOperation(Operation $operation): \stdClass
    {
        $result = new \stdClass();

        if ($operation->getDescription() !== null) {
            $result->description = $operation->getDescription();
        }

        if ($operation->getHttpMethod() !== null) {
            $result->method = $operation->getHttpMethod();
        }

        if ($operation->getHttpPath() !== null) {
            $result->path = $operation->getHttpPath();
        }

        if (count($operation->getArguments()) > 0) {
            $args = new \stdClass();
            foreach ($operation->getArguments() as $argument) {
                $args->{$argument->getName()} = $this->generateArgument($argument->getIn(), $argument->getType());
            }
            $result->arguments = $args;
        }

        if (count($operation->getThrows()) > 0) {
            $throws = [];
            foreach ($operation->getThrows() as $throw) {
                $throws[] = $this->generateResponse($throw->getCode() ?? 500, $throw->getType());
            }
            $result->throws = $throws;
        }

        $return = $operation->getReturn();
        if ($return !== null) {
            $result->return = $this->generateResponse($operation->getHttpCode() ?? 200, $return);
        }

        if ($operation->getStability() !== null) {
            $result->stability = $operation->getStability();
        }

        if ($operation->getSecurity() !== null) {
            $result->security = $operation->getSecurity();
        }

        if ($operation->getAuthorization() !== null) {
            $result->authorization = $operation->getAuthorization();
        }

        if ($operation->getTags() !== null) {
            $result->tags = $operation->getTags();
        }

        return $result;
    }

    private function generateArgument(string $in, string $type): \stdClass
    {
        return (object) [
            'in' => $in,
            'schema' => (object) [
                '$ref' => $type
            ],
        ];
    }

    private function generateResponse(int $httpCode, string $return): object
    {
        return (object) [
            'code' => $httpCode,
            'schema' => (object) [
                '$ref' => $return
            ],
        ];
    }

    private function generateType(Type $type): \stdClass
    {
        $result = new \stdClass();

        if ($type->getDescription() !== null) {
            $result->description = $type->getDescription();
        }

        if ($type->getType() === Type::TYPE_REFERENCE) {
            $result->{'$ref'} = $type->getRef();

            if ($type->getTemplate() !== null) {
                $result->{'$template'} = (object)[
                    'T' => $type->getTemplate()
                ];
            }
        } else if ($type->getType() === Type::TYPE_MAP) {
            $result->type = 'object';
            $result->additionalProperties = new \stdClass();

            $props = $this->resolveType([$type->getRef()]);
            foreach ($props as $key => $value) {
                $result->additionalProperties->{$key} = $value;
            }
        } else {
            $result->type = 'object';

            if ($type->getParent() !== null) {
                $result->{'$extends'} = $type->getParent();
            }

            if (count($type->getProperties()) > 0) {
                $props = new \stdClass();
                foreach ($type->getProperties() as $property) {
                    $props->{$property->getName()} = $this->generateProperty($property);
                }
                $result->properties = $props;
            }
        }

        return $result;
    }

    private function generateProperty(Property $property): \stdClass
    {
        $result = new \stdClass();

        if ($property->getDescription() !== null) {
            $result->description = $property->getDescription();
        }

        if ($property->getNullable() !== null) {
            $result->nullable = $property->getNullable();
        }

        if ($property->getDeprecated() !== null) {
            $result->deprecated = $property->getDeprecated();
        }

        if ($property->getReadonly() !== null) {
            $result->readonly = $property->getReadonly();
        }

        $refs = $property->getRefs();
        
        if ($property->getType() === Property::TYPE_OBJECT) {
            $props = $this->resolveType($refs);
            foreach ($props as $key => $value) {
                $result->{$key} = $value;
            }
        } elseif ($property->getType() === Property::TYPE_MAP) {
            $result->type = 'object';
            $result->additionalProperties = $this->resolveType($refs);
        } elseif ($property->getType() === Property::TYPE_ARRAY) {
            $result->type = 'array';
            $result->items = $this->resolveType($refs);
        } elseif ($property->getType() === Property::TYPE_STRING) {
            $result->type = 'string';
            if ($property->getFormat() !== null) {
                $result->format = $property->getFormat();
            }
            if ($property->getPattern() !== null) {
                $result->pattern = $property->getPattern();
            }
            if ($property->getMinLength() !== null) {
                $result->minLength = $property->getMinLength();
            }
            if ($property->getMaxLength() !== null) {
                $result->maxLength = $property->getMaxLength();
            }
        } elseif ($property->getType() === Property::TYPE_INTEGER) {
            $result->type = 'integer';
            if ($property->getMinimum() !== null) {
                $result->minimum = $property->getMinimum();
            }
            if ($property->getMaximum() !== null) {
                $result->maximum = $property->getMaximum();
            }
        } elseif ($property->getType() === Property::TYPE_NUMBER) {
            $result->type = 'number';
            if ($property->getMinimum() !== null) {
                $result->minimum = $property->getMinimum();
            }
            if ($property->getMaximum() !== null) {
                $result->maximum = $property->getMaximum();
            }
        } elseif ($property->getType() === Property::TYPE_BOOLEAN) {
            $result->type = 'boolean';
        } elseif ($property->getType() === Property::TYPE_ANY) {
            $result->type = 'any';
        } elseif ($property->getType() === Property::TYPE_UNION) {
            $result->oneOf = [];
            foreach ($refs as $ref) {
                $result->oneOf[] = $this->resolveType([$ref]);
            }
        } elseif ($property->getType() === Property::TYPE_INTERSECTION) {
            $result->allOf = [];
            foreach ($refs as $ref) {
                $result->allOf[] = $this->resolveType([$ref]);
            }
        }

        return $result;
    }

    private function resolveType(?array $refs): object
    {
        if (empty($refs)) {
            throw new \RuntimeException('Type must contain a reference');
        }

        if (count($refs) === 1) {
            $ref = reset($refs);
            if (in_array($ref, ['string', 'integer', 'number', 'boolean', 'any'])) {
                return (object)[
                    'type' => $ref
                ];
            } elseif ($ref === 'T') {
                return (object) [
                    '$generic' => 'T'
                ];
            } else {
                return (object) [
                    '$ref' => $ref
                ];
            }
        } elseif (count($refs) > 1) {
            $types = [];
            foreach ($refs as $ref) {
                $types[] = $this->resolveType([$ref]);
            }

            return (object) [
                'oneOf' => $types
            ];
        } else {
            throw new \RuntimeException('Type must contain a reference');
        }
    }
}

