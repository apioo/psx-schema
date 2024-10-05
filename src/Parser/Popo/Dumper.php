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

namespace PSX\Schema\Parser\Popo;

use PSX\DateTime\LocalDate;
use PSX\DateTime\LocalDateTime;
use PSX\DateTime\LocalTime;
use PSX\DateTime\Period;
use PSX\Record\Record;
use PSX\Record\RecordInterface;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\Format;
use PSX\Schema\Type\AnyPropertyType;
use PSX\Schema\Type\BooleanPropertyType;
use PSX\Schema\Type\CollectionPropertyType;
use PSX\Schema\Type\IntegerPropertyType;
use PSX\Schema\Type\MapDefinitionType;
use PSX\Schema\Type\NumberPropertyType;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\StringPropertyType;
use PSX\Schema\Type\StructDefinitionType;

/**
 * The dumper extracts all data from POPOs
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Dumper
{
    private ReflectionReader $reader;

    public function __construct()
    {
        $this->reader = new ReflectionReader();
    }

    public function dump(mixed $data): mixed
    {
        if (is_iterable($data)) {
            return $this->dumpIterable($data);
        } elseif ($data instanceof \DateTimeInterface) {
            return LocalDateTime::from($data)->toString();
        } elseif ($data instanceof \DateInterval) {
            return Period::from($data)->toString();
        } elseif ($data instanceof \JsonSerializable) {
            return Record::from($data->jsonSerialize());
        } elseif ($data instanceof \Stringable) {
            return (string) $data;
        } elseif (is_object($data)) {
            return $this->dumpObject($data, get_class($data));
        } elseif (is_resource($data)) {
            return stream_get_contents($data, -1, 0);
        } else {
            return $data;
        }
    }

    private function dumpObject(object $data, string $class): mixed
    {
        $type = $this->reader->buildDefinition(new \ReflectionClass($class));
        if ($type instanceof StructDefinitionType) {
            return $this->dumpStruct($data);
        } elseif ($type instanceof MapDefinitionType) {
            return $this->dumpMap($data, $type);
        } else {
            throw new ParserException('Could not determine object type');
        }
    }

    private function dumpStruct(object $data): RecordInterface
    {
        $reflection = new \ReflectionClass(get_class($data));
        $result = new Record();

        $properties = $this->reader->getProperties($reflection);
        foreach ($properties as $name => $property) {
            $getter = $this->reader->findGetter($property);
            if (!$getter instanceof \ReflectionMethod) {
                continue;
            }

            $value = $getter->invoke($data);

            $type = $this->reader->buildProperty($property);
            if ($type instanceof PropertyTypeAbstract) {
                $value = $this->dumpValue($value, $type);
            }

            if ($value !== null) {
                $result->put($name, $value);
            }
        }

        return $result;
    }

    private function dumpMap(object $data, MapDefinitionType $type): RecordInterface
    {
        if (!$data instanceof \Traversable) {
            throw new ParserException('Map must be traversable');
        }

        $result = new Record();
        foreach ($data as $key => $value) {
            $result->put($key, $this->dumpValue($value, $type->getSchema()));
        }

        return $result;
    }

    private function dumpCollection($data, CollectionPropertyType $type): array
    {
        if (!is_iterable($data)) {
            throw new ParserException('Array must be iterable');
        }

        $result = [];
        foreach ($data as $index => $value) {
            $result[] = $this->dumpValue($value, $type->getSchema());
        }

        return $result;
    }

    private function dumpValue(mixed $value, PropertyTypeAbstract $type)
    {
        if ($value === null) {
            return null;
        }

        if ($type instanceof CollectionPropertyType) {
            return $this->dumpCollection($value, $type);
        } elseif ($type instanceof BooleanPropertyType) {
            return (bool) $value;
        } elseif ($type instanceof IntegerPropertyType) {
            return (int) $value;
        } elseif ($type instanceof NumberPropertyType) {
            return (float) $value;
        } elseif ($type instanceof StringPropertyType) {
            $format = $type->getFormat();
            if ($format === Format::DATE) {
                if ($value instanceof LocalDate) {
                    return $value->toString();
                } elseif ($value instanceof \DateTimeInterface) {
                    return LocalDate::from($value)->toString();
                }
            } elseif ($format === Format::DATETIME) {
                if ($value instanceof LocalDateTime) {
                    return $value->toString();
                } elseif ($value instanceof \DateTimeInterface) {
                    return LocalDateTime::from($value)->toString();
                }
            } elseif ($format === Format::TIME) {
                if ($value instanceof LocalTime) {
                    return $value->toString();
                } elseif ($value instanceof \DateTimeInterface) {
                    return LocalTime::from($value)->toString();
                }
            } else {
                return (string) $value;
            }
        } elseif ($type instanceof ReferencePropertyType) {
            return $this->dumpReference($value, $type);
        } elseif ($type instanceof AnyPropertyType) {
            return $value;
        }

        return null;
    }

    private function dumpReference($data, ReferencePropertyType $type)
    {
        return $this->dumpObject($data, $type->getTarget());
    }

    private function dumpIterable(iterable $data): Record|array
    {
        $values = [];
        foreach ($data as $key => $value) {
            $values[$key] = $this->dump($value);
        }

        if (isset($values[0])) {
            return array_values($values);
        } else {
            return Record::fromArray($values);
        }
    }
}
