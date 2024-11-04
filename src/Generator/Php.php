<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

use PhpParser\Builder\Class_;
use PhpParser\BuilderFactory;
use PhpParser\Comment\Doc;
use PhpParser\Node;
use PhpParser\PrettyPrinter;
use PSX\Record\ArrayList;
use PSX\Record\HashMap;
use PSX\Record\Record;
use PSX\Record\RecordableInterface;
use PSX\Record\RecordInterface;
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\Type\UnionType;

/**
 * Php
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Php extends CodeGeneratorAbstract
{
    private BuilderFactory $factory;
    private PrettyPrinter\Standard $printer;

    public function __construct(?Config $config = null)
    {
        parent::__construct($config);

        $this->factory = new BuilderFactory();
        $this->printer = new PrettyPrinter\Standard();
    }

    public function getFileName(string $file): string
    {
        return $file . '.php';
    }

    public function getFileContent(string $code): string
    {
        return '<?php' . "\n\n" . 'declare(strict_types = 1);' . "\n\n" . $code . "\n";
    }

    protected function newTypeGenerator(array $mapping): GeneratorInterface
    {
        return new Type\Php($mapping, $this->normalizer);
    }

    protected function newNormalizer(): NormalizerInterface
    {
        return new Normalizer\Php();
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, ?array $templates, StructDefinitionType $origin): string
    {
        $tags = [];
        if ($generics !== null) {
            $tags['template'] = $generics;
        }

        if (!empty($templates)) {
            $tags['extends'] = $extends . $this->generator->getGenericDefinition($templates);
        }

        $uses = [];

        $class = $this->factory->class($name->getClass());
        $class->implement('\\' . \JsonSerializable::class, '\\' . RecordableInterface::class);
        $class->setDocComment($this->buildComment($tags));

        $attributes = $this->getAttributesForDefinition($origin, $uses);
        foreach ($attributes as $attribute) {
            $class->addAttribute($attribute);
        }

        if ($origin->getBase() === true) {
            $class->makeAbstract();
        }

        if (!empty($extends)) {
            $class->extend($extends);
        }

        $serialize = [];

        foreach ($properties as $property) {
            /** @var Code\Property $property */
            $realKey = null;
            if ($property->getName()->getRaw() !== $property->getName()->getProperty()) {
                $realKey = $property->getName()->getRaw();
            }

            $serialize[$property->getName()->getProperty()] = $property;

            $prop = $this->factory->property($property->getName()->getProperty());
            $prop->makeProtected();
            $type = $property->getType();
            if (!empty($type)) {
                $docComment = $this->getDocComment($type, 'var', $property);
                if (!empty($docComment)) {
                    $prop->setDocComment($docComment);
                }

                if ($type !== 'mixed') {
                    $prop->setType('?' . $type);
                } else {
                    $prop->setType($type);
                }
            } else {
                $prop->setDocComment($this->buildComment(['var' => $property->getDocType() . '|null']));
            }

            $attributes = $this->getAttributesForProperty($property->getOrigin(), $uses, $realKey);
            foreach ($attributes as $attribute) {
                $prop->addAttribute($attribute);
            }

            $prop->setDefault(null);

            $class->addStmt($prop);

            $setter = $this->factory->method($property->getName()->getMethod(prefix: ['set']));

            $param = $this->factory->param($property->getName()->getArgument());
            $type = $property->getType();
            if (!empty($type)) {
                $docComment = $this->getDocComment($type, 'param', $property, $property->getName()->getArgument());
                if (!empty($docComment)) {
                    $setter->setDocComment($docComment);
                }

                if ($type !== 'mixed') {
                    $param->setType('?' . $type);
                } else {
                    $param->setType($type);
                }
            }

            $setter->setReturnType('void');
            $setter->makePublic();
            $setter->addParam($param);
            $setter->addStmt(new Node\Expr\Assign(
                new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $property->getName()->getProperty()),
                new Node\Expr\Variable($property->getName()->getArgument())
            ));
            $class->addStmt($setter);

            $getter = $this->factory->method($property->getName()->getMethod(prefix: ['get']));
            if (!empty($type)) {
                $docComment = $this->getDocComment($type, 'return', $property);
                if (!empty($docComment)) {
                    $getter->setDocComment($docComment);
                }

                if ($type !== 'mixed') {
                    $getter->setReturnType('?' . $type);
                } else {
                    $getter->setReturnType($type);
                }
            } else {
                $setter->setReturnType('void');
            }
            $getter->makePublic();
            $getter->addStmt(new Node\Stmt\Return_(
                new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $property->getName()->getProperty())
            ));
            $class->addStmt($getter);
        }

        if (!empty($serialize)) {
            $this->buildToRecord($class, $serialize, !empty($extends));
            $this->buildJsonSerialize($class);
        }

        return $this->prettyPrint($class, $uses);
    }

    protected function writeMap(Code\Name $name, string $type, MapDefinitionType $origin): string
    {
        $uses = [];

        $class = $this->factory->class($name->getClass());
        $class->setDocComment($this->buildComment(['extends' => '\\' . Record::class . '<' . $type . '>']));
        $class->extend('\\' . Record::class);

        $attributes = $this->getAttributesForDefinition($origin, $uses);
        foreach ($attributes as $attribute) {
            $class->addAttribute($attribute);
        }

        return $this->prettyPrint($class, $uses);
    }

    protected function writeArray(Code\Name $name, string $type, ArrayDefinitionType $origin): string
    {
        $uses = [];

        $class = $this->factory->class($name->getClass());
        $class->setDocComment($this->buildComment(['extends' => '\\ArrayIterator<' . $type . '>']));
        $class->extend('\\ArrayIterator');

        $attributes = $this->getAttributesForDefinition($origin, $uses);
        foreach ($attributes as $attribute) {
            $class->addAttribute($attribute);
        }

        return $this->prettyPrint($class, $uses);
    }

    private function getDocComment(string $type, string $tag, Code\Property $property, ?string $argumentName = null): ?string
    {
        $docType = $property->getDocType();
        if ($type === 'array') {
            // in case we have an array we must add a var annotation to describe which type is inside the array
            return $this->buildComment([$tag => $docType . '|null' . ($argumentName !== null ? ' $' . $argumentName : '')]);
        } elseif ($type === '\\' . Record::class) {
            // in case we have an inline map we need to provide the inner type
            return $this->buildComment([$tag => $property->getDocType() . '|null' . ($argumentName !== null ? ' $' . $argumentName : '')]);
        } elseif ($type === 'mixed' && $docType !== 'mixed') {
            return $this->buildComment([$tag => $docType . ($argumentName !== null ? ' $' . $argumentName : '')]);
        }

        return null;
    }

    private function buildComment(array $tags, ?string $comment = null): string
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

        if (empty($lines)) {
            return '';
        }

        return '/**' . "\n" . implode("\n", $lines) . "\n" . ' */';
    }

    /**
     * @return Node\Attribute[]
     */
    private function getAttributesForDefinition(DefinitionTypeAbstract $type, array &$uses): array
    {
        $result = [];

        $description = $type->getDescription();
        if ($description !== null) {
            $result[] = $this->newAttribute('Description', [$this->newScalar($description)], $uses);
        }

        $deprecated = $type->isDeprecated();
        if ($deprecated !== null) {
            $result[] = $this->newAttribute('Deprecated', [$this->newScalar($deprecated)], $uses);
        }

        if ($type instanceof StructDefinitionType) {
            $discriminator = $type->getDiscriminator();
            if ($discriminator !== null) {
                $result[] = $this->newAttribute('Discriminator', [$this->newScalar($discriminator)], $uses);
            }

            $mapping = $type->getMapping();
            if ($mapping !== null) {
                foreach ($mapping as $class => $value) {
                    $className = new Node\Expr\ClassConstFetch(new Node\Name($this->normalizer->class($class)), 'class');
                    $result[] = $this->newAttribute('DerivedType', [$className, $this->newScalar($value)], $uses);
                }
            }
        }

        return $result;
    }

    /**
     * @return Node\Attribute[]
     */
    private function getAttributesForProperty(PropertyTypeAbstract $type, array &$uses, ?string $key = null): array
    {
        $result = [];

        if ($key !== null) {
            $result[] = $this->newAttribute('Key', [$this->newScalar($key)], $uses);
        }

        if ($type->getDescription() !== null) {
            $result[] = $this->newAttribute('Description', [$this->newScalar($type->getDescription())], $uses);
        }
        if ($type->isDeprecated() !== null) {
            $result[] = $this->newAttribute('Deprecated', [$this->newScalar($type->isDeprecated())], $uses);
        }
        if ($type->isNullable() !== null) {
            $result[] = $this->newAttribute('Nullable', [$this->newScalar($type->isNullable())], $uses);
        }

        return $result;
    }

    private function newAttribute(string $attributeClass, array $args, array &$uses): Node\Attribute
    {
        if (!in_array($attributeClass, $uses)) {
            $uses[] = 'PSX\\Schema\\Attribute\\' . $attributeClass;
        }

        return new Node\Attribute(new Node\Name($attributeClass), array_map(function($arg){
            return new Node\Arg($arg);
        }, $args));
    }

    private function newScalar($value): Node
    {
        if (is_string($value)) {
            return new Node\Scalar\String_($value);
        } elseif (is_bool($value)) {
            return new Node\Expr\ConstFetch(new Node\Name($value ? 'true' : 'false'));
        } elseif (is_int($value)) {
            return new Node\Scalar\LNumber($value);
        } elseif (is_float($value)) {
            return new Node\Scalar\DNumber($value);
        } else {
            throw new \InvalidArgumentException('Provided a non scalar value');
        }
    }

    private function prettyPrint($class, array $uses): string
    {
        $uses = array_unique($uses);
        sort($uses);

        if ($this->namespace !== null) {
            $namespace = $this->factory->namespace($this->namespace);
            foreach ($uses as $use) {
                $namespace->addStmt(new Node\Stmt\Use_([new Node\Stmt\UseUse(new Node\Name($use))]));
            }
            $namespace->addStmt($class);

            return $this->printer->prettyPrint([$namespace->getNode()]);
        } else {
            $nodes = [];
            foreach ($uses as $use) {
                $nodes[] = new Node\Stmt\Use_([new Node\Stmt\UseUse(new Node\Name($use))]);
            }
            $nodes[] = $class->getNode();
            return $this->printer->prettyPrint($nodes);
        }
    }

    private function buildToRecord(\PhpParser\Builder\Class_ $class, array $properties, bool $hasParent): void
    {
        $stmts = [];
        if ($hasParent) {
            $stmts[] = new Node\Stmt\Expression(
                new Node\Expr\Assign(new Node\Expr\Variable('record'), new Node\Expr\StaticCall(new Node\Name('parent'), 'toRecord')),
                ['comments' => [new Doc('/** @var \PSX\Record\Record<mixed> $record */')]]
            );
        } else {
            $stmts[] = new Node\Stmt\Expression(
                new Node\Expr\Assign(new Node\Expr\Variable('record'), new Node\Expr\New_(new Node\Name\FullyQualified(Record::class))),
                ['comments' => [new Doc('/** @var \PSX\Record\Record<mixed> $record */')]]
            );
        }

        foreach ($properties as $name => $property) {
            /** @var Code\Property $property */
            $stmts[] = new Node\Expr\MethodCall(new Node\Expr\Variable('record'), new Node\Identifier('put'), [
                new Node\Arg(new Node\Scalar\String_($property->getName()->getRaw())),
                new Node\Arg(new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $name)),
            ]);
        }

        $stmts[] = new Node\Stmt\Return_(new Node\Expr\Variable('record'));

        $toRecord = $this->factory->method('toRecord');
        $toRecord->makePublic();
        $toRecord->setReturnType('\\' . RecordInterface::class);
        $toRecord->addStmts($stmts);

        $class->addStmt($toRecord);
    }

    private function buildJsonSerialize(Class_ $class): void
    {
        $toRecord = new Node\Expr\MethodCall(
            new Node\Expr\MethodCall(
                new Node\Expr\Variable('this'),
                new Node\Identifier('toRecord')
            ),
            new Node\Identifier('getAll')
        );

        $serialize = $this->factory->method('jsonSerialize');
        $serialize->makePublic();
        $serialize->setReturnType('object');
        $serialize->addStmt(new Node\Stmt\Return_(new Node\Expr\Cast\Object_($toRecord)));

        $class->addStmt($serialize);
    }
}
