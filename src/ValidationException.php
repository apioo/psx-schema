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

use Throwable;

/**
 * Exception which is thrown on a validation error. The keyword is one of the 
 * defined json schema validation keywords and the path is a json pointer array
 * pointing to the element which created the error 
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ValidationException extends \Exception
{
    /**
     * @var string
     */
    protected $keyword;

    /**
     * @var array
     */
    protected $path;

    /**
     * @param string $message
     * @param string $keyword
     * @param array $path
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message, $keyword, array $path, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->keyword = $keyword;
        $this->path    = $path;
    }

    /**
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @return array
     */
    public function getPath()
    {
        return $this->path;
    }
}
