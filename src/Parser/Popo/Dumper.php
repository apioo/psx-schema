<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\SimpleAnnotationReader;
use PSX\DateTime\Date;
use PSX\DateTime\DateTime;
use PSX\DateTime\Duration;
use PSX\DateTime\Time;
use PSX\Record\Record;
use PSX\Record\RecordInterface;
use PSX\Schema\Parser\Popo\Annotation;
use PSX\Schema\PropertyType;

/**
 * The dumper extracts all data from POPOs containing annotations so that the 
 * data can be serialized as json
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Dumper
{
    /**
     * @var \Doctrine\Common\Annotations\Reader
     */
    protected $reader;

    /**
     * @param \Doctrine\Common\Annotations\Reader $reader
     */
    public function __construct(Reader $reader = null)
    {
        if ($reader === null) {
            $reader = new SimpleAnnotationReader();
            $reader->addNamespace('PSX\\Schema\\Parser\\Popo\\Annotation');
        }

        $this->reader = $reader;
    }

    /**
     * @param object $object
     * @return mixed
     */
    public function dump($data)
    {
        if ($data instanceof RecordInterface || $data instanceof \stdClass || is_array($data)) {
            return $this->dumpTraversable($data);
        } elseif ($data instanceof \DateTime) {
            return DateTime::fromDateTime($data)->toString();
        } elseif ($data instanceof \DateInterval) {
            return Duration::fromDateInterval($data)->toString();
        } elseif (is_object($data)) {
            return $this->dumpObject($data);
        } elseif (is_resource($data)) {
            return stream_get_contents($data, -1, 0);
        } else {
            return $data;
        }
    }

    protected function dumpObject($data)
    {
        $reflection  = new \ReflectionClass(get_class($data));
        $annotations = $this->reader->getClassAnnotations($reflection);

        $patternProperties    = [];
        $additionalProperties = null;

        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\PatternProperties) {
                $patternProperties[$annotation->getPattern()] = $annotation->getProperty();
            } elseif ($annotation instanceof Annotation\AdditionalProperties) {
                $additionalProperties = $annotation->getAdditionalProperties();
            }
        }

        $properties = ObjectReader::getProperties($this->reader, $reflection);
        $result     = new Record($reflection->getShortName());

        foreach ($properties as $name => $property) {
            $getters = [
                'get' . ucfirst($property->getName()),
                'is' . ucfirst($property->getName())
            ];

            foreach ($getters as $getter) {
                if ($reflection->hasMethod($getter)) {
                    $annotations = $this->reader->getPropertyAnnotations($property);

                    $value = $reflection->getMethod($getter)->invoke($data);
                    $value = $this->dumpValue($value, $annotations);

                    if ($value !== null) {
                        $result->setProperty($name, $value);
                    }
                    break;
                }
            }
        }

        if (!empty($patternProperties)) {
            foreach ($patternProperties as $pattern => $property) {
                foreach ($data as $key => $value) {
                    if (preg_match('~' . $pattern . '~', $key)) {
                        $ref = $this->getRef($value, $property);
                        if ($ref !== null) {
                            $result->setProperty($key, $ref);
                        }
                    }
                }
            }
        }

        if ($additionalProperties === true) {
            foreach ($data as $key => $value) {
                if (!$result->hasProperty($key)) {
                    if ($value !== null) {
                        $result->setProperty($key, $this->dump($value));
                    }
                }
            }
        } elseif ($additionalProperties instanceof Annotation\Ref || $additionalProperties instanceof Annotation\Schema) {
            foreach ($data as $key => $value) {
                if (!$result->hasProperty($key)) {
                    $ref = $this->getRef($value, $additionalProperties);
                    if ($ref !== null) {
                        $result->setProperty($key, $ref);
                    }
                }
            }
        }

        return $result;
    }

    protected function dumpArray($data, $items)
    {
        $result = [];

        if ($items instanceof Annotation\Schema) {
            $annotations = $items->getAnnotations();
            foreach ($data as $value) {
                $result[] = $this->dumpValue($value, $annotations);
            }
        } elseif ($items instanceof Annotation\Ref) {
            foreach ($data as $value) {
                $result[] = $this->dump($value);
            }
        } elseif (is_array($items)) {
            foreach ($data as $index => $value) {
                if (isset($items[$index])) {
                    $result[] = $this->getRef($value, $items[$index]);
                }
            }
        }

        return $result;
    }

    protected function dumpValue($value, array $annotations)
    {
        if ($value === null) {
            return null;
        }

        $type   = null;
        $format = null;
        $items  = null;
        $ref    = null;
        $allOf  = $anyOf = $oneOf = null;
        foreach ($annotations as $annotation) {
            if ($annotation instanceof Annotation\Type) {
                $type = $annotation->getType();
            } elseif ($annotation instanceof Annotation\Format) {
                $format = $annotation->getFormat();
            } elseif ($annotation instanceof Annotation\Items) {
                $items = $annotation->getItems();
            } elseif ($annotation instanceof Annotation\Ref) {
                $ref = $annotation->getRef();
            } elseif ($annotation instanceof Annotation\AllOf) {
                $allOf = $annotation->getProperties();
            } elseif ($annotation instanceof Annotation\AnyOf) {
                $anyOf = $annotation->getProperties();
            } elseif ($annotation instanceof Annotation\OneOf) {
                $oneOf = $annotation->getProperties();
            }
        }

        if (!empty($ref)) {
            $type = PropertyType::TYPE_OBJECT;
        } elseif (!empty($items)) {
            $type = PropertyType::TYPE_ARRAY;
        }

        if ($type === PropertyType::TYPE_OBJECT) {
            return $this->dump($value);
        } elseif ($type === PropertyType::TYPE_ARRAY) {
            return $this->dumpArray($value, $items);
        } elseif ($type === PropertyType::TYPE_BOOLEAN) {
            return (bool) $value;
        } elseif ($type === PropertyType::TYPE_INTEGER) {
            return (int) $value;
        } elseif ($type === PropertyType::TYPE_NUMBER) {
            return (float) $value;
        } elseif ($type === PropertyType::TYPE_STRING) {
            if ($format === PropertyType::FORMAT_BINARY && is_resource($value)) {
                return base64_encode(stream_get_contents($value, -1, 0));
            } elseif ($format === PropertyType::FORMAT_DATETIME && $value instanceof \DateTime) {
                return DateTime::fromDateTime($value)->toString();
            } elseif ($format === PropertyType::FORMAT_DATE && $value instanceof \DateTime) {
                return Date::fromDateTime($value)->toString();
            } elseif ($format === PropertyType::FORMAT_TIME && $value instanceof \DateTime) {
                return Time::fromDateTime($value)->toString();
            } elseif ($format === PropertyType::FORMAT_DURATION && $value instanceof \DateInterval) {
                return Duration::fromDateInterval($value)->toString();
            } else {
                return (string) $value;
            }
        } elseif ($type === PropertyType::TYPE_NULL) {
            return null;
        }

        if (!empty($allOf)) {
            return $this->dump($value);
        } elseif (!empty($anyOf)) {
            return $this->dump($value);
        } elseif (!empty($oneOf)) {
            return $this->dump($value);
        }

        return $value;
    }

    protected function getRef($value, $annotation)
    {
        if ($annotation instanceof Annotation\Ref) {
            return $this->dump($value);
        } elseif ($annotation instanceof Annotation\Schema) {
            return $this->dumpValue($value, $annotation->getAnnotations());
        }

        return null;
    }

    protected function dumpTraversable($data)
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
