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

namespace PSX\Schema\Parser\Popo\Resolver;

use Doctrine\Common\Annotations\Reader;
use PSX\Schema\Parser\Popo\Annotation as Anno;
use PSX\Schema\Parser\Popo\ResolverInterface;
use PSX\Schema\Property;
use PSX\Schema\PropertyInterface;
use PSX\Schema\PropertyType;

/**
 * Annotation
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Annotation implements ResolverInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @param \Doctrine\Common\Annotations\Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * @inheritDoc
     */
    public function resolveClass(\ReflectionClass $reflection): ?PropertyInterface
    {
        $annotations = $this->reader->getClassAnnotations($reflection);

        $annotation = $this->getAnnotationByType($annotations, Anno\AdditionalProperties::class);
        if ($annotation instanceof Anno\AdditionalProperties && $annotation->getAdditionalProperties() !== false) {
            $additionalProperties = $this->parseRef($annotation->getAdditionalProperties());

            $property = Property::getMap();
            if ($additionalProperties !== null) {
                $property->setAdditionalProperties($additionalProperties);
            }
        } else {
            $property = Property::getStruct();
        }

        return $property;
    }

    /**
     * @inheritDoc
     */
    public function resolveProperty(\ReflectionProperty $reflection): ?PropertyInterface
    {
        return $this->getPropertyByAnnotations($this->reader->getPropertyAnnotations($reflection));
    }

    /**
     * @param array $annotations
     * @return PropertyInterface|null
     */
    private function getPropertyByAnnotations(array $annotations): ?PropertyInterface
    {
        $annotation = $this->getAnnotationByType($annotations, Anno\Type::class);

        $type = null;
        if ($annotation instanceof Anno\Type) {
            $type = $annotation->getType();
        }

        if ($type === PropertyType::TYPE_ARRAY) {
            $annotation = $this->getAnnotationByType($annotations, Anno\Items::class);

            $property = null;
            if ($annotation instanceof Anno\Items) {
                $property = $this->parseRef($annotation->getItems());
            }

            return Property::getArray()->setItems($property);
        } elseif ($type === PropertyType::TYPE_STRING) {
            return Property::getString();
        } elseif ($type === PropertyType::TYPE_NUMBER) {
            return Property::getNumber();
        } elseif ($type === PropertyType::TYPE_INTEGER) {
            return Property::getInteger();
        } elseif ($type === PropertyType::TYPE_BOOLEAN) {
            return Property::getBoolean();
        } elseif ($annotation = $this->getAnnotationByType($annotations, Anno\AllOf::class)) {
            return Property::getIntersection()->setAllOf($this->parseRefs($annotation->getProperties()));
        } elseif ($annotation = $this->getAnnotationByType($annotations, Anno\OneOf::class)) {
            return Property::getUnion()->setOneOf($this->parseRefs($annotation->getProperties()));
        } elseif ($annotation = $this->getAnnotationByType($annotations, Anno\Ref::class)) {
            return Property::getReference()->setRef($annotation->getRef());
        }

        return null;
    }

    private function parseRefs($values)
    {
        if (!is_array($values)) {
            $values = [$values];
        }

        $result = [];
        foreach ($values as $value) {
            $result[] = $this->parseRef($value);
        }

        return $result;
    }

    private function parseRef($value, $allowBoolean = false)
    {
        if ($value instanceof Anno\Ref) {
            return Property::getReference()->setRef($value->getRef());
        } elseif ($value instanceof Anno\Schema) {
            return $this->getPropertyByAnnotations($value->getAnnotations());
        } elseif ($allowBoolean && is_bool($value)) {
            return $value;
        }

        return null;
    }

    private function getAnnotationByType(array $annotations, string $class)
    {
        foreach ($annotations as $annotation) {
            if ($annotation instanceof $class) {
                return $annotation;
            }
        }

        return null;
    }
}
