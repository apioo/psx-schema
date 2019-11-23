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

use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\ContextFactory;
use phpDocumentor\Reflection\Type;
use phpDocumentor\Reflection\Types;
use PSX\Schema\Parser\Popo\ResolverInterface;
use PSX\Schema\Property;
use PSX\Schema\PropertyInterface;

/**
 * Documentor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Documentor implements ResolverInterface
{
    /**
     * @inheritDoc
     */
    public function resolveClass(\ReflectionClass $reflection): ?PropertyInterface
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function resolveProperty(\ReflectionProperty $reflection): ?PropertyInterface
    {
        $comment = $reflection->getDocComment();

        preg_match('/@var ([?\w]+)/', $comment, $matches);
        $type = $matches[1] ?? null;

        if (!empty($type)) {
            $context = (new ContextFactory())->createFromReflector($reflection);
            $type = (new TypeResolver())->resolve($type, $context);

            return $this->getPropertyForType($type);
        }

        return null;
    }

    private function getPropertyForType(Type $type): ?PropertyInterface
    {
        if ($type instanceof Types\Object_) {
            return Property::getReference()->setRef($type->getFqsen());
        } elseif ($type instanceof Types\AbstractList) {
            $items = $this->getPropertyForType($type->getValueType());
            if ($items === null) {
                return null;
            }

            return Property::getArray()->setItems($items);
        } elseif ($type instanceof Types\Boolean) {
            return Property::getBoolean();
        } elseif ($type instanceof Types\Integer) {
            return Property::getInteger();
        } elseif ($type instanceof Types\Float_) {
            return Property::getNumber();
        } elseif ($type instanceof Types\String_) {
            return Property::getString();
        } elseif ($type instanceof Types\Nullable) {
            return $this->getPropertyForType($type->getActualType());
        } elseif ($type instanceof Types\Compound) {
            $oneOf = [];
            foreach ($type as $typ) {
                $property = $this->getPropertyForType($typ);
                if ($property instanceof PropertyInterface) {
                    $oneOf[] = $property;
                }
            }

            if (count($oneOf) > 1) {
                return Property::getUnion()->setOneOf($oneOf);
            } else {
                return reset($oneOf);
            }
        }

        return null;
    }
}
