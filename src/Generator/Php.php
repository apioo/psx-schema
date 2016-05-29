<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

use PSX\Data\Processor;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\Property;
use PSX\Schema\PropertyAbstract;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertySimpleAbstract;
use PSX\Schema\SchemaInterface;
use PhpParser\BuilderFactory;
use PhpParser\PrettyPrinter;
use PhpParser\Node;
use RuntimeException;

/**
 * Php
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Php implements GeneratorInterface
{
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
    
    public function __construct($namespace = null)
    {
        $this->factory   = new BuilderFactory();
        $this->namespace = $namespace === null ? 'PSX\Generation' : $namespace;
        $this->printer   = new PrettyPrinter\Standard();
    }

    public function generate(SchemaInterface $schema)
    {
        $this->root      = $this->factory->namespace($this->namespace);
        $this->generated = array();

        $this->generateRootElement($schema->getDefinition());

        return $this->printer->prettyPrintFile([$this->root->getNode()]);
    }

    protected function generateRootElement(Property\ComplexType $type)
    {
        $className = $this->getClassNameForProperty($type);
        
        if (in_array($className, $this->generated)) {
            return;
        }

        $this->generated[] = $className;
        
        $class = $this->factory->class($className);
        $class->setDocComment($this->getDocCommentForClass($type));

        // if the type has additional or pattern properties extend from
        // ArrayObject
        $patternProperties    = $type->getPatternProperties();
        $additionalProperties = $type->getAdditionalProperties();

        if (!empty($patternProperties) || !empty($additionalProperties)) {
            $class->extend('\ArrayObject');
        }

        // add properties
        $properties = $type->getProperties();

        foreach ($properties as $name => $property) {
            $class->addStmt($this->factory->property($name)
                ->makePublic()
                ->setDocComment($this->getDocCommentForProperty($property, $name)));
        }

        // add getter setter
        foreach ($properties as $name => $property) {
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

        // generate other complex types
        foreach ($properties as $property) {
            if ($property instanceof Property\ArrayType) {
                if ($property->getPrototype() instanceof Property\ComplexType) {
                    $this->generateRootElement($property->getPrototype());
                }
            } elseif ($property instanceof Property\ChoiceType) {
                $choices = $property->getChoices();
                foreach ($choices as $prop) {
                    if ($prop instanceof Property\ComplexType) {
                        $this->generateRootElement($prop);
                    }
                }
            } elseif ($property instanceof Property\ComplexType) {
                $this->generateRootElement($property);
            }
        }

        $this->root->addStmt($class);
    }

    protected function getDocCommentForClass(Property\ComplexType $property)
    {
        $comment = '/**' . "\n";

        $title = $property->getName();
        if (!empty($title)) {
            $comment.= ' * @Title("' . $this->escapeString($title) . '")' . "\n";
        }

        $description = $property->getDescription();
        if (!empty($description)) {
            $comment.= ' * @Description("' . $this->escapeString($description) . '")' . "\n";
        }

        $additionalProperties = $property->getAdditionalProperties();
        if (is_bool($additionalProperties)) {
            $comment.= ' * @AdditionalProperties(' . ($additionalProperties ? 'true' : 'false') . ')' . "\n";
        } elseif ($additionalProperties instanceof PropertyInterface) {
            $type = $this->getPropertyType($additionalProperties);
            $comment.= ' * @AdditionalProperties("' . $this->escapeString($type) . '")' . "\n";
        }

        $patternProperties = $property->getPatternProperties();
        if (!empty($patternProperties)) {
            foreach ($patternProperties as $pattern => $prop) {
                $type = $this->getPropertyType($prop);
                $comment.= ' * @PatternProperty(pattern="' . $this->escapeString($pattern) . '", type="' . $this->escapeString($type) . '")' . "\n";
            }
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
        $type = $this->getPropertyType($property);

        $comment = '/**' . "\n";
        $comment.= ' * @Key("' . $this->escapeString($name) . '")' . "\n";
        $comment.= ' * @Type("' . $type . '")' . "\n";

        if ($property->isRequired()) {
            $comment.= ' * @Required' . "\n";
        }

        $description = $property->getDescription();
        if (!empty($description)) {
            $comment.= ' * @Description("' . $this->escapeString($property->getDescription()) . '")' . "\n";
        }

        if ($property instanceof Property\ComplexType) {
            $minProperties = $property->getMinProperties();
            if ($minProperties > 0) {
                $comment.= ' * @MinProperties(' . $minProperties . ')' . "\n";
            }

            $maxProperties = $property->getMaxProperties();
            if ($maxProperties > 0) {
                $comment.= ' * @MaxProperties(' . $maxProperties . ')' . "\n";
            }
        } elseif ($property instanceof Property\ArrayType) {
            $minItems = $property->getMinItems();
            if ($minItems > 0) {
                $comment.= ' * @MinItems(' . $minItems . ')' . "\n";
            }

            $maxItems = $property->getMaxItems();
            if ($maxItems > 0) {
                $comment.= ' * @MaxItems(' . $maxItems . ')' . "\n";
            }
        } elseif ($property instanceof Property\DecimalType) {
            $min = $property->getMin();
            if ($min) {
                $comment.= ' * @Minimum(' . $min . ')' . "\n";
            }

            $max = $property->getMax();
            if ($max) {
                $comment.= ' * @Maximum(' . $max . ')' . "\n";
            }
        } elseif ($property instanceof Property\StringType) {
            $minLength = $property->getMinLength();
            if ($minLength) {
                $comment.= ' * @MinLength(' . $minLength . ')' . "\n";
            }

            $maxLength = $property->getMaxLength();
            if ($maxLength) {
                $comment.= ' * @MaxLength(' . $maxLength . ')' . "\n";
            }
        }

        if ($property instanceof PropertySimpleAbstract) {
            $pattern = $property->getPattern();
            if ($pattern) {
                $comment.= ' * @Pattern("' . $pattern . '")' . "\n";
            }

            $enumeration = $property->getEnumeration();
            if ($enumeration) {
                $comment.= ' * @Enum({"' . implode('", "', $enumeration) . '"})' . "\n";
            }
        }

        $comment.= ' */';

        return $comment;
    }

    protected function getPropertyType(PropertyInterface $property)
    {
        if ($property instanceof Property\ArrayType) {
            $type = 'array';

            $reference = $property->getReference();
            if (!empty($reference)) {
                $type.= '(' . $reference . ')';
            }

            $type.= '<' . $this->getPropertyType($property->getPrototype()) . '>';

            return $type;
        } elseif ($property instanceof Property\ChoiceType) {
            $type = 'choice';

            $reference = $property->getReference();
            if (!empty($reference)) {
                $type .= '(' . $reference . ')';
            }

            $choices  = $property->getChoices();
            $subTypes = [];
            foreach ($choices as $prop) {
                $subTypes[] = $this->getPropertyType($prop);
            }

            $type .= '<' . implode(',', $subTypes) . '>';

            return $type;
        } elseif ($property instanceof Property\ComplexType) {
            return $this->namespace . '\\' . $this->getClassNameForProperty($property);
        } elseif ($property instanceof PropertyAbstract) {
            return $property->getTypeName();
        } else {
            throw new RuntimeException('Invalid property implementation');
        }
    }

    protected function getClassNameForProperty(Property\ComplexType $property)
    {
        return ucfirst($property->getTypeName() . substr($property->getId(), 0, 8));
    }
    
    protected function escapeString($data)
    {
        return $data;
    }
}
