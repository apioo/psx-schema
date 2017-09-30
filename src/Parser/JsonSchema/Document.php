<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
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
     * @var \PSX\Uri\Uri
     */
    protected $baseUri;

    /**
     * @param array $data
     * @param \PSX\Schema\Parser\JsonSchema\RefResolver $resolver
     * @param string|null $basePath
     * @param \PSX\Uri\Uri|null $source
     */
    public function __construct(array $data, RefResolver $resolver, $basePath = null, Uri $source = null)
    {
        $this->data     = $data;
        $this->resolver = $resolver;
        $this->basePath = $basePath;
        $this->source   = $source;
        $this->baseUri  = new Uri(isset($data['id']) ? $data['id'] : 'http://phpsx.org/2015/data#');
    }

    /**
     * The base path if the schema was fetched from a file
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Returns the source from where the document was obtained
     *
     * @return \PSX\Uri\Uri
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Returns whether the document was fetched from a remote or local source
     *
     * @return boolean
     */
    public function isRemote()
    {
        return $this->source !== null && in_array($this->source->getScheme(), ['http', 'https']);
    }

    /**
     * @return \PSX\Uri\Uri
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @param string $pointer
     * @param string $name
     * @param integer $depth
     * @param \PSX\Schema\PropertyInterface $property
     * @return \PSX\Schema\PropertyInterface
     */
    public function getProperty($pointer = null, $name = null, $depth = 0, PropertyInterface $property = null)
    {
        if ($pointer === null) {
            return $this->getRecProperty($this->data, $name, $depth, $property);
        } else {
            return $this->getRecProperty($this->pointer($pointer), $name, $depth, $property);
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
    public function canResolve(Uri $ref)
    {
        return $this->baseUri->getHost() == $ref->getHost() && $this->baseUri->getPath() == $ref->getPath();
    }

    protected function getRecProperty(array $data, $name, $depth, PropertyInterface $property = null)
    {
        if (isset($data['$ref'])) {
            return $this->resolver->resolve($this, new Uri($data['$ref']), $name, $depth, $property);
        }

        if (isset($data['extends'])) {
            $part = $this->resolver->extract($this, new Uri($data['extends']));
            $data = array_replace_recursive($data, $part);
        }

        if ($property === null) {
            $property = new PropertyType();
        }

        if (isset($data['type'])) {
            $property->setType($data['type']);
        }

        if (isset($data['title'])) {
            $property->setTitle($data['title']);
        }

        if (isset($data['description'])) {
            $property->setDescription($data['description']);
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

        $this->parseObjectType($property, $data, $depth);
        $this->parseArrayType($property, $data, $depth);
        $this->parseScalar($property, $data);
        $this->parseCombinations($property, $data, $depth);
        $this->parseNot($property, $data, $depth);

        return $property;
    }

    protected function parseObjectType(PropertyType $property, array $data, $depth)
    {
        if (isset($data['properties']) && is_array($data['properties'])) {
            foreach ($data['properties'] as $name => $row) {
                if (is_array($row)) {
                    $prop = $this->getRecProperty($row, $name, $depth + 1);

                    if ($prop !== null) {
                        $property->addProperty($name, $prop);
                    }
                }
            }
        }

        if (isset($data['patternProperties']) && is_array($data['patternProperties'])) {
            foreach ($data['patternProperties'] as $pattern => $prototype) {
                if (is_array($prototype)) {
                    $property->addPatternProperty($pattern, $this->getRecProperty($prototype, null, $depth + 1));
                }
            }
        }

        if (isset($data['additionalProperties'])) {
            if (is_bool($data['additionalProperties'])) {
                $property->setAdditionalProperties($data['additionalProperties']);
            } elseif (is_array($data['additionalProperties'])) {
                $property->setAdditionalProperties($this->getRecProperty($data['additionalProperties'], null, $depth + 1));
            }
        }

        if (isset($data['required']) && is_array($data['required'])) {
            $property->setRequired($data['required']);
        }

        if (isset($data['minProperties'])) {
            $property->setMinProperties($data['minProperties']);
        }

        if (isset($data['maxProperties'])) {
            $property->setMaxProperties($data['maxProperties']);
        }

        if (isset($data['dependencies']) && is_array($data['dependencies'])) {
            $result = [];
            foreach ($data['dependencies'] as $name => $row) {
                if (isset($row[0])) {
                    $result[$name] = $row;
                } else {
                    $result[$name] = $this->getRecProperty($row, null, $depth + 1);
                }
            }

            $property->setDependencies($result);
        }

        // PSX specific contains the fitting class for this object
        if (isset($data['class'])) {
            $property->setClass($data['class']);
        }

        return $property;
    }

    protected function parseArrayType(PropertyType $property, array $data, $depth)
    {
        if (isset($data['items']) && is_array($data['items'])) {
            if (isset($data['items'][0])) {
                // tuple validation
                $properties = [];
                foreach ($data['items'] as $item) {
                    $prop = $this->getRecProperty($item, null, $depth + 1);
                    if ($prop !== null) {
                        $properties[] = $prop;
                    }
                }

                $property->setItems($properties);
            } else {
                $prop = $this->getRecProperty($data['items'], null, $depth + 1);
                if ($prop !== null) {
                    $property->setItems($prop);
                }
            }
        }

        if (isset($data['additionalItems'])) {
            if (is_bool($data['additionalItems'])) {
                $property->setAdditionalItems($data['additionalItems']);
            } elseif (is_array($data['additionalItems'])) {
                $property->setAdditionalItems($this->getRecProperty($data['additionalItems'], null, $depth + 1));
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

    protected function parseScalar(PropertyType $property, array $data)
    {
        // number
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

        // string
        if (isset($data['pattern'])) {
            $property->setPattern($data['pattern']);
        }

        if (isset($data['format'])) {
            $property->setFormat($data['format']);
        }

        if (isset($data['minLength'])) {
            $property->setMinLength($data['minLength']);
        }

        if (isset($data['maxLength'])) {
            $property->setMaxLength($data['maxLength']);
        }
    }

    protected function parseCombinations(PropertyType $property, array $data, $depth)
    {
        if (isset($data['allOf']) && is_array($data['allOf'])) {
            $props = [];
            foreach ($data['allOf'] as $prop) {
                $props[] = $this->getRecProperty($prop, null, $depth + 1);
            }

            $property->setAllOf($props);
        } elseif (isset($data['anyOf']) && is_array($data['anyOf'])) {
            $props = [];
            foreach ($data['anyOf'] as $prop) {
                $props[] = $this->getRecProperty($prop, null, $depth + 1);
            }

            $property->setAnyOf($props);
        } elseif (isset($data['oneOf']) && is_array($data['oneOf'])) {
            $props = [];
            foreach ($data['oneOf'] as $prop) {
                $props[] = $this->getRecProperty($prop, null, $depth + 1);
            }

            $property->setOneOf($props);
        }
    }

    protected function parseNot(PropertyType $property, array $data, $depth)
    {
        if (isset($data['not']) && is_array($data['not'])) {
            $property->setNot($this->getRecProperty($data['not'], null, $depth + 1));
        }
    }
}
