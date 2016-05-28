<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

namespace PSX\Schema;

use PSX\Record\RecordInterface;
use PSX\Schema\Visitor\IncomingVisitor;
use Traversable;
use ReflectionClass;
use RuntimeException;

/**
 * SchemaTraverser
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaTraverser
{
    const MAX_RECURSION_DEPTH = 6;

    protected $pathStack;
    protected $recCount;

    /**
     * Traverses through the data based on the provided schema and calls the
     * visitor methods. The type tells whether we going through incoming or
     * outgoing data. The traverser is for incoming data stricter then for
     * outgoing data
     *
     * @param mixed $data
     * @param \PSX\Schema\SchemaInterface $schema
     * @param \PSX\Schema\VisitorInterface $visitor
     * @return mixed
     */
    public function traverse($data, SchemaInterface $schema, VisitorInterface $visitor)
    {
        $this->pathStack = array();
        $this->recCount  = 0;

        return $this->recTraverse($data, $schema->getDefinition(), $visitor);
    }

    protected function recTraverse($data, PropertyInterface $property, VisitorInterface $visitor)
    {
        if ($property instanceof Property\RecursionType) {
            $data = (array) $data;
            if (!empty($data)) {
                if ($this->recCount > self::MAX_RECURSION_DEPTH) {
                    throw new ValidationException($this->getCurrentPath() . ' max recursion depth reached');
                }

                $this->recCount++;

                $complex = $this->recTraverse($data, $property->getOrigin(), $visitor);

                $this->recCount--;

                return $complex;
            }
        } elseif ($property instanceof Property\ArrayType) {
            if (!is_array($data) && !$data instanceof Traversable) {
                throw new ValidationException($this->getCurrentPath() . ' must be an array');
            }

            $result = array();
            $index  = 0;

            foreach ($data as $value) {
                array_push($this->pathStack, $index);

                $result[] = $this->recTraverse($value, $property->getPrototype(), $visitor);

                array_pop($this->pathStack);

                $index++;
            }

            return $visitor->visitArray($result, $property, $this->getCurrentPath());
        } elseif ($property instanceof Property\BinaryType) {
            return $visitor->visitBinary($data, $property, $this->getCurrentPath());
        } elseif ($property instanceof Property\BooleanType) {
            return $visitor->visitBoolean($data, $property, $this->getCurrentPath());
        } elseif ($property instanceof Property\ChoiceType) {
            $choiceType = $property->getChoice($data, $this->getCurrentPath());

            if (!$choiceType instanceof Property\ComplexType) {
                $types = array_keys($property->getChoiceTypes());

                throw new ValidationException($this->getCurrentPath() . ' must be one of the following types (' . implode(', ', $types) . ')');
            }

            return $this->recTraverse($data, $choiceType, $visitor);
        } elseif ($property instanceof Property\ComplexType) {
            if (!is_array($data) && !is_object($data)) {
                throw new ValidationException($this->getCurrentPath() . ' must be an object');
            }

            $data   = $this->normalizeToArray($data);
            $result = new \stdClass();
            $keys   = [];

            foreach ($property as $key => $prop) {
                array_push($this->pathStack, $key);

                if (isset($data[$key])) {
                    $result->{$key} = $this->recTraverse($data[$key], $prop, $visitor);
                    $keys[] = $key;
                } elseif ($prop->isRequired()) {
                    throw new ValidationException($this->getCurrentPath() . ' is required');
                }

                array_pop($this->pathStack);
            }

            $patternProperties = $property->getPatternProperties();
            if (!empty($patternProperties)) {
                foreach ($patternProperties as $pattern => $prop) {
                    // check whether we have keys which match this pattern and 
                    // are not already a fixed property

                    foreach ($data as $key => $value) {
                        if (preg_match('~' . $pattern . '~', $key) && !in_array($key, $keys)) {
                            array_push($this->pathStack, $key);

                            $result->{$key} = $this->recTraverse($data[$key], $prop, $visitor);
                            $keys[] = $key;

                            array_pop($this->pathStack);
                        }
                    }
                }
            }

            $remainingKeys = array_diff(array_keys($data), $keys);
            if (!empty($remainingKeys)) {
                $additionalProperties = $property->getAdditionalProperties();

                if (is_bool($additionalProperties)) {
                    if ($additionalProperties === true) {
                        foreach ($remainingKeys as $key) {
                            $result->{$key} = $data[$key];
                        }
                    } elseif ($visitor instanceof IncomingVisitor) {
                        throw new ValidationException($this->getCurrentPath() . ' property "' . implode(', ', $remainingKeys) . '" does not exist');
                    }
                } elseif ($additionalProperties instanceof PropertyInterface) {
                    foreach ($remainingKeys as $key) {
                        array_push($this->pathStack, $key);

                        $result->{$key} = $this->recTraverse($data[$key], $additionalProperties, $visitor);

                        array_pop($this->pathStack);
                    }
                }
            }

            return $visitor->visitComplex($result, $property, $this->getCurrentPath());
        } elseif ($property instanceof Property\DateTimeType) {
            return $visitor->visitDateTime($data, $property, $this->getCurrentPath());
        } elseif ($property instanceof Property\DateType) {
            return $visitor->visitDate($data, $property, $this->getCurrentPath());
        } elseif ($property instanceof Property\DurationType) {
            return $visitor->visitDuration($data, $property, $this->getCurrentPath());
        } elseif ($property instanceof Property\FloatType) {
            return $visitor->visitFloat($data, $property, $this->getCurrentPath());
        } elseif ($property instanceof Property\IntegerType) {
            return $visitor->visitInteger($data, $property, $this->getCurrentPath());
        } elseif ($property instanceof Property\TimeType) {
            return $visitor->visitTime($data, $property, $this->getCurrentPath());
        } elseif ($property instanceof Property\UriType) {
            return $visitor->visitUri($data, $property, $this->getCurrentPath());
        } elseif ($property instanceof Property\StringType) {
            return $visitor->visitString($data, $property, $this->getCurrentPath());
        }
    }

    protected function normalizeToArray($data)
    {
        if ($data instanceof RecordInterface) {
            $data = $data->getProperties();
        } elseif ($data instanceof \stdClass) {
            $data = (array) $data;
        }

        return $data;
    }

    protected function getCurrentPath()
    {
        return '/' . implode('/', $this->pathStack);
    }
}
