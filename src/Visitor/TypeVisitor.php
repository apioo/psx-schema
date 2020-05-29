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

namespace PSX\Schema\Visitor;

use PSX\DateTime\Date;
use PSX\DateTime\DateTime;
use PSX\DateTime\Duration;
use PSX\DateTime\Time;
use PSX\Record\Record;
use PSX\Schema\Type\ArrayType;
use PSX\Schema\Type\BooleanType;
use PSX\Schema\Type\IntegerType;
use PSX\Schema\Type\MapType;
use PSX\Schema\Type\NumberType;
use PSX\Schema\Type\StringType;
use PSX\Schema\Type\StructType;
use PSX\Schema\Type\TypeAbstract;
use PSX\Schema\Validation\ValidatorInterface;
use PSX\Schema\VisitorInterface;
use PSX\Uri\Uri;

/**
 * TypeVisitor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class TypeVisitor implements VisitorInterface
{
    /**
     * @var \PSX\Schema\Validation\ValidatorInterface|null
     */
    protected $validator;

    /**
     * @param \PSX\Schema\Validation\ValidatorInterface|null $validator
     */
    public function __construct(ValidatorInterface $validator = null)
    {
        $this->validator = $validator;
    }

    public function visitStruct(\stdClass $data, StructType $type, $path)
    {
        $className = $type->getAttribute(TypeAbstract::ATTR_CLASS);
        if (!empty($className)) {
            $class  = new \ReflectionClass($className);
            $record = $class->newInstance();

            $mapping = $type->getAttribute(TypeAbstract::ATTR_MAPPING) ?: [];
            foreach ($data as $key => $value) {
                try {
                    $name   = isset($mapping[$key]) ? $mapping[$key] : $key;
                    $method = $class->getMethod('set' . ucfirst($name));
                    $method->invokeArgs($record, [$value]);
                } catch (\ReflectionException $e) {
                    // method does not exist
                }
            }
        } else {
            $record = Record::fromStdClass($data, $type->getTitle() ?: null);
        }

        if ($this->validator !== null) {
            $this->validator->validate($path, $record);
        }

        return $record;
    }

    public function visitMap(\stdClass $data, MapType $type, $path)
    {
        $className = $type->getAttribute(TypeAbstract::ATTR_CLASS);
        if (!empty($className)) {
            $class  = new \ReflectionClass($className);
            $record = $class->newInstance();

            // allows to use other map implementations
            if ($record instanceof \ArrayAccess) {
                foreach ($data as $key => $value) {
                    $record->offsetSet($key, $value);
                }
            } else {
                throw new \RuntimeException('Map implementation must implement the ArrayAccess interface');
            }
        } else {
            $record = Record::fromStdClass($data, $type->getTitle() ?: null);
        }

        if ($this->validator !== null) {
            $this->validator->validate($path, $record);
        }

        return $record;
    }

    public function visitArray(array $data, ArrayType $type, $path)
    {
        if ($this->validator !== null) {
            $this->validator->validate($path, $data);
        }

        return $data;
    }

    public function visitBinary($data, StringType $type, $path)
    {
        $binary   = base64_decode($data);
        $resource = fopen('php://temp', 'r+');

        fwrite($resource, $binary);
        rewind($resource);

        if ($this->validator !== null) {
            $this->validator->validate($path, $resource);
        }

        return $resource;
    }

    public function visitBoolean($data, BooleanType $type, $path)
    {
        if ($this->validator !== null) {
            $this->validator->validate($path, $data);
        }

        return $data;
    }

    public function visitDateTime($data, StringType $type, $path)
    {
        $result = new DateTime($data);

        if ($this->validator !== null) {
            $this->validator->validate($path, $result);
        }

        return $result;
    }

    public function visitDate($data, StringType $type, $path)
    {
        $result = new Date($data);

        if ($this->validator !== null) {
            $this->validator->validate($path, $result);
        }

        return $result;
    }

    public function visitDuration($data, StringType $type, $path)
    {
        $result = new Duration($data);

        if ($this->validator !== null) {
            $this->validator->validate($path, $result);
        }

        return $result;
    }

    public function visitNumber($data, NumberType $type, $path)
    {
        if ($this->validator !== null) {
            $this->validator->validate($path, $data);
        }

        return $data;
    }

    public function visitInteger($data, IntegerType $type, $path)
    {
        if ($this->validator !== null) {
            $this->validator->validate($path, $data);
        }

        return $data;
    }

    public function visitString($data, StringType $type, $path)
    {
        if ($this->validator !== null) {
            $this->validator->validate($path, $data);
        }

        return $data;
    }

    public function visitTime($data, StringType $type, $path)
    {
        $result = new Time($data);

        if ($this->validator !== null) {
            $this->validator->validate($path, $result);
        }

        return $result;
    }

    public function visitUri($data, StringType $type, $path)
    {
        $result = new Uri($data);

        if ($this->validator !== null) {
            $this->validator->validate($path, $result);
        }

        return $result;
    }
}
