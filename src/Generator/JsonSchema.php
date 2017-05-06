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

namespace PSX\Schema\Generator;

use PSX\Json\Parser;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
use PSX\Schema\SchemaInterface;

/**
 * JsonSchema
 *
 * @see     http://tools.ietf.org/html/draft-zyp-json-schema-04
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class JsonSchema implements GeneratorInterface
{
    use GeneratorTrait;
    
    const SCHEMA = 'http://json-schema.org/draft-04/schema#';

    protected $targetNamespace;
    protected $definitions;
    protected $root;

    public function __construct($targetNamespace = null)
    {
        $this->targetNamespace = $targetNamespace ?: 'urn:schema.phpsx.org#';
    }

    public function generate(SchemaInterface $schema)
    {
        return Parser::encode($this->toArray($schema), JSON_PRETTY_PRINT);
    }

    /**
     * Returns the jsonschema as array
     *
     * @param \PSX\Schema\SchemaInterface $schema
     * @return array
     */
    public function toArray(SchemaInterface $schema)
    {
        return $this->generateRootElement($schema->getDefinition());
    }

    protected function generateRootElement(PropertyInterface $type)
    {
        $this->root        = $this->getIdentifierForProperty($type);
        $this->definitions = [];

        $object = $this->generateObjectType($type);

        $result = [
            '$schema' => self::SCHEMA,
            'id'      => $this->targetNamespace,
        ];

        if (!empty($this->definitions)) {
            $result['definitions'] = $this->definitions;
        }

        $result = array_merge($result, $object);

        return $result;
    }

    protected function generateObjectType(PropertyInterface $type)
    {
        $result = $type->toArray();

        if (isset($result['properties'])) {
            foreach ($result['properties'] as $index => $property) {
                $result['properties'][$index] = $this->getRef($property);
            }
        }

        if (isset($result['patternProperties'])) {
            foreach ($result['patternProperties'] as $pattern => $property) {
                $result['patternProperties'][$pattern] = $this->getRef($property);
            }
        }

        if (isset($result['additionalProperties']) && $result['additionalProperties'] instanceof PropertyInterface) {
            $result['additionalProperties'] = $this->getRef($result['additionalProperties']);
        }

        if (isset($result['items'])) {
            if ($result['items'] instanceof PropertyInterface) {
                $result['items'] = $this->getRef($result['items']);
            } elseif (is_array($result['items'])) {
                foreach ($result['items'] as $index => $property) {
                    $result['items'][$index] = $this->getRef($property);
                }
            }
        }

        if (isset($result['additionalItems']) && $result['additionalItems'] instanceof PropertyInterface) {
            $result['additionalItems'] = $this->getRef($result['additionalItems']);
        }

        if (isset($result['allOf'])) {
            foreach ($result['allOf'] as $index => $property) {
                $result['allOf'][$index] = $this->getRef($property);
            }
        }

        if (isset($result['anyOf'])) {
            foreach ($result['anyOf'] as $index => $property) {
                $result['anyOf'][$index] = $this->getRef($property);
            }
        }

        if (isset($result['oneOf'])) {
            foreach ($result['oneOf'] as $index => $property) {
                $result['oneOf'][$index] = $this->getRef($property);
            }
        }

        $class = $type->getClass();
        if (!empty($class)) {
            $result['class'] = $class;
        }

        if (empty($result)) {
            return new \stdClass();
        } else {
            return $result;
        }
    }

    protected function getRef(PropertyInterface $property)
    {
        $type = $this->getRealType($property);
        $key  = $this->getIdentifierForProperty($property);

        if ($type === PropertyType::TYPE_OBJECT) {
            if ($this->root === $key) {
                return ['$ref' => '#'];
            }

            if (!isset($this->definitions[$key])) {
                $this->definitions[$key] = true;
                $this->definitions[$key] = $this->generateObjectType($property);
            }

            return ['$ref' => '#/definitions/' . $key];
        } else {
            return $this->generateObjectType($property);
        }
    }
}
