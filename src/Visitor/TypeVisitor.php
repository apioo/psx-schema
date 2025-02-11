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

namespace PSX\Schema\Visitor;

use PSX\DateTime\LocalDate;
use PSX\DateTime\LocalDateTime;
use PSX\DateTime\LocalTime;
use PSX\Record\Record;
use PSX\Schema\Exception\TraverserException;
use PSX\Schema\Type\ArrayDefinitionType;
use PSX\Schema\Type\ArrayTypeInterface;
use PSX\Schema\Type\BooleanPropertyType;
use PSX\Schema\Type\DefinitionTypeAbstract;
use PSX\Schema\Type\IntegerPropertyType;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\MapTypeInterface;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\Validation\ValidatorInterface;
use PSX\Schema\VisitorInterface;

/**
 * TypeVisitor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TypeVisitor implements VisitorInterface
{
    private ?ValidatorInterface $validator;

    public function __construct(?ValidatorInterface $validator = null)
    {
        $this->validator = $validator;
    }

    public function visitStruct(\stdClass $data, StructDefinitionType $type, string $path): object
    {
        $discriminator = $type->getDiscriminator();
        $mapping = $type->getMapping();

        if (!empty($discriminator)) {
            $type = $data->{$discriminator} ?? throw new TraverserException('Configured discriminator property is not available');
            $className = $mapping[$type] ?? throw new TraverserException('Provided discriminator type is not available');
        } else {
            $className = $type->getAttribute(DefinitionTypeAbstract::ATTR_CLASS);
        }

        if (!empty($className) && class_exists($className)) {
            $class = new \ReflectionClass($className);
            $record = $class->newInstance();

            $mapping = $type->getAttribute(DefinitionTypeAbstract::ATTR_MAPPING) ?: [];
            foreach ($data as $key => $value) {
                try {
                    $name = $mapping[$key] ?? $key;

                    $method = $class->getMethod('set' . ucfirst($name));
                    $method->invokeArgs($record, [$value]);
                } catch (\ReflectionException $e) {
                    // method does not exist
                }
            }
        } else {
            $record = Record::fromObject($data);
        }

        if ($this->validator !== null) {
            $this->validator->validate($path, $record);
        }

        return $record;
    }

    public function visitMap(\stdClass $data, MapTypeInterface $type, string $path): object
    {
        $className = $type instanceof MapDefinitionType ? $type->getAttribute(DefinitionTypeAbstract::ATTR_CLASS) : null;
        if (!empty($className)) {
            $class = new \ReflectionClass($className);
            $record = $class->newInstance();

            if (!$record instanceof \ArrayAccess) {
                throw new \RuntimeException('Map implementation must implement the ArrayAccess interface');
            }

            foreach ($data as $key => $value) {
                $record->offsetSet($key, $value);
            }
        } else {
            $record = Record::fromObject($data);
        }

        if ($this->validator !== null) {
            $this->validator->validate($path, $record);
        }

        return $record;
    }

    public function visitArray(array $data, ArrayTypeInterface $type, string $path): mixed
    {
        $className = $type instanceof ArrayDefinitionType ? $type->getAttribute(DefinitionTypeAbstract::ATTR_CLASS) : null;
        if (!empty($className)) {
            $class = new \ReflectionClass($className);
            $record = $class->newInstance();

            if (!$record instanceof \ArrayIterator) {
                throw new \RuntimeException('Array implementation must extend the ArrayIterator class');
            }

            foreach ($data as $value) {
                $record->append($value);
            }
        } else {
            $record = $data;
        }

        if ($this->validator !== null) {
            $this->validator->validate($path, $record);
        }

        return $record;
    }

    public function visitBoolean(bool $data, BooleanPropertyType $type, string $path): bool
    {
        if ($this->validator !== null) {
            $this->validator->validate($path, $data);
        }

        return $data;
    }

    public function visitNumber(float|int $data, NumberPropertyType $type, string $path): float|int
    {
        if ($this->validator !== null) {
            $this->validator->validate($path, $data);
        }

        return $data;
    }

    public function visitInteger(int $data, IntegerPropertyType $type, string $path): int
    {
        if ($this->validator !== null) {
            $this->validator->validate($path, $data);
        }

        return $data;
    }

    public function visitString(string $data, StringPropertyType $type, string $path): string
    {
        if ($this->validator !== null) {
            $this->validator->validate($path, $data);
        }

        return $data;
    }

    public function visitDate(string $data, StringPropertyType $type, string $path): LocalDate
    {
        $result = LocalDate::parse($data);

        if ($this->validator !== null) {
            $this->validator->validate($path, $result);
        }

        return $result;
    }

    public function visitDateTime(string $data, StringPropertyType $type, string $path): LocalDateTime
    {
        $result = LocalDateTime::parse($data);

        if ($this->validator !== null) {
            $this->validator->validate($path, $result);
        }

        return $result;
    }

    public function visitTime(string $data, StringPropertyType $type, string $path): LocalTime
    {
        $result = LocalTime::parse($data);

        if ($this->validator !== null) {
            $this->validator->validate($path, $result);
        }

        return $result;
    }
}
