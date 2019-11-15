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

namespace PSX\Schema;

use PSX\DateTime\Date;
use PSX\DateTime\DateTime;
use PSX\DateTime\Duration;
use PSX\DateTime\Time;
use PSX\Json\Comparator;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\IntersectionType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\ScalarType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\UnionType;
use PSX\Schema\Visitor\NullVisitor;
use RuntimeException;

/**
 * SchemaTraverser
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaTraverser
{
    private const MAX_RECURSION_DEPTH = 16;

    /**
     * @var array
     */
    private $pathStack;

    /**
     * @var integer
     */
    private $recCount;

    /**
     * @var bool
     */
    private $assertConstraints;

    /**
     * @param bool $assertConstraints
     */
    public function __construct(bool $assertConstraints = true)
    {
        $this->assertConstraints = $assertConstraints;
    }

    /**
     * Traverses through the data and validates it according to the provided
     * schema. Calls also the visitor methods for each type
     *
     * @param mixed $data
     * @param \PSX\Schema\SchemaInterface $schema
     * @param \PSX\Schema\VisitorInterface $visitor
     * @return mixed
     */
    public function traverse($data, SchemaInterface $schema, VisitorInterface $visitor = null)
    {
        $this->pathStack = [];
        $this->recCount  = -1;
        
        if ($visitor === null) {
            $visitor = new NullVisitor();
        }

        return $this->recTraverse($data, $schema->getDefinition(), $visitor);
    }

    protected function recTraverse($data, PropertyInterface $property, VisitorInterface $visitor)
    {
        $this->recCount++;

        if ($this->recCount > self::MAX_RECURSION_DEPTH) {
            throw new RuntimeException($this->getCurrentPath() . ' max recursion depth reached');
        }

        if ($property instanceof StructType) {
            if ($this->assertConstraints) {
                $this->assertStructConstraints($data, $property);
            }

            $result = $this->traverseStruct($data, $property, $visitor);
        } elseif ($property instanceof MapType) {
            if ($this->assertConstraints) {
                $this->assertMapConstraints($data, $property);
            }

            $result = $this->traverseMap($data, $property, $visitor);
        } elseif ($property instanceof ArrayType) {
            if ($this->assertConstraints) {
                $this->assertArrayConstraints($data, $property);
            }

            $result = $this->traverseArray($data, $property, $visitor);
        } elseif ($property instanceof StringType) {
            if ($this->assertConstraints) {
                $this->assertStringConstraints($data, $property);
                $this->assertScalarConstraints($data, $property);
            }

            $result = $this->traverseString($data, $property, $visitor);
        } elseif ($property instanceof IntegerType) {
            if ($this->assertConstraints) {
                $this->assertNumberConstraints($data, $property);
                $this->assertScalarConstraints($data, $property);
            }

            $result = $visitor->visitInteger($data, $property, $this->getCurrentPath());
        } elseif ($property instanceof NumberType) {
            if ($this->assertConstraints) {
                $this->assertNumberConstraints($data, $property);
                $this->assertScalarConstraints($data, $property);
            }

            $result = $visitor->visitNumber($data, $property, $this->getCurrentPath());
        } elseif ($property instanceof BooleanType) {
            if ($this->assertConstraints) {
                $this->assertBooleanConstraints($data, $property);
            }

            $result = $visitor->visitBoolean($data, $property, $this->getCurrentPath());
        } elseif ($property instanceof IntersectionType) {
            $result = $this->traverseIntersection($data, $property, $visitor);
        } elseif ($property instanceof UnionType) {
            $result = $this->traverseUnion($data, $property, $visitor);
        } else {
            $result = null;
        }

        $this->recCount--;

        return $result;
    }

    protected function traverseStruct(\stdClass $data, StructType $property, VisitorInterface $visitor)
    {
        $data   = (array) $data;
        $result = new \stdClass();

        $properties = $property->getProperties();
        if (!empty($properties)) {
            foreach ($properties as $key => $prop) {
                array_push($this->pathStack, $key);

                if (array_key_exists($key, $data)) {
                    $result->{$key} = $this->recTraverse($data[$key], $prop, $visitor);
                }

                array_pop($this->pathStack);
            }
        }

        return $visitor->visitObject($result, $property, $this->getCurrentPath());
    }

    protected function traverseMap(\stdClass $data, MapType $property, VisitorInterface $visitor)
    {
        $data   = (array) $data;
        $result = new \stdClass();

        $additionalProperties = $property->getAdditionalProperties();
        if (is_bool($additionalProperties)) {
            if ($additionalProperties === true) {
                $result = (object) $data;
            }
        } elseif ($additionalProperties instanceof PropertyInterface) {
            foreach ($data as $key => $value) {
                array_push($this->pathStack, $key);

                $result->{$key} = $this->recTraverse($data[$key], $additionalProperties, $visitor);

                array_pop($this->pathStack);
            }
        }

        return $visitor->visitObject($result, $property, $this->getCurrentPath());
    }

    protected function traverseArray(array $data, PropertyInterface $property, VisitorInterface $visitor)
    {
        $result = [];

        $items = $property->getItems();
        if ($items instanceof PropertyInterface) {
            foreach ($data as $index => $value) {
                array_push($this->pathStack, $index);

                $result[] = $this->recTraverse($value, $items, $visitor);

                array_pop($this->pathStack);
            }
        }

        return $visitor->visitArray($result, $property, $this->getCurrentPath());
    }

    protected function traverseString($data, PropertyInterface $property, VisitorInterface $visitor)
    {
        $format = $property->getFormat();
        if ($format === PropertyType::FORMAT_BINARY) {
            return $visitor->visitBinary($data, $property, $this->getCurrentPath());
        } elseif ($format === PropertyType::FORMAT_DATETIME) {
            return $visitor->visitDateTime($data, $property, $this->getCurrentPath());
        } elseif ($format === PropertyType::FORMAT_DATE) {
            return $visitor->visitDate($data, $property, $this->getCurrentPath());
        } elseif ($format === PropertyType::FORMAT_DURATION) {
            return $visitor->visitDuration($data, $property, $this->getCurrentPath());
        } elseif ($format === PropertyType::FORMAT_TIME) {
            return $visitor->visitTime($data, $property, $this->getCurrentPath());
        } elseif ($format === PropertyType::FORMAT_URI) {
            return $visitor->visitUri($data, $property, $this->getCurrentPath());
        } else {
            return $visitor->visitString($data, $property, $this->getCurrentPath());
        }
    }

    protected function traverseIntersection($data, IntersectionType $property, VisitorInterface $visitor)
    {
        $properties = $property->getAllOf();

        $count  = count($properties);
        $match  = 0;
        $result = [];

        foreach ($properties as $index => $prop) {
            $assertConstraints = $this->assertConstraints;

            try {
                $this->assertConstraints = true;

                $result[] = $this->recTraverse($data, $prop, new NullVisitor());

                $match++;
            } catch (ValidationException $e) {
                $this->recCount--;
            } finally {
                $this->assertConstraints = $assertConstraints;
            }
        }

        if ($this->assertConstraints && $count !== $match) {
            throw new ValidationException($this->getCurrentPath() . ' must match all required schemas (matched only ' . $match . ' out of ' . $count . ')', 'allOf', $this->pathStack);
        }

        // we must merge the result
        $data = new \stdClass();
        foreach ($result as $row) {
            if ($row instanceof \stdClass) {
                foreach ($row as $key => $value) {
                    $data->{$key} = $value;
                }
            }
        }

        return $visitor->visitObject($data, $property, $this->getCurrentPath());
    }

    protected function traverseUnion($data, UnionType $property, VisitorInterface $visitor)
    {
        $properties = $property->getProperties();

        $match  = 0;
        $result = null;

        foreach ($properties as $index => $prop) {
            $assertConstraints = $this->assertConstraints;

            try {
                $this->assertConstraints = true;

                $result = $this->recTraverse($data, $prop, $visitor);

                $match++;
            } catch (ValidationException $e) {
                $this->recCount--;
            } finally {
                $this->assertConstraints = $assertConstraints;
            }
        }

        if ($this->assertConstraints && $match !== 1) {
            throw new ValidationException($this->getCurrentPath() . ' must match one required schema', 'oneOf', $this->pathStack);
        }

        return $result;
    }

    protected function assertScalarConstraints($data, PropertyInterface $property)
    {
        $format = $property->getFormat();
        if ($format !== null) {
            if ($format === PropertyType::FORMAT_BINARY) {
                if (!preg_match('~^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?$~', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid Base64 encoded string [RFC4648]', 'format', $this->pathStack);
                }
            } elseif ($format === PropertyType::FORMAT_DATETIME) {
                if (!preg_match('/^' . DateTime::getPattern() . '$/', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid date-time format [RFC3339]', 'format', $this->pathStack);
                }
            } elseif ($format === PropertyType::FORMAT_DATE) {
                if (!preg_match('/^' . Date::getPattern() . '$/', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid full-date format [RFC3339]', 'format', $this->pathStack);
                }
            } elseif ($format === PropertyType::FORMAT_DURATION) {
                if (!preg_match('/^' . Duration::getPattern() . '$/', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid duration format [ISO8601]', 'format', $this->pathStack);
                }
            } elseif ($format === PropertyType::FORMAT_TIME) {
                if (!preg_match('/^' . Time::getPattern() . '$/', $data)) {
                    throw new ValidationException($this->getCurrentPath() . ' must be a valid full-time format [RFC3339]', 'format', $this->pathStack);
                }
            } elseif ($format === 'email') {
                if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
                    throw new ValidationException($this->getCurrentPath() . ' must contain a valid email address', 'format', $this->pathStack);
                }
            } elseif ($format === 'ipv4') {
                if (!filter_var($data, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    throw new ValidationException($this->getCurrentPath() . ' must contain a valid IPv4 address', 'format', $this->pathStack);
                }
            } elseif ($format === 'ipv6') {
                if (!filter_var($data, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    throw new ValidationException($this->getCurrentPath() . ' must contain a valid IPv6 address', 'format', $this->pathStack);
                }
            }
        }

        $enum = $property->getEnum();
        if ($enum !== null) {
            if (!array_search($data, $enum)) {
                throw new ValidationException($this->getCurrentPath() . ' is not in enumeration ' . json_encode($enum), 'enum', $this->pathStack);
            }
        }

        $const = $property->getConst();
        if ($const !== null) {
            if ($const !== $data) {
                throw new ValidationException($this->getCurrentPath() . ' must contain the constant value ' . json_encode($const), 'const', $this->pathStack);
            }
        }
    }

    protected function assertStructConstraints(\stdClass $data, PropertyInterface $property)
    {
        if (!$data instanceof \stdClass) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type object', 'type', $this->pathStack);
        }

        $keys = array_keys(get_object_vars($data));

        $required = $property->getRequired();
        if ($required !== null) {
            $diff = array_diff($required, $keys);
            if (count($diff) > 0) {
                throw new ValidationException($this->getCurrentPath() . ' the following properties are required: ' . implode(', ', $diff), 'required', $this->pathStack);
            }
        }
    }

    protected function assertMapConstraints($data, PropertyInterface $property)
    {
        if (!$data instanceof \stdClass) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type object', 'type', $this->pathStack);
        }

        $keys = array_keys(get_object_vars($data));

        $minProperties = $property->getMinProperties();
        if ($minProperties !== null) {
            if (count($keys) < $minProperties) {
                throw new ValidationException($this->getCurrentPath() . ' must contain more or equal than ' . $minProperties . ' properties', 'minProperties', $this->pathStack);
            }
        }

        $maxProperties = $property->getMaxProperties();
        if ($maxProperties !== null) {
            if (count($keys) > $maxProperties) {
                throw new ValidationException($this->getCurrentPath() . ' must contain less or equal than ' . $maxProperties . ' properties', 'maxProperties', $this->pathStack);
            }
        }
    }

    protected function assertArrayConstraints($data, PropertyInterface $property)
    {
        if (!is_array($data)) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type array', 'type', $this->pathStack);
        }

        $minItems = $property->getMinItems();
        if ($minItems !== null) {
            if (count($data) < $minItems) {
                throw new ValidationException($this->getCurrentPath() . ' must contain more or equal than ' . $minItems . ' items', 'minItems', $this->pathStack);
            }
        }

        $maxItems = $property->getMaxItems();
        if ($maxItems !== null) {
            if (count($data) > $maxItems) {
                throw new ValidationException($this->getCurrentPath() . ' must contain less or equal than ' . $maxItems . ' items', 'maxItems', $this->pathStack);
            }
        }

        $uniqueItems = $property->getUniqueItems();
        if ($uniqueItems !== null && $uniqueItems === true) {
            foreach ($data as $index => $row) {
                $found = false;
                foreach ($data as $innerIndex => $innerRow) {
                    if ($index != $innerIndex && Comparator::compare($row, $innerRow)) {
                        $found = true;
                        break;
                    }
                }

                if ($found) {
                    throw new ValidationException($this->getCurrentPath() . ' must contain only unique items', 'uniqueItems', $this->pathStack);
                }
            }
        }
    }

    protected function assertNumberConstraints($data, PropertyInterface $property)
    {
        if ($property instanceof IntegerType) {
            if (!is_int($data)) {
                throw new ValidationException($this->getCurrentPath() . ' must be of type integer', 'type', $this->pathStack);
            }
        } else {
            if (!is_float($data) && !is_int($data)) {
                throw new ValidationException($this->getCurrentPath() . ' must be of type float', 'type', $this->pathStack);
            }
        }

        $maximum = $property->getMaximum();
        if ($maximum !== null) {
            if ($property->getExclusiveMaximum()) {
                if ($data >= $maximum) {
                    throw new ValidationException($this->getCurrentPath() . ' must be lower than ' . $maximum, 'maximum', $this->pathStack);
                }
            } else {
                if ($data > $maximum) {
                    throw new ValidationException($this->getCurrentPath() . ' must be lower or equal than ' . $maximum, 'maximum', $this->pathStack);
                }
            }
        }

        $minimum = $property->getMinimum();
        if ($minimum !== null) {
            if ($property->getExclusiveMinimum()) {
                if ($data <= $minimum) {
                    throw new ValidationException($this->getCurrentPath() . ' must be greater than ' . $minimum, 'minimum', $this->pathStack);
                }
            } else {
                if ($data < $minimum) {
                    throw new ValidationException($this->getCurrentPath() . ' must be greater or equal than ' . $minimum, 'minimum', $this->pathStack);
                }
            }
        }

        $multipleOf = $property->getMultipleOf();
        if ($multipleOf !== null) {
            $result = $data / $multipleOf;
            $base   = (int) $result;

            // its important to make a loose comparison
            if ($data > 0 && $result - $base != 0) {
                throw new ValidationException($this->getCurrentPath() . ' must be a multiple of ' . $multipleOf, 'multipleOf', $this->pathStack);
            }
        }
    }

    protected function assertBooleanConstraints($data, PropertyInterface $property)
    {
        if (!is_bool($data)) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type boolean', 'type', $this->pathStack);
        }
    }

    protected function assertStringConstraints($data, PropertyInterface $property)
    {
        if (!is_string($data)) {
            throw new ValidationException($this->getCurrentPath() . ' must be of type string', 'type', $this->pathStack);
        }

        $minLength = $property->getMinLength();
        if ($minLength !== null) {
            if (strlen($data) < $minLength) {
                throw new ValidationException($this->getCurrentPath() . ' must contain more or equal than ' . $minLength . ' characters', 'minLength', $this->pathStack);
            }
        }

        $maxLength = $property->getMaxLength();
        if ($maxLength !== null) {
            if (strlen($data) > $maxLength) {
                throw new ValidationException($this->getCurrentPath() . ' must contain less or equal than ' . $maxLength . ' characters', 'maxLength', $this->pathStack);
            }
        }

        $pattern = $property->getPattern();
        if ($pattern !== null) {
            $result = preg_match('/' . $pattern . '/', $data);
            if (!$result) {
                throw new ValidationException($this->getCurrentPath() . ' does not match pattern [' . $pattern . ']', 'pattern', $this->pathStack);
            }
        }
    }

    private function getCurrentPath()
    {
        return '/' . implode('/', $this->pathStack);
    }
}
