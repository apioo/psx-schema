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

namespace PSX\Schema\Parser\Popo;

use PSX\DateTime\Date;
use PSX\DateTime\DateTime;
use PSX\DateTime\Duration;
use PSX\DateTime\LocalDate;
use PSX\DateTime\LocalDateTime;
use PSX\DateTime\LocalTime;
use PSX\DateTime\Period;
use PSX\DateTime\Time;
use PSX\Record\Record;
use PSX\Record\RecordInterface;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\Parser\Popo;
use PSX\Schema\Type\AnyType;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ReferenceType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Type\UnionType;
use PSX\Schema\TypeInterface;

/**
 * The dumper extracts all data from POPOs
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Dumper
{
    private ResolverInterface $resolver;

    public function __construct()
    {
        $this->resolver = Popo::createDefaultResolver();
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

    private function dumpObject(mixed $data, string $class): mixed
    {
        $type = $this->resolver->resolveClass(new \ReflectionClass($class));
        if ($type instanceof StructType) {
            return $this->dumpStruct($data);
        } elseif ($type instanceof MapType) {
            return $this->dumpMap($data, $type);
        } else {
            throw new ParserException('Could not determine object type');
        }
    }

    private function dumpStruct($data): RecordInterface
    {
        if (!is_object($data)) {
            throw new ParserException('Struct must be an object');
        }

        $reflection = new \ReflectionClass(get_class($data));
        $result = new Record();

        $properties = ObjectReader::getProperties($reflection);
        foreach ($properties as $name => $property) {
            $getters = [
                'get' . ucfirst($property->getName()),
                'is' . ucfirst($property->getName())
            ];

            foreach ($getters as $getter) {
                if ($reflection->hasMethod($getter)) {
                    $value = $reflection->getMethod($getter)->invoke($data);

                    $type = $this->resolver->resolveProperty($property);
                    if ($type instanceof TypeInterface) {
                        $value = $this->dumpValue($value, $type);
                    }

                    if ($value !== null) {
                        $result->setProperty($name, $value);
                    }
                    break;
                }
            }
        }

        return $result;
    }

    private function dumpMap($data, MapType $type): RecordInterface
    {
        if (!$data instanceof \Traversable) {
            throw new ParserException('Map must be traversable');
        }

        $result = new Record();
        foreach ($data as $key => $value) {
            $result->setProperty($key, $this->dumpValue($value, $type->getAdditionalProperties()));
        }

        return $result;
    }

    private function dumpArray($data, ArrayType $type): array
    {
        if (!is_iterable($data)) {
            throw new ParserException('Array must be iterable');
        }

        $result = [];
        foreach ($data as $index => $value) {
            $result[] = $this->dumpValue($value, $type->getItems());
        }

        return $result;
    }

    private function dumpValue($value, TypeInterface $type)
    {
        if ($value === null) {
            return null;
        }

        if ($type instanceof StructType) {
            return $this->dumpStruct($value);
        } elseif ($type instanceof MapType) {
            return $this->dumpMap($value, $type);
        } elseif ($type instanceof ArrayType) {
            return $this->dumpArray($value, $type);
        } elseif ($type instanceof BooleanType) {
            return (bool) $value;
        } elseif ($type instanceof IntegerType) {
            return (int) $value;
        } elseif ($type instanceof NumberType) {
            return (float) $value;
        } elseif ($type instanceof StringType) {
            $format = $type->getFormat();
            if ($format === TypeAbstract::FORMAT_BINARY && is_resource($value)) {
                return base64_encode(stream_get_contents($value, -1, 0));
            } elseif ($format === TypeAbstract::FORMAT_DATETIME) {
                if ($value instanceof LocalDateTime) {
                    return $value->toString();
                } elseif ($value instanceof \DateTimeInterface) {
                    return LocalDateTime::from($value)->toString();
                }
            } elseif ($format === TypeAbstract::FORMAT_DATE) {
                if ($value instanceof LocalDate) {
                    return $value->toString();
                } elseif ($value instanceof \DateTimeInterface) {
                    return LocalDate::from($value)->toString();
                }
            } elseif ($format === TypeAbstract::FORMAT_TIME) {
                if ($value instanceof LocalTime) {
                    return $value->toString();
                } elseif ($value instanceof \DateTimeInterface) {
                    return LocalTime::from($value)->toString();
                }
            } elseif ($format === TypeAbstract::FORMAT_PERIOD) {
                if ($value instanceof Period) {
                    return $value->toString();
                } elseif ($value instanceof \DateInterval) {
                    return Period::from($value)->toString();
                }
            } elseif ($format === TypeAbstract::FORMAT_DURATION) {
                if ($value instanceof Duration) {
                    return $value->toString();
                } elseif ($value instanceof \DateInterval) {
                    return Duration::from($value)->toString();
                }
            } else {
                return (string) $value;
            }
        } elseif ($type instanceof IntersectionType) {
            return $this->dump($value);
        } elseif ($type instanceof UnionType) {
            return $this->dump($value);
        } elseif ($type instanceof ReferenceType) {
            return $this->dumpReference($value, $type);
        } elseif ($type instanceof AnyType) {
            return $value;
        }

        return null;
    }

    private function dumpReference($data, ReferenceType $type)
    {
        return $this->dumpObject($data, $type->getRef());
    }

    private function dumpIterable(iterable $data)
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
