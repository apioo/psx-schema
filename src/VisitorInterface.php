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

namespace PSX\Schema;

/**
 * VisitorInterface
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
interface VisitorInterface
{
    /**
     * Visits an array value
     *
     * @param array $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitArray(array $data, PropertyInterface $property, $path);

    /**
     * Visits a binary value
     *
     * @param string $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitBinary($data, PropertyInterface $property, $path);

    /**
     * Visits a boolean value
     *
     * @param string $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitBoolean($data, PropertyInterface $property, $path);

    /**
     * Visits a complex value
     *
     * @param \stdClass $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitObject(\stdClass $data, PropertyInterface $property, $path);

    /**
     * Visits a date time value
     *
     * @param string $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitDateTime($data, PropertyInterface $property, $path);

    /**
     * Visits a date value
     *
     * @param string $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitDate($data, PropertyInterface $property, $path);

    /**
     * Visits a duration value
     *
     * @param string $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitDuration($data, PropertyInterface $property, $path);

    /**
     * Visits a float value
     *
     * @param string $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitNumber($data, PropertyInterface $property, $path);

    /**
     * Visits an integer value
     *
     * @param string $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitInteger($data, PropertyInterface $property, $path);

    /**
     * Visits a string value
     *
     * @param string $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitString($data, PropertyInterface $property, $path);

    /**
     * Visits a time value
     *
     * @param string $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitTime($data, PropertyInterface $property, $path);

    /**
     * Visits a uri value
     *
     * @param string $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitUri($data, PropertyInterface $property, $path);

    /**
     * Visits a uri value
     *
     * @param string $data
     * @param \PSX\Schema\PropertyInterface $property
     * @param string $path
     * @return mixed
     */
    public function visitNull($data, PropertyInterface $property, $path);
}
