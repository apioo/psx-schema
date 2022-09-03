<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use PhpParser\Node;
use PhpParser\PrettyPrinter;
use PSX\Record\Record;
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Generator\Type\GeneratorInterface;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeInterface;
use PSX\Schema\TypeUtil;

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

    public function __construct(?string $namespace = null, array $mapping = [], int $indent = 4)
    {
        parent::__construct($namespace, $mapping, $indent);

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
        return new Type\Php($mapping);
    }

    protected function newNormalizer(): NormalizerInterface
    {
        return new Normalizer\Php();
    }

    protected function writeStruct(Code\Name $name, array $properties, ?string $extends, ?array $generics, StructType $origin): string
    {
        $tags = [];
        if ($generics !== null) {
            $tags['template'] = $generics;
        }

        $uses = [];

        $class = $this->factory->class($name->getClass());
        $class->implement('\\JsonSerializable');
        $class->setDocComment($this->buildComment($tags));

        $attributes = $this->getAttributesForType($origin, $uses);
        foreach ($attributes as $attribute) {
            $class->addAttribute($attribute);
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

            $serialize[$property->getName()->getProperty()] = $property->getName()->getRaw();

            $prop = $this->factory->property($property->getName()->getProperty());
            $prop->makeProtected();
            $type = $property->getType();
            if (!empty($type)) {
                if (str_contains($type, '|')) {
                    $prop->setType($type . '|null');
                } else {
                    if ($type === 'array') {
                        // in case we have an array we must add a var annotation to describe which type is inside the array
                        $prop->setDocComment($this->buildComment(['var' => $property->getDocType() . '|null']));
                    } elseif ($type === '\\' . Record::class) {
                        // in case we have an inline map we need to provide the inner type
                        $prop->setDocComment($this->buildComment(['var' => $property->getDocType() . '|null']));
                    }

                    if ($type !== 'mixed') {
                        $prop->setType(new Node\NullableType($type));
                    } else {
                        $prop->setType($type);
                    }
                }
            } else {
                $prop->setDocComment($this->buildComment(['var' => $property->getDocType() . '|null']));
            }

            $attributes = $this->getAttributesForType($property->getOrigin(), $uses, $realKey);
            foreach ($attributes as $attribute) {
                $prop->addAttribute($attribute);
            }

            $prop->setDefault($this->getDefault($property->getOrigin()));

            $class->addStmt($prop);

            $setter = $this->factory->method($property->getName()->getMethod(NormalizerInterface::METHOD_SETTER));

            $param = $this->factory->param($property->getName()->getArgument());
            $type = $property->getType();
            if (!empty($type)) {
                if (str_contains($type, '|')) {
                    $param->setType($type . '|null');
                } else {
                    if ($type === 'array') {
                        // in case we have an array we must add a var annotation to describe which type is inside the array
                        $setter->setDocComment($this->buildComment(['param' => $property->getDocType() . '|null $' . $property->getName()->getArgument()]));
                    }
                    if ($type !== 'mixed') {
                        $param->setType(new Node\NullableType($type));
                    } else {
                        $param->setType($type);
                    }
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

            $getter = $this->factory->method($property->getName()->getMethod(NormalizerInterface::METHOD_GETTER));
            if (!empty($type)) {
                if (str_contains($type, '|')) {
                    $getter->setReturnType($type . '|null');
                } else {
                    if ($type !== 'mixed') {
                        $getter->setReturnType(new Node\NullableType($type));
                    } else {
                        $getter->setReturnType($type);
                    }
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

        $this->buildJsonSerialize($class, $serialize, !empty($extends));

        return $this->prettyPrint($class, $uses);
    }

    protected function writeMap(Code\Name $name, string $type, MapType $origin): string
    {
        $subType = $this->generator->getDocType($origin->getAdditionalProperties());

        $uses = [];

        $class = $this->factory->class($name->getClass());
        $class->setDocComment($this->buildComment(['extends' => '\PSX\Record\Record<' . $subType . '>']));
        $class->extend('\\' . Record::class);

        $attributes = $this->getAttributesForType($origin, $uses);
        foreach ($attributes as $attribute) {
            $class->addAttribute($attribute);
        }

        return $this->prettyPrint($class, $uses);
    }

    protected function writeReference(Code\Name $name, string $type, ReferenceType $origin): string
    {
        $tags = [];
        $template = $origin->getTemplate();
        if (!empty($template)) {
            $types = [];
            foreach ($template as $value) {
                $types[] = $this->generator->getDocType((new ReferenceType())->setRef($value));
            }

            $tags['extends'] = $type . '<' . implode(', ', $types) . '>';
        }

        $uses = [];

        $class = $this->factory->class($name->getClass());
        $class->setDocComment($this->buildComment($tags));
        $class->extend($type);

        $attributes = $this->getAttributesForType($origin, $uses);
        foreach ($attributes as $attribute) {
            $class->addAttribute($attribute);
        }

        return $this->prettyPrint($class, $uses);
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
     * @param TypeInterface $type
     * @param array $uses
     * @param string|null $key
     * @return Node\Attribute[]
     */
    private function getAttributesForType(TypeInterface $type, array &$uses, ?string $key = null): array
    {
        $result = [];

        if ($key !== null) {
            $result[] = $this->newAttribute('Key', [$this->newScalar($key)], $uses);
        }

        if ($type instanceof TypeAbstract) {
            if ($type->getTitle() !== null) {
                $result[] = $this->newAttribute('Title', [$this->newScalar($type->getTitle())], $uses);
            }
            if ($type->getDescription() !== null) {
                $result[] = $this->newAttribute('Description', [$this->newScalar($type->getDescription())], $uses);
            }
            if ($type->isNullable() !== null) {
                $result[] = $this->newAttribute('Nullable', [$this->newScalar($type->isNullable())], $uses);
            }
            if ($type->isDeprecated() !== null) {
                $result[] = $this->newAttribute('Deprecated', [$this->newScalar($type->isDeprecated())], $uses);
            }
            if ($type->isReadonly() !== null) {
                $result[] = $this->newAttribute('Readonly', [$this->newScalar($type->isReadonly())], $uses);
            }
        }

        if ($type instanceof ScalarType) {
            if ($type->getEnum() !== null) {
                $result[] = $this->newAttribute('Enum', [$this->newArray($type->getEnum())], $uses);
            }
        }

        if ($type instanceof StructType) {
            if ($type->getRequired() !== null) {
                $result[] = $this->newAttribute('Required', [$this->newArray($type->getRequired())], $uses);
            }
        } elseif ($type instanceof MapType) {
            if ($type->getMinProperties() !== null) {
                $result[] = $this->newAttribute('MinProperties', [$this->newScalar($type->getMinProperties())], $uses);
            }
            if ($type->getMaxProperties() !== null) {
                $result[] = $this->newAttribute('MaxProperties', [$this->newScalar($type->getMaxProperties())], $uses);
            }
        } elseif ($type instanceof ArrayType) {
            if ($type->getMinItems() !== null) {
                $result[] = $this->newAttribute('MinItems', [$this->newScalar($type->getMinItems())], $uses);
            }
            if ($type->getMaxItems() !== null) {
                $result[] = $this->newAttribute('MaxItems', [$this->newScalar($type->getMaxItems())], $uses);
            }
        } elseif ($type instanceof NumberType) {
            if ($type->getMinimum() !== null) {
                $result[] = $this->newAttribute('Minimum', [$this->newScalar($type->getMinimum())], $uses);
            }
            if ($type->getMaximum() !== null) {
                $result[] = $this->newAttribute('Maximum', [$this->newScalar($type->getMaximum())], $uses);
            }
        } elseif ($type instanceof StringType) {
            if ($type->getPattern() !== null) {
                $result[] = $this->newAttribute('Pattern', [$this->newScalar($type->getPattern())], $uses);
            }
            if ($type->getMinLength() !== null) {
                $result[] = $this->newAttribute('MinLength', [$this->newScalar($type->getMinLength())], $uses);
            }
            if ($type->getMaxLength() !== null) {
                $result[] = $this->newAttribute('MaxLength', [$this->newScalar($type->getMaxLength())], $uses);
            }
        } elseif ($type instanceof UnionType && !empty($type->getPropertyName())) {
            $args = [$this->newScalar($type->getPropertyName())];
            if (!empty($type->getMapping())) {
                $args[] = $this->newArray($type->getMapping());
            }

            $result[] = $this->newAttribute('Discriminator', $args, $uses);
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

    private function newArray(array $values): Node
    {
        $result = [];
        foreach ($values as $index => $value) {
            $result[$index] = $this->newScalar($value);
        }
        return new Node\Expr\Array_($result);
    }

    private function getDefault(TypeInterface $type)
    {
        if (!$type instanceof ScalarType) {
            return null;
        }

        return $type->getConst();
    }

    private function prettyPrint($class, array $uses)
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

    private function buildJsonSerialize(Class_ $class, array $properties, bool $hasParent)
    {
        if (empty($properties)) {
            return;
        }

        $items = [];
        foreach ($properties as $name => $key) {
            $items[] = new Node\Expr\ArrayItem(new Node\Expr\PropertyFetch(new Node\Expr\Variable('this'), $name), new Node\Scalar\String_($key));
        }

        $closure = new Node\Expr\Closure([
            'static' => true,
            'params' => [new Node\Expr\Variable('value')],
            'returnType' => 'bool',
            'stmts' => [
                new Node\Stmt\Return_(new Node\Expr\BinaryOp\NotIdentical(new Node\Expr\Variable('value'), new Node\Expr\ConstFetch(new Node\Name('null'))))
            ],
        ]);

        $filter = new Node\Expr\FuncCall(new Node\Name('array_filter'), [
            new Node\Arg(new Node\Expr\Array_($items)),
            new Node\Arg($closure)
        ]);

        if ($hasParent) {
            $merge = new Node\Expr\FuncCall(new Node\Name('array_merge'), [
                new Node\Arg(new Node\Expr\Cast\Array_(new Node\Expr\StaticCall(new Node\Name('parent'), 'jsonSerialize'))),
                new Node\Arg($filter)
            ]);
        } else {
            $merge = $filter;
        }

        $serialize = $this->factory->method('jsonSerialize');
        $serialize->makePublic();
        $serialize->setReturnType('object');
        $serialize->addStmt(new Node\Stmt\Return_(new Node\Expr\Cast\Object_($merge)));

        $class->addStmt($serialize);
    }
}
