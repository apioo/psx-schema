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

        $properties = $type->getProperties();

        // add properties
        foreach ($properties as $property) {
            $class->addStmt($this->factory->property($property->getName())
                ->makePublic()
                ->setDocComment($this->getDocCommentForProperty($property)));
        }

        // add getter setter
        foreach ($properties as $property) {
            $class->addStmt($this->factory->method('set' . ucfirst($property->getName()))
                ->makePublic()
                ->addParam($this->factory->param($property->getName()))
                ->addStmt(new Node\Expr\Assign(
                    new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $property->getName()),
                    new Node\Expr\Variable($property->getName())
                ))
            );

            $class->addStmt($this->factory->method('get' . ucfirst($property->getName()))
                ->makePublic()
                ->addStmt(new Node\Stmt\Return_(
                    new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $property->getName())
                )));
        }

        // generate other complex types
        foreach ($properties as $property) {
            if ($property instanceof Property\ArrayType || $property instanceof Property\AnyType) {
                if ($property->getPrototype() instanceof Property\ComplexType) {
                    $this->generateRootElement($property->getPrototype());
                }
            } elseif ($property instanceof Property\ChoiceType) {
                $properties = $property->getProperties();
                foreach ($properties as $prop) {
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

        $comment.= ' * @Title("' . $this->escapeString($property->getName()) . '")' . "\n";

        $description = $property->getDescription();
        if (!empty($description)) {
            $comment.= ' * @Description("' . $this->escapeString($description) . '")' . "\n";
        }

        $comment.= ' * @AdditionalProperties(' . ($property->hasAdditionalProperties() ? 'true' : 'false') . ')' . "\n";
        $comment.= ' */';

        return $comment;
    }

    protected function getDocCommentForProperty(PropertyInterface $property)
    {
        $type = $this->getPropertyType($property);

        $comment = '/**' . "\n";
        $comment.= ' * @Key("' . $this->escapeString($property->getName()) . '")' . "\n";
        $comment.= ' * @Type("' . $type . '")' . "\n";
        
        if ($property->isRequired()) {
            $comment.= ' * @Required' . "\n";
        }

        $description = $property->getDescription();
        if (!empty($description)) {
            $comment.= ' * @Description("' . $this->escapeString($property->getDescription()) . '")' . "\n";
        }

        if ($property instanceof Property\ArrayType) {
            $minLength = $property->getMinLength();
            if ($minLength) {
                $comment.= ' * @MinLength(' . $minLength . ')' . "\n";
            }

            $maxLength = $property->getMaxLength();
            if ($maxLength) {
                $comment.= ' * @MaxLength(' . $maxLength . ')' . "\n";
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
        } elseif ($property instanceof Property\AnyType) {
            $type = 'any';

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

            $properties = $property->getProperties();
            $subTypes = [];
            foreach ($properties as $name => $prop) {
                $subTypes[] = $name . '=' . $this->getPropertyType($prop);
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
