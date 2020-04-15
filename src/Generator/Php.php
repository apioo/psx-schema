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

namespace PSX\Schema\Generator;

use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\PrettyPrinter;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\TypeInterface;

/**
 * Php
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Php extends CodeGeneratorAbstract
{
    /**
     * @var \PhpParser\BuilderFactory
     */
    protected $factory;

    /**
     * @var \PhpParser\PrettyPrinter\Standard
     */
    protected $printer;

    /**
     * @inheritDoc
     */
    public function __construct(?string $namespace = null)
    {
        parent::__construct($namespace);

        $this->factory = new BuilderFactory();
        $this->printer = new PrettyPrinter\Standard();
    }

    protected function newTypeGenerator(): GeneratorInterface
    {
        return new Type\Php();
    }

    protected function writeStruct(string $name, array $properties, ?string $extends, ?string $comment, ?array $generics): string
    {
        $class = $this->factory->class($name);
        
        if (!empty($comment)) {
            $class->setDocComment('/**' . "\n" . ' * ' . $comment . "\n" . ' */');
        }

        if (!empty($extends)) {
            $class->extend($extends);
        }

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $prop = $class->addStmt($this->factory->property($name)
                ->makeProtected());

            $comment = $property->getComment();
            if (!empty($comment)) {
                $prop->setDocComment('/**' . "\n" . ' * ' . $comment . "\n" . ' */');
            }

            $param = $this->factory->param($name);

            $type = $property->getType();
            if (!empty($type)) {
                $param->setTypeHint(new Node\NullableType(($type)));
            }

            $setter = $this->factory->method('set' . ucfirst($name));
            $setter->makePublic();
            $setter->setDocComment('/**' . "\n" . ' * @param ' . $property->getDocType() . ' $' . $name . "\n" . ' */');
            $setter->addParam($param);
            $setter->addStmt(new Node\Expr\Assign(
                new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $name),
                new Node\Expr\Variable($name)
            ));
            $class->addStmt($setter);

            $getter = $this->factory->method('get' . ucfirst($name));
            if (!empty($type)) {
                $getter->setReturnType(new Node\NullableType($type));
            }
            $getter->makePublic();
            $getter->setDocComment('/**' . "\n" . ' * @return ' . $property->getDocType() . "\n" . ' */');
            $getter->addStmt(new Node\Stmt\Return_(
                new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $name)
            ));
            $class->addStmt($getter);
        }

        if ($this->namespace !== null) {
            $namespace = $this->factory->namespace($this->namespace);
            $namespace->addStmt($class);

            return $this->printer->prettyPrint([$namespace->getNode()]);
        } else {
            return $this->printer->prettyPrint([$class->getNode()]);
        }
    }

    protected function normalizeName(string $name)
    {
        if (preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $name)) {
            return $name;
        }

        $name = preg_replace('/[^a-zA-Z_\x7f-\xff]/', '_', $name);

        return $name;
    }
}
