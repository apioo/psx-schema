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

namespace PSX\Schema\Visitor;

use PSX\Schema\PropertyInterface;
use PSX\Schema\VisitorInterface;

/**
 * NullVisitor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class NullVisitor implements VisitorInterface
{
    public function visitArray(array $data, PropertyInterface $property, $path)
    {
        return $data;
    }

    public function visitBinary($data, PropertyInterface $property, $path)
    {
        return $data;
    }

    public function visitBoolean($data, PropertyInterface $property, $path)
    {
        return $data;
    }

    public function visitObject(\stdClass $data, PropertyInterface $property, $path)
    {
        return $data;
    }

    public function visitDateTime($data, PropertyInterface $property, $path)
    {
        return $data;
    }

    public function visitDate($data, PropertyInterface $property, $path)
    {
        return $data;
    }

    public function visitDuration($data, PropertyInterface $property, $path)
    {
        return $data;
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
        return $data;
    }

    public function visitUri($data, PropertyInterface $property, $path)
    {
        return $data;
    }

    public function visitNull($data, PropertyInterface $property, $path)
    {
        return null;
    }
}
