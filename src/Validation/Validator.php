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

namespace PSX\Schema\Validation;

use PSX\Schema\ValidationException;
use PSX\Validate\FilterInterface;

/**
 * Validator
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Validator implements ValidatorInterface
{
    /**
     * @var \PSX\Schema\Validation\Field[]
     */
    protected $fields;

    /**
     * @param \PSX\Schema\Validation\Field[] $fields
     */
    public function __construct(array $fields = null)
    {
        $this->fields = $fields;
    }

    /**
     * @param \PSX\Schema\Validation\Field[] $fields
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * @return \PSX\Schema\Validation\Field[]
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param string $path
     * @param mixed $data
     * @throws \PSX\Schema\ValidationException
     */
    public function validate($path, $data)
    {
        $field = $this->getField($path);

        if ($field instanceof Field) {
            $filters = $field->getFilters();
            
            foreach ($filters as $filter) {
                $result = null;
                $error  = null;
                if ($filter instanceof FilterInterface) {
                    $result = $filter->apply($data);
                    $error  = $filter->getErrorMessage();
                } elseif ($filter instanceof \Closure) {
                    $result = $filter($data);
                }

                if ($result === false) {
                    if (empty($error)) {
                        $error = '%s is not valid';
                    }

                    throw new ValidationException(sprintf($error, $path), 'filter', explode('/', ltrim($path, '/')));
                }
            }
        }
    }

    /**
     * Returns the property defined by the name
     *
     * @param string $name
     * @return \PSX\Schema\Validation\Field|null
     */
    protected function getField($name)
    {
        $name = ltrim($name, '/');

        foreach ($this->fields as $field) {
            if (preg_match('#^' . ltrim($field->getName(), '/') . '$#', $name)) {
                return $field;
            }
        }

        return null;
    }
}
