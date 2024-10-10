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

namespace PSX\Schema\Parser;

use PSX\Json\Parser;
use PSX\Schema\Definitions;
use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\Exception\TypeNotFoundException;
use PSX\Schema\Exception\UnknownTypeException;
use PSX\Schema\Format;
use PSX\Schema\Parser\TypeSchema\BCLayer;
use PSX\Schema\ParserInterface;
use PSX\Schema\Schema;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManagerInterface;
use PSX\Schema\Type;
use PSX\Schema\Type\Enum\DefinitionType;
use PSX\Schema\Type\Enum\PropertyType;
use PSX\Schema\Type\Factory\DefinitionTypeFactory;
use PSX\Schema\Type\Factory\PropertyTypeFactory;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\TypeUtil;

/**
 * TypeSchema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TypeSchema implements ParserInterface
{
    private SchemaManagerInterface $schemaManager;

    public function __construct(SchemaManagerInterface $schemaManager)
    {
        $this->schemaManager = $schemaManager;
    }

    public function parse(string $schema, ?ContextInterface $context = null): SchemaInterface
    {
        $data = Parser::decode($schema);
        if (!$data instanceof \stdClass) {
            throw new ParserException('Schema must be an object');
        }

        return $this->parseSchema($data, $context);
    }

    public function parseSchema(\stdClass $data, ?ContextInterface $context = null): SchemaInterface
    {
        $definitions = new Definitions();

        $this->parseImport($data, $definitions, $context);
        $this->parseDefinitions($data, $definitions);

        $root = $this->getStringValue($data, ['root', '$ref']);
        if (empty($root)) {
            try {
                $type = $this->parseDefinitionType($data);
                if (!$type->isEmpty()) {
                    $root = 'RootType';
                    $definitions->addType($root, $type);
                }
            } catch (UnknownTypeException) {
            }
        }

        return new Schema($definitions, $root);
    }

    private function parseDefinitions(\stdClass $schema, DefinitionsInterface $definitions): void
    {
        $data = null;
        if (isset($schema->definitions)) {
            $data = $schema->definitions;
        } elseif (isset($schema->components->schemas)) {
            $data = $schema->components->schemas;
        }

        if (!$data instanceof \stdClass) {
            return;
        }

        foreach ($data as $name => $definition) {
            try {
                $type = $this->parseDefinitionType($definition);
            } catch (\Exception $e) {
                throw new ParserException('Type ' . $name . ' contains an invalid schema: ' . $e->getMessage(), 0, $e);
            }

            $definitions->addType($name, $type);
        }
    }

    private function parseImport(\stdClass $schema, DefinitionsInterface $definitions, ?ContextInterface $context): void
    {
        $import = $this->getObjectValue($schema, ['import', '$import']);
        if (empty($import)) {
            $import = [];
        }

        foreach ($import as $namespace => $uri) {
            $schema = $this->schemaManager->getSchema($uri, $context);
            foreach ($schema->getDefinitions()->getAllTypes() as $fullName => $type) {
                TypeUtil::refs($type, function(string $ns, string $name) use ($namespace){
                    if ($ns === DefinitionsInterface::SELF_NAMESPACE) {
                        return $namespace . ':' . $name;
                    } else {
                        return $ns . ':' . $name;
                    }
                });

                [$ns, $name] = TypeUtil::split($fullName);
                if ($ns === DefinitionsInterface::SELF_NAMESPACE) {
                    $definitions->addType($namespace . ':' . $name, $type);
                } else {
                    $definitions->addType($ns . ':' . $name, $type);
                }
            }
        }
    }

    /**
     * @throws UnknownTypeException
     */
    public function parseDefinitionType(\stdClass $data, ?string $namespace = null): Type\DefinitionTypeAbstract
    {
        $data = BCLayer::transformDefinition($data);
        $type = $this->newDefinitionType($data);

        if (isset($data->description)) {
            $type->setDescription($data->description);
        }

        if (isset($data->deprecated)) {
            $type->setDeprecated($data->deprecated);
        }

        // PSX specific attributes
        $vars = get_object_vars($data);
        foreach ($vars as $key => $value) {
            if (str_starts_with($key, 'x-psx-')) {
                $type->setAttribute(substr($key, 6), $value);
            }
        }

        if ($type instanceof Type\StructDefinitionType) {
            $this->parseDefinitionStruct($type, $data, $namespace);
        } elseif ($type instanceof Type\MapDefinitionType) {
            $this->parseDefinitionMap($type, $data, $namespace);
        } elseif ($type instanceof Type\ArrayDefinitionType) {
            $this->parseDefinitionArray($type, $data, $namespace);
        }

        return $type;
    }

    private function parseDefinitionStruct(StructDefinitionType $type, \stdClass $data, ?string $namespace): void
    {
        $base = $this->getBooleanValue($data, ['base']);
        if ($base !== null) {
            $type->setBase($base);
        }

        $discriminator = $this->getStringValue($data, ['discriminator']);
        if (!empty($discriminator)) {
            $type->setDiscriminator($discriminator);
        }

        $mapping = $this->getObjectValue($data, ['mapping']);
        if ($mapping instanceof \stdClass) {
            $result = [];
            foreach ($mapping as $mappingType => $mappingValue) {
                if ($namespace !== null) {
                    $result[$namespace . ':' . $mappingType] = $mappingValue;
                } else {
                    $result[$mappingType] = $mappingValue;
                }
            }

            $type->setMapping($result);
        }

        $parent = $this->getStringValue($data, ['parent', '$extends', '$ref']);
        if (!empty($parent)) {
            $legacyParent = (object) [
                'type' => 'reference',
                'target' => $parent,
                'template' => $this->getObjectValue($data, ['template', '$template']),
            ];

            $parentType = $this->parsePropertyType($legacyParent, $namespace);
            if (!$parentType instanceof ReferencePropertyType) {
                throw new ParserException('Parent must be an reference type');
            }

            $type->setParent($parentType);
        }

        $parent = $this->getObjectValue($data, ['parent']);
        if ($parent instanceof \stdClass) {
            $parentType = $this->parsePropertyType($parent, $namespace);
            if (!$parentType instanceof ReferencePropertyType) {
                throw new ParserException('Parent must be an reference type');
            }

            $type->setParent($parentType);
        }

        $properties = $this->getObjectValue($data, ['properties']);
        if ($properties instanceof \stdClass) {
            foreach ($properties as $name => $row) {
                if ($row instanceof \stdClass) {
                    $type->addProperty($name, $this->parsePropertyType($row, $namespace));
                }
            }
        }
    }

    private function parseDefinitionMap(Type\MapDefinitionType $type, \stdClass $data, ?string $namespace): void
    {
        $schema = $this->getObjectValue($data, ['schema', 'additionalProperties']);
        if ($schema instanceof \stdClass) {
            $type->setSchema($this->parsePropertyType($schema, $namespace));
        }
    }

    private function parseDefinitionArray(Type\ArrayDefinitionType $type, \stdClass $data, ?string $namespace): void
    {
        $schema = $this->getObjectValue($data, ['schema', 'items']);
        if ($schema instanceof \stdClass) {
            $type->setSchema($this->parsePropertyType($schema, $namespace));
        }
    }

    private function newDefinitionType(\stdClass $data): Type\DefinitionTypeAbstract
    {
        $rawType = $this->getStringValue($data, ['type']);
        $type = is_string($rawType) ? DefinitionType::tryFrom($rawType) : null;

        if ($type === DefinitionType::STRUCT) {
            return DefinitionTypeFactory::getStruct();
        } elseif ($type === DefinitionType::MAP) {
            return DefinitionTypeFactory::getMap();
        } elseif ($type === DefinitionType::ARRAY) {
            return DefinitionTypeFactory::getArray();
        }

        throw new UnknownTypeException('Could not assign schema to a definition type, got the following keys: ' . implode(',', array_keys(get_object_vars($data))));
    }

    public function parsePropertyType(\stdClass $data, ?string $namespace = null): Type\PropertyTypeAbstract
    {
        $data = BCLayer::transformProperty($data);
        $type = $this->newPropertyType($data);

        $description = $this->getStringValue($data, ['description']);
        if ($description !== null) {
            $type->setDescription($description);
        }

        $deprecated = $this->getBooleanValue($data, ['deprecated']);
        if ($deprecated !== null) {
            $type->setDeprecated($deprecated);
        }

        $nullable = $this->getBooleanValue($data, ['nullable']);
        if ($nullable !== null) {
            $type->setNullable($nullable);
        }

        if ($type instanceof Type\CollectionPropertyType) {
            $this->parseCollection($type, $data, $namespace);
        } elseif ($type instanceof Type\StringPropertyType) {
            $this->parseString($type, $data);
        } elseif ($type instanceof Type\ReferencePropertyType) {
            $this->parseReference($type, $data, $namespace);
        } elseif ($type instanceof Type\GenericPropertyType) {
            $this->parseGeneric($type, $data);
        }

        return $type;
    }

    protected function parseCollection(Type\CollectionPropertyType $type, \stdClass $data, ?string $namespace): void
    {
        $schema = null;
        if ($type instanceof Type\MapPropertyType) {
            $schema = $this->getObjectValue($data, ['schema', 'additionalProperties']);
        } elseif ($type instanceof Type\ArrayPropertyType) {
            $schema = $this->getObjectValue($data, ['schema', 'items']);
        }

        if ($schema instanceof \stdClass) {
            $type->setSchema($this->parsePropertyType($schema, $namespace));
        }
    }

    protected function parseString(StringPropertyType $property, \stdClass $data): void
    {
        $rawFormat = $this->getStringValue($data, ['format']);
        $format = is_string($rawFormat) ? Format::tryFrom($rawFormat) : null;

        if ($format instanceof Format) {
            $property->setFormat($format);
        }
    }

    protected function parseReference(ReferencePropertyType $type, \stdClass $data, ?string $namespace): void
    {
        $target = $this->getStringValue($data, ['target', '$ref']);
        if (empty($target)) {
            throw new ParserException('Provided reference target must be of type string');
        }

        // JSON Schema compatibility
        $target = str_replace('#/definitions/', '', $target);
        // OpenAPI compatibility
        $target = str_replace('#/components/schemas/', '', $target);

        if (str_contains($target, ':')) {
            $namespace = null;
        }

        if ($namespace !== null) {
            $type->setTarget($namespace . ':' . $target);
        } else {
            $type->setTarget($target);
        }

        $template = $this->getObjectValue($data, ['template', '$template']);
        if ($template instanceof \stdClass) {
            $result = [];
            foreach ($template as $templateName => $templateType) {
                if ($namespace !== null) {
                    $result[$templateName] = $namespace . ':' . $templateType;
                } else {
                    $result[$templateName] = $templateType;
                }
            }

            $type->setTemplate($result);
        }
    }

    protected function parseGeneric(Type\GenericPropertyType $type, \stdClass $data): void
    {
        $name = $this->getStringValue($data, ['name', '$generic']);
        if (empty($name)) {
            throw new ParserException('Provided generic name must be of type string');
        }

        $type->setName($name);
    }

    private function newPropertyType(\stdClass $data): PropertyTypeAbstract
    {
        $rawType = $this->getStringValue($data, ['type']);
        $type = is_string($rawType) ? PropertyType::tryFrom($rawType) : null;

        if ($type === PropertyType::MAP) {
            return PropertyTypeFactory::getMap();
        } elseif ($type === PropertyType::ARRAY) {
            return PropertyTypeFactory::getArray();
        } elseif ($type === PropertyType::STRING) {
            return PropertyTypeFactory::getString();
        } elseif ($type === PropertyType::INTEGER) {
            return PropertyTypeFactory::getInteger();
        } elseif ($type === PropertyType::NUMBER) {
            return PropertyTypeFactory::getNumber();
        } elseif ($type === PropertyType::BOOLEAN) {
            return PropertyTypeFactory::getBoolean();
        } elseif ($type === PropertyType::ANY) {
            return PropertyTypeFactory::getAny();
        } elseif ($type === PropertyType::REFERENCE) {
            return PropertyTypeFactory::getReference();
        } elseif ($type === PropertyType::GENERIC) {
            return PropertyTypeFactory::getGeneric();
        }

        throw new UnknownTypeException('Could not assign schema to a property type, got the following keys: ' . implode(',', array_keys(get_object_vars($data))));
    }

    private function getStringValue(\stdClass $data, array $keywords): ?string
    {
        foreach ($keywords as $keyword) {
            if (isset($data->{$keyword}) && is_string($data->{$keyword})) {
                return $data->{$keyword};
            }
        }

        return null;
    }

    private function getBooleanValue(\stdClass $data, array $keywords): ?bool
    {
        foreach ($keywords as $keyword) {
            if (isset($data->{$keyword}) && is_bool($data->{$keyword})) {
                return $data->{$keyword};
            }
        }

        return null;
    }

    private function getObjectValue(\stdClass $data, array $keywords): ?\stdClass
    {
        foreach ($keywords as $keyword) {
            if (isset($data->{$keyword}) && $data->{$keyword} instanceof \stdClass) {
                return $data->{$keyword};
            }
        }

        return null;
    }
}
