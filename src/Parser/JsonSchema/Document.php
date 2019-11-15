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

namespace PSX\Schema\Parser\JsonSchema;

use PSX\Json\Pointer;
use PSX\Schema\Property;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
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
use PSX\Schema\Type\UnionType;
use PSX\Uri\Uri;
use RuntimeException;

/**
 * Document
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Document
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var \PSX\Schema\Parser\JsonSchema\RefResolver
     */
    protected $resolver;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var \PSX\Uri\Uri
     */
    protected $source;

    /**
     * @var string
     */
    protected $definitionKey;

    /**
     * @var array
     */
    protected $definitions;

    /**
     * @var \PSX\Uri\Uri
     */
    protected $baseUri;

    /**
     * @var array
     */
    protected $template;

    /**
     * @var array
     */
    protected $objects;

    /**
     * @var array
     */
    protected $refs;

    /**
     * @param array $data
     * @param \PSX\Schema\Parser\JsonSchema\RefResolver $resolver
     * @param string|null $basePath
     * @param \PSX\Uri\Uri|null $source
     * @param string $definitionKey
     */
    public function __construct(array $data, RefResolver $resolver, $basePath = null, Uri $source = null, string $definitionKey = '/definitions')
    {
        $this->data     = $data;
        $this->resolver = $resolver;
        $this->basePath = $basePath;
        $this->source   = $source;
        $this->baseUri  = new Uri(isset($data['$id']) ? $data['$id'] : 'http://phpsx.org/2019/data#');
        $this->template = [];
        $this->objects  = [];
        $this->refs     = [];

        $this->definitionKey = $definitionKey;
        $definitions = $this->pointer($definitionKey);
        if (!empty($definitions)) {
            $this->definitions = array_keys($definitions);
        }
    }

    /**
     * The base path if the schema was fetched from a file
     *
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * Returns the source from where the document was obtained
     *
     * @return \PSX\Uri\Uri
     */
    public function getSource(): ?Uri
    {
        return $this->source;
    }

    /**
     * Returns whether the document was fetched from a remote or local source
     *
     * @return boolean
     */
    public function isRemote(): bool
    {
        return $this->source !== null && in_array($this->source->getScheme(), ['http', 'https']);
    }

    /**
     * @return \PSX\Uri\Uri
     */
    public function getBaseUri(): Uri
    {
        return $this->baseUri;
    }

    /**
     * @param string $pointer
     * @param string $name
     * @param integer $depth
     * @return \PSX\Schema\PropertyInterface
     */
    public function getProperty($pointer = null, $name = null, $depth = 0): PropertyInterface
    {
        if (empty($pointer)) {
            return $this->getRecProperty($this->data, $name, $depth);
        } else {
            // for schemas inside the definitions we use the key as title
            if (strpos($pointer, $this->definitionKey) === 0) {
                $name = substr($pointer, 14);
            } else {
                throw new \RuntimeException('Can only resolve local schemas, given ' . $pointer);
            }

            return $this->getRecProperty($this->pointer($pointer), $name, $depth);
        }
    }

    /**
     * Resolves a json pointer on the document and returns the fitting array
     * fragment. Throws an exception if the pointer could not be resolved
     *
     * @param string $pointer
     * @return array
     */
    public function pointer($pointer)
    {
        $pointer = new Pointer($pointer);
        $data    = $pointer->evaluate($this->data);

        if ($data !== null) {
            return $data;
        } else {
            throw new RuntimeException('Could not resolve pointer ' . $pointer->getPath());
        }
    }

    /**
     * @param \PSX\Uri\Uri $ref
     * @return boolean
     */
    public function canResolve(Uri $ref): bool
    {
        return $this->baseUri->getHost() == $ref->getHost() && $this->baseUri->getPath() == $ref->getPath();
    }

    protected function getRecProperty(array $data, $name, $depth)
    {
        $data     = $this->transformBcLayer($data);
        $property = $this->newPropertyType($data);

        if ($property instanceof PropertyType) {
            $this->parseCommon($property, $data, $name);
        }

        if ($property instanceof ScalarType) {
            $this->parseScalar($property, $data);
        }

        if ($property instanceof StructType) {
            $property = $this->parseStruct($property, $data, $depth);
        } elseif ($property instanceof MapType) {
            $property = $this->parseMap($property, $data, $depth);
        } elseif ($property instanceof ArrayType) {
            $this->parseArray($property, $data, $depth);
        } elseif ($property instanceof NumberType || $property instanceof IntegerType) {
            $this->parseNumber($property, $data);
        } elseif ($property instanceof StringType) {
            $this->parseString($property, $data);
        } elseif ($property instanceof IntersectionType) {
            $this->parseIntersection($property, $data, $depth);
        } elseif ($property instanceof UnionType) {
            $this->parseUnion($property, $data, $depth);
        } elseif ($property instanceof ReferenceType) {
            $property = $this->parseReference($property, $data, $name, $depth);
        } elseif ($property instanceof GenericType) {
            $property = $this->parseGeneric($property, $data);
        }

        // PSX specific attributes
        foreach ($data as $key => $value) {
            if (substr($key, 0, 6) === 'x-psx-') {
                $property->setAttribute(substr($key, 6), $value);
            }
        }

        return $property;
    }

    protected function parseCommon(PropertyType $property, array $data, ?string $name)
    {
        if (isset($data['title'])) {
            $property->setTitle($data['title']);
        } elseif ($name !== null) {
            $property->setTitle($name);
        }

        if (isset($data['description'])) {
            $property->setDescription($data['description']);
        }

        if (isset($data['nullable'])) {
            $property->setNullable($data['nullable']);
        }

        if (isset($data['deprecated'])) {
            $property->setDeprecated($data['deprecated']);
        }

        if (isset($data['readonly'])) {
            $property->setReadonly($data['readonly']);
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

    protected function parseStruct(StructType $property, array $data, $depth): PropertyInterface
    {
        if (isset($this->objects[$property->getTitle()])) {
            return $this->objects[$property->getTitle()];
        }

        $this->objects[$property->getTitle()] = $property;

        if (isset($data['properties']) && is_array($data['properties'])) {
            foreach ($data['properties'] as $name => $row) {
                if (is_array($row)) {
                    $prop = $this->getRecProperty($row, null, $depth + 1);

                    if ($prop !== null) {
                        $property->addProperty($name, $prop);
                    }
                }
            }
        }

        if (isset($data['required']) && is_array($data['required'])) {
            $property->setRequired($data['required']);
        }

        return $property;
    }

    protected function parseMap(MapType $property, array $data, $depth): PropertyInterface
    {
        if (isset($this->objects[$property->getTitle()])) {
            return $this->objects[$property->getTitle()];
        }

        $this->objects[$property->getTitle()] = $property;

        if (isset($data['additionalProperties'])) {
            if (is_bool($data['additionalProperties'])) {
                $property->setAdditionalProperties($data['additionalProperties']);
            } elseif (is_array($data['additionalProperties'])) {
                $property->setAdditionalProperties($this->getRecProperty($data['additionalProperties'], null, $depth + 1));
            }
        }

        if (isset($data['minProperties'])) {
            $property->setMinProperties($data['minProperties']);
        }

        if (isset($data['maxProperties'])) {
            $property->setMaxProperties($data['maxProperties']);
        }

        return $property;
    }

    protected function parseArray(ArrayType $property, array $data, $depth)
    {
        if (isset($data['items']) && is_array($data['items'])) {
            $prop = $this->getRecProperty($data['items'], null, $depth + 1);
            if ($prop !== null) {
                $property->setItems($prop);
            }
        }

        if (isset($data['minItems'])) {
            $property->setMinItems($data['minItems']);
        }

        if (isset($data['maxItems'])) {
            $property->setMaxItems($data['maxItems']);
        }

        if (isset($data['uniqueItems'])) {
            $property->setUniqueItems($data['uniqueItems']);
        }

        return $property;
    }

    protected function parseNumber(PropertyType $property, array $data)
    {
        if (isset($data['minimum'])) {
            $property->setMinimum($data['minimum']);
        }

        if (isset($data['exclusiveMinimum'])) {
            $property->setExclusiveMinimum((bool) $data['exclusiveMinimum']);
        }

        if (isset($data['maximum'])) {
            $property->setMaximum($data['maximum']);
        }

        if (isset($data['exclusiveMaximum'])) {
            $property->setExclusiveMaximum((bool) $data['exclusiveMaximum']);
        }

        if (isset($data['multipleOf'])) {
            $property->setMultipleOf($data['multipleOf']);
        }
    }

    protected function parseString(PropertyType $property, array $data)
    {
        if (isset($data['pattern'])) {
            $property->setPattern($data['pattern']);
        }

        if (isset($data['minLength'])) {
            $property->setMinLength($data['minLength']);
        }

        if (isset($data['maxLength'])) {
            $property->setMaxLength($data['maxLength']);
        }
    }

    protected function parseIntersection(PropertyType $property, array $data, $depth)
    {
        if (isset($data['allOf']) && is_array($data['allOf'])) {
            $props = [];
            foreach ($data['allOf'] as $prop) {
                $props[] = $this->getRecProperty($prop, null, $depth + 1);
            }

            $property->setAllOf($props);
        }
    }

    protected function parseUnion(PropertyType $property, array $data, $depth)
    {
        if (isset($data['oneOf']) && is_array($data['oneOf'])) {
            $props = [];
            foreach ($data['oneOf'] as $prop) {
                $props[] = $this->getRecProperty($prop, null, $depth + 1);
            }

            $property->setOneOf($props);
        }
    }

    protected function parseReference(ReferenceType $property, array $data, $name, $depth): PropertyInterface
    {
        $ref = $data['$ref'];

        array_push($this->refs, $ref);

        if ($this->inEndlessRecursion()) {
            throw new RecursionException('Endless recursion detected');
        }

        // in case the referenced template contains generics
        $template = $property->getTemplate();
        if (!empty($template)) {
            array_push($this->template, $template);
        }

        if (in_array($name, $this->definitions)) {
            // in this case we have a local reference
            $return = $this->getProperty($this->definitionKey . '/' . $name, $name, $depth);
        } else {
            // in this case we have a reference to a different schema
            $return = $this->resolver->resolve($this, new Uri($ref), $name, $depth);
        }

        if (!empty($template)) {
            array_pop($this->template);
        }

        array_pop($this->refs);

        return $return;
    }
    
    protected function parseGeneric(GenericType $property, array $data): PropertyInterface
    {
        $generic  = $data['$generic'];
        $template = $this->template[count($this->template) - 1] ?? null;

        if (empty($template)) {
            throw new RuntimeException('Can not resolve generic, no template provided');
        }

        if (!isset($template[$generic])) {
            throw new RuntimeException('Required generic ' . $generic . ' not available');
        }

        return $template[$data['$generic']];
    }

    private function newPropertyType(array $data): PropertyInterface
    {
        $type = $data['type'] ?? null;
        if ($type === PropertyType::TYPE_OBJECT) {
            if (isset($data['properties'])) {
                return Property::getStruct();
            } elseif (isset($data['additionalProperties'])) {
                return Property::getMap();
            }
        } elseif ($type === PropertyType::TYPE_ARRAY) {
            return Property::getArray();
        } elseif ($type === PropertyType::TYPE_STRING) {
            return Property::getString();
        } elseif ($type === PropertyType::TYPE_INTEGER) {
            return Property::getInteger();
        } elseif ($type === PropertyType::TYPE_NUMBER) {
            return Property::getNumber();
        } elseif ($type === PropertyType::TYPE_BOOLEAN) {
            return Property::getBoolean();
        } elseif (isset($data['allOf'])) {
            return Property::getIntersection();
        } elseif (isset($data['oneOf'])) {
            return Property::getUnion();
        } elseif (isset($data['$ref'])) {
            return Property::getReference();
        } elseif (isset($data['$generic'])) {
            return Property::getGeneric();
        }

        throw new \RuntimeException('Could not assign schema to a type');
    }
    
    private function inEndlessRecursion(): bool
    {
        $sequence = [];
        $count = 0;
        foreach ($this->refs as $ref) {
            if (!in_array($ref, $sequence)) {
                $sequence[] = $ref;
            } else {
                $sequence = [];
                $count++; 
            }
        }

        return $count >= 4;
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
}
