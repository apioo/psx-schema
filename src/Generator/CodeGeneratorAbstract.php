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

use PSX\Schema\Generator\Type\TypeInterface;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
use PSX\Schema\SchemaInterface;

/**
 * CodeGeneratorAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
abstract class CodeGeneratorAbstract implements GeneratorInterface, TypeAwareInterface
{
    use GeneratorTrait;

    /**
     * @var TypeInterface
     */
    protected $type;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $indent;

    /**
     * @var array
     */
    private $generated;

    /**
     * @var array
     */
    private $objects;

    /**
     * @var Code\Chunks
     */
    private $chunks;

    /**
     * @param string|null $namespace
     */
    public function __construct(?string $namespace = null)
    {
        $this->type      = $this->newType();
        $this->namespace = $namespace;
        $this->indent    = str_repeat(' ', 4);;
    }

    /**
     * @inheritDoc
     */
    public function generate(SchemaInterface $schema)
    {
        $this->generated = [];
        $this->objects   = [];
        $this->chunks    = new Code\Chunks($this->namespace);

        $this->generateObject($schema->getDefinition());

        return $this->chunks;
    }

    /**
     * @inheritDoc
     */
    public function getType(PropertyInterface $property): string
    {
        return $this->type->getType($property);
    }

    /**
     * @inheritDoc
     */
    public function getDocType(PropertyInterface $property): string
    {
        return $this->type->getDocType($property);
    }

    protected function generateObject(PropertyInterface $type)
    {
        $className = $type->getAttribute(PropertyType::ATTR_CLASS);
        if (empty($className)) {
            $className = $this->getIdentifierForProperty($type);
        } elseif (strpos($className, '\\') !== false) {
            // in case we an absolute class name remove the namespace
            $parts = explode('\\', $className);
            $className = array_pop($parts);
        }

        if (in_array($className, $this->generated)) {
            return '';
        }

        $this->generated[] = $className;

        if ($type->getProperties()) {
            // struct type
            $properties = $type->getProperties();
            $required   = $type->getRequired() ?: [];
            $mapping    = $type->getAttribute(PropertyType::ATTR_MAPPING);

            $props = [];
            foreach ($properties as $name => $property) {
                /** @var PropertyInterface $property */

                $key = isset($mapping[$name]) ? $mapping[$name] : $name;
                $key = $this->normalizeName($key);

                $props[$key] = new Code\Property(
                    $name,
                    $this->type->getType($property),
                    $this->type->getDocType($property),
                    in_array($name, $required),
                    $property
                );

                $this->objects = array_merge($this->objects, $this->getSubSchemas($property));
            }

            $code = $this->writeStruct(new Code\Struct($className, $props, $type));
        } elseif ($type->getAdditionalProperties()) {
            // map type
            $additional = $type->getAdditionalProperties();

            if ($additional === true) {
                $map = new Code\Map($className, $this->type->getType(new PropertyType()), $type);
            } elseif ($additional instanceof PropertyInterface) {
                $map = new Code\Map($className, $this->type->getType($additional), $type);
            } else {
                throw new \RuntimeException('Additional property must be a schema');
            }

            $code = $this->writeMap($map);
        } else {
            throw new \RuntimeException('Schema must be an object type');
        }

        $this->chunks->append($className, $code);

        foreach ($this->objects as $property) {
            $this->generateObject($property);
        }
    }

    /**
     * @param string $name
     * @return string
     */
    protected function normalizeName(string $name)
    {
        $name = str_replace(['-', '_'], ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);

        return preg_replace('/[^A-Za-z0-9]/', '', lcfirst($name));
    }

    /**
     * @return TypeInterface
     */
    abstract protected function newType(): TypeInterface;

    /**
     * @param Code\Struct $struct
     * @return string
     */
    abstract protected function writeStruct(Code\Struct $struct): string;

    /**
     * @param Code\Map $map
     * @return string
     */
    abstract protected function writeMap(Code\Map $map): string;
}
