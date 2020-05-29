<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2019 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use PSX\Schema\Parser\TypeSchema\ImportResolver;
use PSX\Schema\ParserInterface;
use PSX\Schema\Schema;
use PSX\Schema\SchemaInterface;
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
use RuntimeException;

/**
 * TypeSchema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class TypeSchema implements ParserInterface
{
    /**
     * @var \PSX\Schema\Parser\TypeSchema\ImportResolver
     */
    protected $resolver;

    /**
     * @param \PSX\Schema\Parser\TypeSchema\ImportResolver|null $resolver
     */
    public function __construct(ImportResolver $resolver = null)
    {
        $this->resolver = $resolver ?: ImportResolver::createDefault();
    }

    public function parse($schema)
    {
        $data = Parser::decode($schema, true);

        $definitions = new Definitions();

        $this->parseDefinitions(Definitions::SELF_NAMESPACE, $data, $definitions);
        $this->parseImport($data, $definitions);

        $type = $this->parseType($data);

        return new Schema($type, $definitions);
    }

    private function parseDefinitions(string $namespace, array $schema, DefinitionsInterface $definitions)
    {
        $data = null;
        if (isset($schema['definitions'])) {
            $data = $schema['definitions'];
        } elseif (isset($schema['components']['schemas'])) {
            $data = $schema['components']['schemas'];
        }

        if (!is_array($data)) {
            return;
        }

        foreach ($data as $name => $definition) {
            $type = $this->parseType($definition);
            $definitions->addType($namespace . ':' . $name, $type);
        }
    }

    private function parseImport(array $schema, DefinitionsInterface $definitions)
    {
        $import = $schema['$import'] ?? null;
        if (!is_array($import)) {
            return;
        }

        foreach ($import as $namespace => $uri) {
            $data = $this->resolver->resolve(new Uri($uri));
            $this->parseDefinitions($namespace, $data, $definitions);
        }
    }

    private function parseType(array $data): TypeInterface
    {
        $data = $this->transformBcLayer($data);
        $type = $this->newPropertyType($data);

        if ($type instanceof TypeAbstract) {
            $this->parseCommon($type, $data);
        }

        if ($type instanceof ScalarType) {
            $this->parseScalar($type, $data);
        }

        if ($type instanceof StructType) {
            $this->parseStruct($type, $data);
        } elseif ($type instanceof MapType) {
            $this->parseMap($type, $data);
        } elseif ($type instanceof ArrayType) {
            $this->parseArray($type, $data);
        } elseif ($type instanceof NumberType || $type instanceof IntegerType) {
            $this->parseNumber($type, $data);
        } elseif ($type instanceof StringType) {
            $this->parseString($type, $data);
        } elseif ($type instanceof IntersectionType) {
            $this->parseIntersection($type, $data);
        } elseif ($type instanceof UnionType) {
            $this->parseUnion($type, $data);
        } elseif ($type instanceof ReferenceType) {
            $this->parseReference($type, $data);
        } elseif ($type instanceof GenericType) {
            $this->parseGeneric($type, $data);
        }

        // PSX specific attributes
        foreach ($data as $key => $value) {
            if (substr($key, 0, 6) === 'x-psx-') {
                $type->setAttribute(substr($key, 6), $value);
            }
        }

        return $type;
    }

    protected function parseCommon(TypeAbstract $type, array $data)
    {
        if (isset($data['title'])) {
            $type->setTitle($data['title']);
        }

        if (isset($data['description'])) {
            $type->setDescription($data['description']);
        }

        if (isset($data['nullable'])) {
            $type->setNullable($data['nullable']);
        }

        if (isset($data['deprecated'])) {
            $type->setDeprecated($data['deprecated']);
        }

        if (isset($data['readonly'])) {
            $type->setReadonly($data['readonly']);
        }
    }

    protected function parseScalar(ScalarType $property, array $data)
    {
        if (isset($data['format'])) {
            $property->setFormat($data['format']);
        }

        if (isset($data['enum'])) {
            $property->setEnum($data['enum']);
        }

        if (isset($data['const'])) {
            $property->setConst($data['const']);
        }

        if (isset($data['default'])) {
            $property->setDefault($data['default']);
        }
    }

    protected function parseStruct(StructType $type, array $data): void
    {
        if (isset($data['$extends'])) {
            $type->setExtends($data['$extends']);
        }

        if (isset($data['properties']) && is_array($data['properties'])) {
            foreach ($data['properties'] as $name => $row) {
                if (is_array($row)) {
                    $prop = $this->parseType($row);

                    if ($prop !== null) {
                        $type->addProperty($name, $prop);
                    }
                }
            }
        }

        if (isset($data['required']) && is_array($data['required'])) {
            $type->setRequired($data['required']);
        }
    }

    protected function parseMap(MapType $type, array $data): void
    {
        if (isset($data['additionalProperties'])) {
            if ($data['additionalProperties'] === true) {
                // in TypeSchema we allow only true, which means any value
                $type->setAdditionalProperties(TypeFactory::getAny());
            } elseif (is_array($data['additionalProperties'])) {
                $type->setAdditionalProperties($this->parseType($data['additionalProperties']));
            }
        }

        if (isset($data['minProperties'])) {
            $type->setMinProperties($data['minProperties']);
        }

        if (isset($data['maxProperties'])) {
            $type->setMaxProperties($data['maxProperties']);
        }
    }

    protected function parseArray(ArrayType $type, array $data): void
    {
        if (isset($data['items'])) {
            if ($data['items'] === true) {
                $type->setItems(TypeFactory::getAny());
            } elseif (is_array($data['items'])) {
                $type->setItems($this->parseType($data['items']));
            }
        }

        if (isset($data['minItems'])) {
            $type->setMinItems($data['minItems']);
        }

        if (isset($data['maxItems'])) {
            $type->setMaxItems($data['maxItems']);
        }

        if (isset($data['uniqueItems'])) {
            $type->setUniqueItems($data['uniqueItems']);
        }
    }

    protected function parseNumber(NumberType $type, array $data): void
    {
        if (isset($data['minimum'])) {
            $type->setMinimum($data['minimum']);
        }

        if (isset($data['exclusiveMinimum'])) {
            $type->setExclusiveMinimum((bool) $data['exclusiveMinimum']);
        }

        if (isset($data['maximum'])) {
            $type->setMaximum($data['maximum']);
        }

        if (isset($data['exclusiveMaximum'])) {
            $type->setExclusiveMaximum((bool) $data['exclusiveMaximum']);
        }

        if (isset($data['multipleOf'])) {
            $type->setMultipleOf($data['multipleOf']);
        }
    }

    protected function parseString(StringType $type, array $data): void
    {
        if (isset($data['pattern'])) {
            $type->setPattern($data['pattern']);
        }

        if (isset($data['minLength'])) {
            $type->setMinLength($data['minLength']);
        }

        if (isset($data['maxLength'])) {
            $type->setMaxLength($data['maxLength']);
        }
    }

    protected function parseIntersection(IntersectionType $type, array $data): void
    {
        if (isset($data['allOf']) && is_array($data['allOf'])) {
            $props = [];
            foreach ($data['allOf'] as $prop) {
                $props[] = $this->parseType($prop);
            }

            $type->setAllOf($props);
        }
    }

    protected function parseUnion(UnionType $type, array $data): void
    {
        if (isset($data['oneOf']) && is_array($data['oneOf'])) {
            $props = [];
            foreach ($data['oneOf'] as $prop) {
                $props[] = $this->parseType($prop);
            }

            $type->setOneOf($props);
        }
    }

    protected function parseReference(ReferenceType $type, array $data): void
    {
        $ref = $data['$ref'];
        if (empty($ref) || !is_string($ref)) {
            throw new \RuntimeException('Provided reference must be of type string');
        }

        // JSON Schema compatibility
        $ref = str_replace('#/definitions/', '', $ref);
        // OpenAPI compatibility
        $ref = str_replace('#/components/schemas/', '', $ref);

        $type->setRef($ref);

        $template = $data['$template'] ?? null;
        if (!empty($template) && is_array($template)) {
            $type->setTemplate($template);
        }
    }

    protected function parseGeneric(GenericType $type, array $data): void
    {
        $generic = $data['$generic'];
        if (empty($generic) || !is_string($generic)) {
            throw new \RuntimeException('Provided generic must be of type string');
        }

        $type->setGeneric($generic);
    }

    private function newPropertyType(array $data): TypeInterface
    {
        $type = $data['type'] ?? null;
        if ($type === TypeAbstract::TYPE_OBJECT) {
            if (isset($data['properties'])) {
                return TypeFactory::getStruct();
            } elseif (isset($data['additionalProperties'])) {
                return TypeFactory::getMap();
            }
        } elseif ($type === TypeAbstract::TYPE_ARRAY) {
            return TypeFactory::getArray();
        } elseif ($type === TypeAbstract::TYPE_STRING) {
            return TypeFactory::getString();
        } elseif ($type === TypeAbstract::TYPE_INTEGER) {
            return TypeFactory::getInteger();
        } elseif ($type === TypeAbstract::TYPE_NUMBER) {
            return TypeFactory::getNumber();
        } elseif ($type === TypeAbstract::TYPE_BOOLEAN) {
            return TypeFactory::getBoolean();
        } elseif ($type === TypeAbstract::TYPE_ANY) {
            return TypeFactory::getAny();
        } elseif (isset($data['allOf'])) {
            return TypeFactory::getIntersection();
        } elseif (isset($data['oneOf'])) {
            return TypeFactory::getUnion();
        } elseif (isset($data['$ref'])) {
            return TypeFactory::getReference();
        } elseif (isset($data['$generic'])) {
            return TypeFactory::getGeneric();
        }

        throw new \RuntimeException('Could not assign schema to a type');
    }

    /**
     * This method takes a look at the schema and adds missing properties
     *
     * @param array $data
     * @return array
     */
    private function transformBcLayer(array $data): array
    {
        if (isset($data['patternProperties']) && !isset($data['properties']) && !isset($data['additionalProperties'])) {
            // in this case we have a schema with only pattern properties
            if (count($data['patternProperties']) === 1) {
                $data['additionalProperties'] = reset($data['patternProperties']);
            } else {
                $data['additionalProperties'] = true;
            }
        }

        if (!isset($data['type'])) {
            if (isset($data['properties']) || isset($data['additionalProperties'])) {
                $data['type'] = 'object';
            } elseif (isset($data['items'])) {
                $data['type'] = 'array';
            } elseif (isset($data['pattern']) || isset($data['minLength']) || isset($data['maxLength'])) {
                $data['type'] = 'string';
            } elseif (isset($data['minimum']) || isset($data['maximum'])) {
                $data['type'] = 'number';
            }
        }

        return $data;
    }

    public static function fromFile($file, ImportResolver $resolver = null): SchemaInterface
    {
        if (!empty($file) && is_file($file)) {
            $parser = new self($resolver);

            return $parser->parse(file_get_contents($file));
        } else {
            throw new RuntimeException('Could not load json schema ' . $file);
        }
    }
}
