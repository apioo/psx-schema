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

namespace PSX\Schema\Visitor;

use Doctrine\Common\Collections\ArrayCollection;
use PSX\DateTime\Date;
use PSX\DateTime\DateTime;
use PSX\DateTime\Duration;
use PSX\DateTime\Time;
use PSX\Record\Record;
use PSX\Record\RecordInterface;
use PSX\Schema\AdditionalPropertiesInterface;
use PSX\Schema\Property;
use PSX\Schema\PropertyInterface;
use PSX\Schema\ValidationException;
use PSX\Schema\VisitorInterface;
use PSX\Uri\Uri;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * TypeVisitor
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class TypeVisitor implements VisitorInterface
{
    public function visitArray(array $data, PropertyInterface $property, $path)
    {
        return new ArrayCollection($data);
    }

    public function visitBinary($data, PropertyInterface $property, $path)
    {
        $binary = base64_decode($data);
        if ($binary === false) {
            throw new ValidationException($path . ' must be a valid Base64 encoded string [RFC4648]');
        }

        $resource = fopen('php://temp', 'r+');
        fwrite($resource, $binary);
        rewind($resource);

        return $resource;
    }

    public function visitBoolean($data, PropertyInterface $property, $path)
    {
        return $data;
    }

    public function visitObject(\stdClass $data, PropertyInterface $property, $path)
    {
        // if we have no class reference we simply create a record
        $className = $property->getClass();
        if (empty($className)) {
            return Record::fromStdClass($data, $property->getTitle() ?: null);
        }

        $class  = new \ReflectionClass($className);
        $record = $class->newInstance();

        if ($record instanceof RecordInterface) {
            foreach ($data as $key => $value) {
                $record->setProperty($key, $value);
            }
        } elseif ($record instanceof \ArrayAccess) {
            foreach ($data as $key => $value) {
                $record[$key] = $value;
            }
        } elseif ($record instanceof \stdClass) {
            foreach ($data as $key => $value) {
                $record->$key = $value;
            }
        } else {
            // if we have a POPO we first try to set the values through proper
            // setter methods
            $keys = [];
            foreach ($data as $key => $value) {
                try {
                    $methodName = 'set' . ucfirst($key);
                    $method     = $class->getMethod($methodName);

                    if ($method instanceof \ReflectionMethod) {
                        $method->invokeArgs($record, array($value));
                    } else {
                        $keys[] = $key;
                    }
                } catch (\ReflectionException $e) {
                    // method does not exist
                    $keys[] = $key;
                }
            }

            // if we have keys where we have no fitting setter method we try to
            // add the values in another way to the object
            if (!empty($keys)) {
                if ($record instanceof AdditionalPropertiesInterface) {
                    foreach ($keys as $key) {
                        $record->setProperty($key, $data->$key);
                    }
                }
            }
        }

        return $record;
    }

    public function visitDateTime($data, PropertyInterface $property, $path)
    {
        return new DateTime($data);
    }

    public function visitDate($data, PropertyInterface $property, $path)
    {
        return new Date($data);
    }

    public function visitDuration($data, PropertyInterface $property, $path)
    {
        return new Duration($data);
    }

    public function visitNumber($data, PropertyInterface $property, $path)
    {
        return $data;
    }

    public function visitInteger($data, PropertyInterface $property, $path)
    {
        return $data;
    }

    public function visitString($data, PropertyInterface $property, $path)
    {
        return $data;
    }

    public function visitTime($data, PropertyInterface $property, $path)
    {
        return new Time($data);
    }

    public function visitUri($data, PropertyInterface $property, $path)
    {
        return new Uri($data);
    }

    public function visitNull($data, PropertyInterface $property, $path)
    {
        return null;
    }
}
