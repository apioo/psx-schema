<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Parser\Popo\Resolver;

use PSX\DateTime\Duration;
use PSX\DateTime\LocalDate;
use PSX\DateTime\LocalDateTime;
use PSX\DateTime\LocalTime;
use PSX\DateTime\Period;
use PSX\Record\Record;
use PSX\Schema\Format;
use PSX\Schema\Parser\Popo\ResolverInterface;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\TypeFactory;
use PSX\Schema\TypeInterface;
use PSX\Uri\Uri;

/**
 * Native
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Native implements ResolverInterface
{
    /**
     * @inheritDoc
     */
    public function resolveClass(\ReflectionClass $reflection): ?TypeInterface
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function resolveProperty(\ReflectionProperty $reflection): ?TypeInterface
    {
        if (!method_exists($reflection, 'getType')) {
            // for everything < PHP 7.4 
            return null;
        }

        $type = null;
        $reflectionType = $reflection->getType();
        if ($reflectionType instanceof \ReflectionUnionType) {
            $types = [];
            foreach ($reflectionType->getTypes() as $type) {
                $value = $this->getPropertyForType($type, $reflection);
                if ($value !== null) {
                    $types[] = $value;
                }
            }
            $type = TypeFactory::getUnion($types);
        }

        if ($reflectionType instanceof \ReflectionNamedType) {
            $type = $this->getPropertyForType($reflectionType, $reflection);
        }

        if ($type instanceof ScalarType) {
            if ($reflection->getDefaultValue() !== null) {
                $type->setConst($reflection->getDefaultValue());
            }
        }

        return $type;
    }

    private function getPropertyForType(\ReflectionNamedType $type, \ReflectionProperty $property): ?TypeInterface
    {
        $name = $type->getName();
        if ($name === 'string') {
            return TypeFactory::getString();
        } elseif ($name === 'float') {
            return TypeFactory::getNumber();
        } elseif ($name === 'int') {
            return TypeFactory::getInteger();
        } elseif ($name === 'bool') {
            return TypeFactory::getBoolean();
        } elseif ($name === 'array') {
            // in this case we have no way to determine the type inside the array in the future this is maybe possible
            return null;
        } elseif ($name === Record::class) {
            // in case we have a record we need to get the type from the doc
            return null;
        } elseif ($name === 'void') {
            return null;
        } elseif ($name === 'mixed') {
            return TypeFactory::getAny();
        } elseif ($name === 'self') {
            $class = $property->getDeclaringClass()->getName();
            return TypeFactory::getReference($class);
        } elseif ($name === LocalDate::class) {
            return TypeFactory::getString()->setFormat(Format::DATE);
        } elseif ($name === LocalDateTime::class || $name === \DateTime::class) {
            return TypeFactory::getString()->setFormat(Format::DATETIME);
        } elseif ($name === LocalTime::class) {
            return TypeFactory::getString()->setFormat(Format::TIME);
        } elseif ($name === Period::class || $name === \DateInterval::class) {
            return TypeFactory::getString()->setFormat(Format::PERIOD);
        } elseif ($name === Duration::class) {
            return TypeFactory::getString()->setFormat(Format::DURATION);
        } elseif ($name === Uri::class) {
            return TypeFactory::getString()->setFormat(Format::URI);
        } elseif (class_exists($name)) {
            return TypeFactory::getReference($name);
        }

        return null;
    }
}
