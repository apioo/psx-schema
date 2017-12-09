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

use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\PrettyPrinter;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
use PSX\Schema\SchemaInterface;
use RuntimeException;

/**
 * Php
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Php implements GeneratorInterface
{
    use GeneratorTrait;

    /**
     * @var \PhpParser\BuilderFactory
     */
    protected $factory;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var \PhpParser\PrettyPrinter\Standard
     */
    protected $printer;

    /**
     * @var \PhpParser\Builder\Namespace_
     */
    protected $root;

    /**
     * @var array
     */
    protected $generated;

    /**
     * @var array
     */
    protected $refs;

    public function __construct($namespace = null)
    {
        $this->factory   = new BuilderFactory();
        $this->namespace = $namespace === null ? 'PSX\Generation' : $namespace;
        $this->printer   = new PrettyPrinter\Standard();
    }

    public function generate(SchemaInterface $schema)
    {
        $this->root      = $this->factory->namespace($this->namespace);
        $this->generated = [];
        $this->refs      = [];

        $this->generateObject($schema->getDefinition());

        return $this->printer->prettyPrintFile([$this->root->getNode()]);
    }

    public function getNode()
    {
        return $this->root ? $this->root->getNode() : null;
    }

    protected function generateObject(PropertyInterface $type)
    {
        if ($this->getRealType($type) !== PropertyType::TYPE_OBJECT) {
            throw new RuntimeException('Property must be an object type');
        }

        $className = $type->getClass();
        if (empty($className)) {
            $className = $this->getIdentifierForProperty($type);
        } elseif (strpos($className, '\\') !== false) {
            // in case we an absolute class name remove the namespace
            $parts = explode('\\', $className);
            $className = array_pop($parts);
        }

        if (in_array($className, $this->generated)) {
            return;
        }

        $this->generated[] = $className;
        
        $class = $this->factory->class($className);
        $class->setDocComment($this->getDocCommentForClass($type));

        // if the type has additional or pattern properties extend from
        // ArrayObject
        $properties           = $type->getProperties();
        $patternProperties    = $type->getPatternProperties();
        $additionalProperties = $type->getAdditionalProperties();

        if (!empty($patternProperties) || !empty($additionalProperties)) {
            $class->extend('\ArrayObject');
        }

        if (!empty($properties)) {
            // add properties
            foreach ($properties as $name => $property) {
                $class->addStmt($this->factory->property($this->normalizeParameterName($name))
                    ->makeProtected()
                    ->setDocComment($this->getDocCommentForProperty($property, $name)));
            }

            // add getter setter
            foreach ($properties as $name => $property) {
                $name = $this->normalizeParameterName($name);
                $class->addStmt($this->factory->method('set' . ucfirst($name))
                    ->makePublic()
                    ->addParam($this->factory->param($name))
                    ->addStmt(new Node\Expr\Assign(
                        new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $name),
                        new Node\Expr\Variable($name)
                    ))
                );

                $class->addStmt($this->factory->method('get' . ucfirst($name))
                    ->makePublic()
                    ->addStmt(new Node\Stmt\Return_(
                        new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $name)
                    )));
            }
        }

        // generate other complex types
        foreach ($this->refs as $index => $prop) {
            $this->generateObject($prop);
            unset($this->refs[$index]);
        }

        $this->root->addStmt($class);
    }

    protected function normalizeParameterName($name)
    {
        if (preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $name)) {
            return $name;
        }

        $name = preg_replace('/[^a-zA-Z_\x7f-\xff]/', '_', $name);

        return $name;
    }
    
    protected function getDocCommentForClass(PropertyInterface $property)
    {
        $comment = '/**' . "\n";

        $title = $property->getTitle();
        if (!empty($title)) {
            $comment.= ' * @Title("' . $this->escapeString($title) . '")' . "\n";
        }

        $description = $property->getDescription();
        if (!empty($description)) {
            $comment.= ' * @Description("' . $this->escapeString($description) . '")' . "\n";
        }

        $patternProperties = $property->getPatternProperties();
        if (!empty($patternProperties)) {
            foreach ($patternProperties as $pattern => $prop) {
                $comment.= ' * @PatternProperties(pattern="' . $this->escapeString($pattern) . '", property=' . $this->getSubSchema($prop) . ')' . "\n";
            }
        }

        $additionalProperties = $property->getAdditionalProperties();
        if (is_bool($additionalProperties)) {
            $comment.= ' * @AdditionalProperties(' . ($additionalProperties ? 'true' : 'false') . ')' . "\n";
        } elseif ($additionalProperties instanceof PropertyInterface) {
            $comment.= ' * @AdditionalProperties(' . $this->getSubSchema($additionalProperties) . ')' . "\n";
        }

        $required = $property->getRequired();
        if (!empty($required)) {
            $comment.= ' * @Required({' . $this->arrayList($required) . '})' . "\n";
        }

        $minProperties = $property->getMinProperties();
        if ($minProperties !== null) {
            $comment.= ' * @MinProperties(' . $minProperties . ')' . "\n";
        }

        $maxProperties = $property->getMaxProperties();
        if ($maxProperties !== null) {
            $comment.= ' * @MaxProperties(' . $maxProperties . ')' . "\n";
        }

        $comment.= ' */';

        return $comment;
    }

    protected function getDocCommentForProperty(PropertyInterface $property, $name)
    {
        $comment = '/**' . "\n";
        $comment.= ' * @Key("' . $this->escapeString($name) . '")' . "\n";

        $type = $this->getRealType($property);
        if ($type === PropertyType::TYPE_OBJECT) {
            // @TODO in case the referenced schema is a oneOf schema use the
            // annotation @OneOf and dont create a new class

            $comment.= ' * ' . $this->getSubSchema($property) . "\n";
        } else {
            $title = $property->getTitle();
            if (!empty($title)) {
                $comment.= ' * @Title("' . $title . '")' . "\n";
            }

            $description = $property->getDescription();
            if (!empty($description)) {
                $comment.= ' * @Description("' . $this->escapeString($property->getDescription()) . '")' . "\n";
            }

            $enum = $property->getEnum();
            if (!empty($enum)) {
                $comment.= ' * @Enum({' . $this->arrayList($enum) . '})' . "\n";
            }

            $type = $property->getType();
            if (!empty($type)) {
                if (is_array($type)) {
                    $comment.= ' * @Type({' . $this->arrayList($type) . '})' . "\n";
                } else {
                    $comment.= ' * @Type("' . $type . '")' . "\n";
                }
            }

            $allOf = $property->getAllOf();
            $anyOf = $property->getAnyOf();
            $oneOf = $property->getOneOf();
            if (!empty($allOf)) {
                $result = [];
                foreach ($allOf as $type) {
                    $result[] = $this->getSubSchema($type);
                }

                $comment.= ' * @AllOf(' . implode(', ', $result) . ')' . "\n";
            } elseif (!empty($anyOf)) {
                $result = [];
                foreach ($anyOf as $type) {
                    $result[] = $this->getSubSchema($type);
                }

                $comment.= ' * @AnyOf(' . implode(', ', $result) . ')' . "\n";
            } elseif (!empty($oneOf)) {
                $result = [];
                foreach ($oneOf as $type) {
                    $result[] = $this->getSubSchema($type);
                }

                $comment.= ' * @OneOf(' . implode(', ', $result) . ')' . "\n";
            }

            $not = $property->getNot();
            if ($not instanceof PropertyInterface) {
                $comment.= ' * @Not(' . $this->getSubSchema($not) . ')' . "\n";
            }

            // number
            $maximum = $property->getMaximum();
            if ($maximum !== null) {
                $comment.= ' * @Maximum(' . $maximum . ')' . "\n";
            }

            $minimum = $property->getMinimum();
            if ($minimum !== null) {
                $comment.= ' * @Minimum(' . $minimum . ')' . "\n";
            }

            $exclusiveMaximum = $property->getExclusiveMaximum();
            if ($exclusiveMaximum !== null) {
                $comment.= ' * @ExclusiveMaximum(' . ($exclusiveMaximum ? 'true' : 'false') . ')' . "\n";
            }

            $exclusiveMinimum = $property->getExclusiveMinimum();
            if ($exclusiveMinimum !== null) {
                $comment.= ' * @ExclusiveMinimum(' . ($exclusiveMinimum ? 'true' : 'false') . ')' . "\n";
            }

            $multipleOf = $property->getMultipleOf();
            if ($multipleOf !== null) {
                $comment.= ' * @MultipleOf(' . $multipleOf . ')' . "\n";
            }

            // string
            $maxLength = $property->getMaxLength();
            if ($maxLength !== null) {
                $comment.= ' * @MaxLength(' . $maxLength . ')' . "\n";
            }

            $minLength = $property->getMinLength();
            if ($minLength !== null) {
                $comment.= ' * @MinLength(' . $minLength . ')' . "\n";
            }

            $pattern = $property->getPattern();
            if ($pattern !== null) {
                $comment.= ' * @Pattern("' . $pattern . '")' . "\n";
            }

            $format = $property->getFormat();
            if ($format !== null) {
                $comment.= ' * @Format("' . $format . '")' . "\n";
            }

            // array
            $items = $property->getItems();
            if ($items instanceof PropertyInterface) {
                $comment.= ' * @Items(' . $this->getSubSchema($items) . ')' . "\n";
            }

            $additionalItems = $property->getAdditionalItems();
            if ($additionalItems instanceof PropertyInterface) {
                $comment.= ' * @AdditionalItems(' . $this->getSubSchema($items) . ')' . "\n";
            } elseif (is_bool($additionalItems)) {
                $comment.= ' * @AdditionalItems(' . ($additionalItems ? 'true' : 'false') . ')' . "\n";
            }

            $uniqueItems = $property->getUniqueItems();
            if ($uniqueItems !== null) {
                $comment.= ' * @UniqueItems(' . ($uniqueItems ? 'true' : 'false') . ')' . "\n";
            }

            $maxItems = $property->getMaxItems();
            if ($maxItems !== null) {
                $comment.= ' * @MaxItems(' . $maxItems . ')' . "\n";
            }

            $minItems = $property->getMinItems();
            if ($minItems !== null) {
                $comment.= ' * @MinItems(' . $minItems . ')' . "\n";
            }
        }

        $comment.= ' */';

        return $comment;
    }

    protected function arrayList(array $values)
    {
        $values = array_map(function ($value) {
            return '"' . $this->escapeString($value) . '"';
        }, $values);

        return implode(', ', $values);
    }

    protected function escapeString($data)
    {
        $data = str_replace('"', '""', $data);

        return $data;
    }

    protected function getSubSchema(PropertyInterface $property)
    {
        $type = $this->getRealType($property);
        if ($type === PropertyType::TYPE_OBJECT) {
            $className = $this->getIdentifierForProperty($property);
            if (!in_array($className, $this->generated)) {
                $this->refs[] = $property;
            }

            return '@Ref("' . $this->namespace . '\\' . $className . '")';
        } else {
            return '@Schema(' . $this->getInlineSchemaForProperty($property) . ')';
        }
    }

    protected function getInlineSchemaForProperty(PropertyInterface $property)
    {
        $data   = $property->toArray();
        $result = [];

        foreach ($data as $key => $value) {
            switch ($key) {
                // string
                case 'type':
                case 'title':
                case 'description':
                case 'pattern':
                case 'format':
                    $result[] = $key . '="' . $this->escapeString($value) . '"';
                    break;

                // boolean
                case 'exclusiveMaximum':
                case 'exclusiveMinimum':
                case 'uniqueItems':
                    $result[] = $key . '=' . ($value ? 'true' : 'false');
                    break;

                // integer
                case 'maximum':
                case 'minimum':
                case 'multipleOf':
                case 'maxLength':
                case 'minLength':
                case 'maxItems':
                case 'minItems':
                    $result[] = $key . '=' . intval($value);
                    break;
                
                // array
                case 'enum':
                    $values = array_map(function ($value) {
                        return '"' . $this->escapeString($value) . '"';
                    }, $value);

                    $result[] = $key . '=' . '{' . implode(', ', $values) . '}';
                    break;
                
                
                case 'allOf':
                case 'anyOf':
                case 'oneOf':
                    $values = [];
                    foreach ($value as $row) {
                        $values[] = $this->getSubSchema($row);
                    }

                    $result[] = $key . '=' . '{' . implode(', ', $values) . '}';
                    break;
                
                case 'not':
                    $result[] = $key . '=' . $this->getSubSchema($value);
                    break;

                // array
                case 'items':
                    $result[] = $key . '=' . $this->getSubSchema($value);
                    break;
                
                case 'additionalItems':
                    if (is_bool($value)) {
                        $result[] = $key . '=' . ($value ? 'true' : 'false');
                    } elseif ($value instanceof PropertyInterface) {
                        $result[] = $key . '=' . $this->getSubSchema($value);
                    }
                    break;
            }
        }

        return implode(', ', $result);
    }
}
