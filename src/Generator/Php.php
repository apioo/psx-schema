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
use PSX\Record\Record;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
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

    protected function writeStruct(string $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $tags = [];
        if ($generics !== null) {
            $tags['template'] = $generics;
        }

        $class = $this->factory->class($name);
        $class->setDocComment($this->buildComment($tags, $this->getAnnotationsForType($origin)));

        if (!empty($extends)) {
            $class->extend($extends);
        }

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $realKey = null;
            if ($property->getName() !== $name) {
                $realKey = $property->getName();
            }

            $prop = $this->factory->property($name);
            $prop->makeProtected();
            $prop->setDocComment($this->buildComment(['var' => $property->getDocType()], $this->getAnnotationsForType($property->getOrigin(), $realKey)));

            $default = $this->getDefault($property->getOrigin());
            if ($default !== null) {
                $prop->setDefault($default);
            }

            $class->addStmt($prop);

            $param = $this->factory->param($name);

            $type = $property->getType();
            if (!empty($type)) {
                $param->setTypeHint(new Node\NullableType(($type)));
            }

            $setter = $this->factory->method('set' . ucfirst($name));
            $setter->makePublic();
            $setter->setDocComment($this->buildComment(['param' => $property->getDocType() . ' $' . $name]));
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
            $getter->setDocComment($this->buildComment(['return' => $property->getDocType()]));
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

    protected function writeMap(string $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getType($origin->getAdditionalProperties());

        $class = $this->factory->class($name);
        $class->setDocComment($this->buildComment(['extends' => 'ArrayAccess<string, ' . $subType . '>'], $this->getAnnotationsForType($origin)));
        $class->extend('\\' . Record::class);

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
    
    private function buildComment(array $tags, array $annotations = [], ?string $comment = null): string
    {
        $lines = [];
        if (!empty($comment)) {
            $lines[] = ' * ' . $comment;
        }

        foreach ($tags as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $val) {
                    $lines[] = ' * @' . $key . ' ' . trim($val);
                }
            } else {
                $lines[] = ' * @' . $key . ' ' . trim($value);
            }
        }

        foreach ($annotations as $key => $value) {
            if (is_bool($value)) {
                $lines[] = ' * @' . $key . '(' . ($value ? 'true' : 'false') . ')';
            } elseif (is_numeric($value)) {
                $lines[] = ' * @' . $key . '(' . $value . ')';
            } elseif (is_array($value)) {
                $lines[] = ' * @' . $key . '({' . $this->arrayList($value) . '})';
            } else {
                $lines[] = ' * @' . $key . '("' . $this->escapeString($value) . '")';
            }
        }

        if (empty($lines)) {
            return '';
        }

        return '/**' . "\n" . implode("\n", $lines) . "\n" . ' */';
    }

    private function getAnnotationsForType(TypeInterface $type, ?string $key = null): array
    {
        $result = [];

        if ($key !== null) {
            $result['Key'] = $key;
        }

        if ($type instanceof TypeAbstract) {
            $result['Title'] = $type->getTitle();
            $result['Description'] = $type->getDescription();
            $result['Nullable'] = $type->isNullable();
            $result['Deprecated'] = $type->isDeprecated();
            $result['Readonly'] = $type->isReadonly();
        }

        if ($type instanceof ScalarType) {
            $result['Enum'] = $type->getEnum();
        }

        if ($type instanceof StructType) {
            $result['Required'] = $type->getRequired();
        } elseif ($type instanceof MapType) {
            $result['MinProperties'] = $type->getMinProperties();
            $result['MaxProperties'] = $type->getMaxProperties();
        } elseif ($type instanceof ArrayType) {
            $result['MinItems'] = $type->getMinItems();
            $result['MaxItems'] = $type->getMaxItems();
            $result['UniqueItems'] = $type->isUniqueItems();
        } elseif ($type instanceof NumberType) {
            $result['Minimum'] = $type->getMinimum();
            $result['Maximum'] = $type->getMaximum();
            $result['ExclusiveMinimum'] = $type->getExclusiveMinimum();
            $result['ExclusiveMaximum'] = $type->getExclusiveMaximum();
            $result['MultipleOf'] = $type->getMultipleOf();
        } elseif ($type instanceof StringType) {
            $result['Pattern'] = $type->getPattern();
            $result['MinLength'] = $type->getMinLength();
            $result['MaxLength'] = $type->getMaxLength();
        }

        return array_filter($result, static function($value) {
            return $value !== null;
        });
    }

    private function arrayList(array $values)
    {
        $values = array_map(function ($value) {
            return '"' . $this->escapeString($value) . '"';
        }, $values);

        return implode(', ', $values);
    }

    private function escapeString($data)
    {
        $data = str_replace('"', '""', $data);

        return $data;
    }

    private function getDefault(TypeInterface $type)
    {
        if (!$type instanceof ScalarType) {
            return null;
        }

        return $type->getConst();
    }
}
