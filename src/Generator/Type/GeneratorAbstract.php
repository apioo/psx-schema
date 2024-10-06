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

namespace PSX\Schema\Generator\Type;

use PSX\Schema\ContentType;
use PSX\Schema\Format;
use PSX\Schema\Generator\Normalizer\NormalizerInterface;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\BooleanPropertyType;
use PSX\Schema\Type\GenericPropertyType;
use PSX\Schema\Type\IntegerPropertyType;
use PSX\Schema\Type\MapPropertyType;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\TypeUtil;

/**
 * GeneratorAbstract
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
abstract class GeneratorAbstract implements GeneratorInterface
{
    private array $mapping;
    private NormalizerInterface $normalizer;

    public function __construct(array $mapping, NormalizerInterface $normalizer)
    {
        $this->mapping = $mapping;
        $this->normalizer = $normalizer;
    }

    public function getType(PropertyTypeAbstract $type): string
    {
        if ($type instanceof StringPropertyType) {
            return $this->getStringType($type);
        } elseif ($type instanceof IntegerPropertyType) {
            return $this->getIntegerType($type);
        } elseif ($type instanceof NumberPropertyType) {
            return $this->getNumber();
        } elseif ($type instanceof BooleanPropertyType) {
            return $this->getBoolean();
        } elseif ($type instanceof ArrayPropertyType) {
            return $this->getArray($this->getType($type->getSchema()));
        } elseif ($type instanceof MapPropertyType) {
            return $this->getMap($this->getType($type->getSchema()));
        } elseif ($type instanceof ReferencePropertyType) {
            return $this->getReference($type->getTarget());
        } elseif ($type instanceof GenericPropertyType) {
            return $type->getName() ?? '';
        }

        return $this->getAny();
    }

    public function getDocType(PropertyTypeAbstract $type): string
    {
        return $this->getType($type);
    }

    public function getGenericType(array $types): string
    {
        return $this->getGeneric($types);
    }

    public function getContentType(ContentType $contentType, int $context): string
    {
        return $this->getString();
    }

    abstract protected function getString(): string;

    protected function getStringFormat(Format $format): string
    {
        return $this->getString();
    }

    abstract protected function getInteger(): string;

    protected function getIntegerFormat(Format $format): string
    {
        return $this->getNumber();
    }

    abstract protected function getNumber(): string;

    abstract protected function getBoolean(): string;

    abstract protected function getArray(string $type): string;

    abstract protected function getMap(string $type): string;

    abstract protected function getGroup(string $type): string;

    protected function getReference(string $ref): string
    {
        [$ns, $name] = TypeUtil::split($ref);

        if (!empty($ns) && isset($this->mapping[$ns])) {
            $name = $this->getNamespaced($this->mapping[$ns], $this->normalizer->class($name));
        } else {
            $name = $this->normalizer->class($name);
        }

        return $name;
    }

    abstract protected function getGeneric(array $types): string;

    abstract protected function getAny(): string;

    abstract protected function getNamespaced(string $namespace, string $name): string;

    private function getStringType(StringPropertyType $type): string
    {
        $format = $type->getFormat();
        if ($format !== null) {
            return $this->getStringFormat($format);
        } else {
            return $this->getString();
        }
    }

    private function getIntegerType(IntegerPropertyType $type): string
    {
        $format = $type->getFormat();
        if ($format !== null) {
            return $this->getIntegerFormat($format);
        } else {
            return $this->getInteger();
        }
    }
}
