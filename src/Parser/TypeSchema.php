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

namespace PSX\Schema\Parser;

use PSX\Json\Parser;
use PSX\Schema\Definitions;
use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Exception\InvalidSchemaException;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\Exception\UnknownTypeException;
use PSX\Schema\Format;
use PSX\Schema\Parser\TypeSchema\BCLayer;
use PSX\Schema\Parser\TypeSchema\ImportResolver;
use PSX\Schema\ParserInterface;
use PSX\Schema\Schema;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Type;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\GenericType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeFactory;
use PSX\Schema\TypeInterface;
use PSX\Uri\Uri;

/**
 * TypeSchema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TypeSchema implements ParserInterface
{
    private ImportResolver $resolver;
    private ?string $basePath;

    public function __construct(ImportResolver $resolver = null, ?string $basePath = null)
    {
        $this->resolver = $resolver ?: ImportResolver::createDefault();
        $this->basePath = $basePath;
    }

    public function parse(string $schema): SchemaInterface
    {
        $data = Parser::decode($schema);
        if (!$data instanceof \stdClass) {
            throw new ParserException('Schema must be an object');
        }

        return $this->parseSchema($data);
    }

    public function parseSchema(\stdClass $data): SchemaInterface
    {
        $definitions = new Definitions();

        $this->parseImport($data, $definitions, $this->basePath);
        $this->parseDefinitions(null, $data, $definitions);

        try {
            $type = $this->parseType($data);
        } catch (UnknownTypeException $e) {
            // in case we parse i.e. an OpenAPI document we have no root schema
            // and only definitions
            $type = TypeFactory::getAny();
        }

        return new Schema($type, $definitions);
    }

    private function parseDefinitions(?string $namespace, \stdClass $schema, DefinitionsInterface $definitions)
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
                $type = $this->parseType($definition, $namespace);
            } catch (\Exception $e) {
                throw new ParserException('Type ' . $name . ' contains an invalid schema: ' . $e->getMessage(), 0, $e);
            }

            if ($namespace !== null) {
                $definitions->addType($namespace . ':' . $name, $type);
            } else {
                $definitions->addType($name, $type);
            }
        }
    }

    private function parseImport(\stdClass $schema, DefinitionsInterface $definitions, ?string $basePath = null)
    {
        $import = $schema->{'$import'} ?? null;
        if (!$import instanceof \stdClass) {
            return;
        }

        foreach ($import as $namespace => $uri) {
            $uri = Uri::parse($uri);
            $path = $basePath . $uri->getPath();
            $basePath = pathinfo($path, PATHINFO_DIRNAME);

            $data = $this->resolver->resolve($uri, $basePath);
            $this->parseImport($data, $definitions, $basePath);
            $this->parseDefinitions($namespace, $data, $definitions);
        }
    }

    /**
     * @throws InvalidSchemaException
     * @throws ParserException
     * @throws UnknownTypeException
     */
    public function parseType(\stdClass $data, ?string $namespace = null): TypeInterface
    {
        $data = BCLayer::transform($data);
        $type = $this->newPropertyType($data);

        if ($type instanceof TypeAbstract) {
            $this->parseCommon($type, $data);
        }

        if ($type instanceof ScalarType) {
            $this->parseScalar($type, $data);
        }

        if ($type instanceof StructType) {
            $this->parseStruct($type, $data, $namespace);
        } elseif ($type instanceof MapType) {
            $this->parseMap($type, $data, $namespace);
        } elseif ($type instanceof ArrayType) {
            $this->parseArray($type, $data, $namespace);
        } elseif ($type instanceof NumberType || $type instanceof IntegerType) {
            $this->parseNumber($type, $data);
        } elseif ($type instanceof StringType) {
            $this->parseString($type, $data);
        } elseif ($type instanceof IntersectionType) {
            $this->parseIntersection($type, $data, $namespace);
        } elseif ($type instanceof UnionType) {
            $this->parseUnion($type, $data, $namespace);
        } elseif ($type instanceof ReferenceType) {
            $this->parseReference($type, $data, $namespace);
        } elseif ($type instanceof GenericType) {
            $this->parseGeneric($type, $data);
        }

        return $type;
    }

    protected function parseCommon(TypeAbstract $type, \stdClass $data)
    {
        if (isset($data->title)) {
            $type->setTitle($data->title);
        }

        if (isset($data->description)) {
            $type->setDescription($data->description);
        }

        if (isset($data->nullable)) {
            $type->setNullable($data->nullable);
        }

        if (isset($data->deprecated)) {
            $type->setDeprecated($data->deprecated);
        }

        if (isset($data->readonly)) {
            $type->setReadonly($data->readonly);
        }

        // PSX specific attributes
        $vars = get_object_vars($data);
        foreach ($vars as $key => $value) {
            if (substr($key, 0, 6) === 'x-psx-') {
                $type->setAttribute(substr($key, 6), $value);
            }
        }
    }

    protected function parseScalar(ScalarType $property, \stdClass $data)
    {
        if (isset($data->format) && is_string($data->format)) {
            $format = Format::tryFrom($data->format);
            if ($format !== null) {
                $property->setFormat($format);
            }
        }

        if (isset($data->enum)) {
            $property->setEnum($data->enum);
        }

        if (isset($data->const)) {
            $property->setConst($data->const);
        }

        if (isset($data->default)) {
            $property->setDefault($data->default);
        }
    }

    /**
     * @throws InvalidSchemaException
     */
    protected function parseStruct(StructType $type, \stdClass $data, ?string $namespace): void
    {
        if (isset($data->{'$extends'})) {
            if ($namespace !== null) {
                $type->setExtends($namespace . ':' . $data->{'$extends'});
            } else {
                $type->setExtends($data->{'$extends'});
            }
        }

        if (isset($data->properties) && $data->properties instanceof \stdClass) {
            foreach ($data->properties as $name => $row) {
                if ($row instanceof \stdClass) {
                    $type->addProperty($name, $this->parseType($row, $namespace));
                }
            }
        }

        if (isset($data->required) && is_array($data->required)) {
            $type->setRequired($data->required);
        }
    }

    /**
     * @throws InvalidSchemaException
     */
    protected function parseMap(MapType $type, \stdClass $data, ?string $namespace): void
    {
        if (isset($data->additionalProperties)) {
            if ($data->additionalProperties === true) {
                // in TypeSchema we allow only true, which means any value
                $type->setAdditionalProperties(TypeFactory::getAny());
            } elseif ($data->additionalProperties instanceof \stdClass) {
                $type->setAdditionalProperties($this->parseType($data->additionalProperties, $namespace));
            }
        }

        if (isset($data->minProperties)) {
            $type->setMinProperties($data->minProperties);
        }

        if (isset($data->maxProperties)) {
            $type->setMaxProperties($data->maxProperties);
        }
    }

    /**
     * @throws InvalidSchemaException
     */
    protected function parseArray(ArrayType $type, \stdClass $data, ?string $namespace): void
    {
        if (isset($data->items)) {
            if ($data->items === true) {
                $type->setItems(TypeFactory::getAny());
            } elseif ($data->items instanceof \stdClass) {
                $type->setItems($this->parseType($data->items, $namespace));
            }
        }

        if (isset($data->minItems)) {
            $type->setMinItems($data->minItems);
        }

        if (isset($data->maxItems)) {
            $type->setMaxItems($data->maxItems);
        }

        if (isset($data->uniqueItems)) {
            $type->setUniqueItems($data->uniqueItems);
        }
    }

    /**
     * @throws InvalidSchemaException
     */
    protected function parseNumber(NumberType $type, \stdClass $data): void
    {
        if (isset($data->minimum)) {
            $type->setMinimum($data->minimum);
        }

        if (isset($data->exclusiveMinimum)) {
            $type->setExclusiveMinimum((bool) $data->exclusiveMinimum);
        }

        if (isset($data->maximum)) {
            $type->setMaximum($data->maximum);
        }

        if (isset($data->exclusiveMaximum)) {
            $type->setExclusiveMaximum((bool) $data->exclusiveMaximum);
        }

        if (isset($data->multipleOf)) {
            $type->setMultipleOf($data->multipleOf);
        }
    }

    protected function parseString(StringType $type, \stdClass $data): void
    {
        if (isset($data->pattern)) {
            $type->setPattern($data->pattern);
        }

        if (isset($data->minLength)) {
            $type->setMinLength($data->minLength);
        }

        if (isset($data->maxLength)) {
            $type->setMaxLength($data->maxLength);
        }
    }

    /**
     * @throws InvalidSchemaException
     */
    protected function parseIntersection(IntersectionType $type, \stdClass $data, ?string $namespace): void
    {
        if (isset($data->allOf) && is_array($data->allOf)) {
            $props = [];
            foreach ($data->allOf as $prop) {
                if ($prop instanceof \stdClass) {
                    $props[] = $this->parseType($prop, $namespace);
                }
            }

            $type->setAllOf($props);
        }
    }

    /**
     * @throws InvalidSchemaException
     */
    protected function parseUnion(UnionType $type, \stdClass $data, ?string $namespace): void
    {
        if (isset($data->oneOf) && is_array($data->oneOf)) {
            $props = [];
            foreach ($data->oneOf as $prop) {
                if ($prop instanceof \stdClass) {
                    $props[] = $this->parseType($prop, $namespace);
                }
            }

            $type->setOneOf($props);

            if (isset($data->discriminator) && isset($data->discriminator->propertyName)) {
                $propertyName = $data->discriminator->propertyName;
                $mapping = $data->discriminator->mapping ?? null;

                $type->setDiscriminator($propertyName, (array) $mapping);
            }
        }
    }

    protected function parseReference(ReferenceType $type, \stdClass $data, ?string $namespace): void
    {
        $ref = $data->{'$ref'} ?? null;
        if (empty($ref) || !is_string($ref)) {
            throw new ParserException('Provided reference must be of type string');
        }

        // JSON Schema compatibility
        $ref = str_replace('#/definitions/', '', $ref);
        // OpenAPI compatibility
        $ref = str_replace('#/components/schemas/', '', $ref);

        if (strpos($ref, ':') !== false) {
            $namespace = null;
        }

        if ($namespace !== null) {
            $type->setRef($namespace . ':' . $ref);
        } else {
            $type->setRef($ref);
        }

        $template = $data->{'$template'} ?? null;
        if (!empty($template) && $template instanceof \stdClass) {
            $vars = get_object_vars($template);
            if ($namespace !== null) {
                $vars = array_map(static function(string $value) use ($namespace) {
                    return $namespace . ':' . $value;
                }, $vars);
            }

            $type->setTemplate($vars);
        }
    }

    protected function parseGeneric(GenericType $type, \stdClass $data): void
    {
        $generic = $data->{'$generic'} ?? null;
        if (empty($generic) || !is_string($generic)) {
            throw new ParserException('Provided generic must be of type string');
        }

        $type->setGeneric($generic);
    }

    private function newPropertyType(\stdClass $data): TypeInterface
    {
        $type = isset($data->type) && is_string($data->type) ? Type::tryFrom($data->type) : null;
        if ($type === Type::OBJECT) {
            if (isset($data->properties)) {
                return TypeFactory::getStruct();
            } elseif (isset($data->additionalProperties)) {
                return TypeFactory::getMap();
            }
        } elseif ($type === Type::ARRAY) {
            return TypeFactory::getArray();
        } elseif ($type === Type::STRING) {
            return TypeFactory::getString();
        } elseif ($type === Type::INTEGER) {
            return TypeFactory::getInteger();
        } elseif ($type === Type::NUMBER) {
            return TypeFactory::getNumber();
        } elseif ($type === Type::BOOLEAN) {
            return TypeFactory::getBoolean();
        } elseif ($type === Type::ANY) {
            return TypeFactory::getAny();
        } elseif (isset($data->allOf)) {
            return TypeFactory::getIntersection();
        } elseif (isset($data->oneOf)) {
            return TypeFactory::getUnion();
        } elseif (isset($data->{'$ref'})) {
            return TypeFactory::getReference();
        } elseif (isset($data->{'$generic'})) {
            return TypeFactory::getGeneric();
        }

        throw new UnknownTypeException('Could not assign schema to a type, got the following keys: ' . implode(',', array_keys(get_object_vars($data))));
    }

    public static function fromFile($file, ImportResolver $resolver = null): SchemaInterface
    {
        if (!empty($file) && is_file($file)) {
            $basePath = pathinfo($file, PATHINFO_DIRNAME);
            $parser   = new self($resolver, $basePath);

            return $parser->parse(file_get_contents($file));
        } else {
            throw new ParserException('Could not load json schema ' . $file);
        }
    }
}
