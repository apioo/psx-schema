<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright (c) Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Exception;

use Throwable;

/**
 * Exception which is thrown on a validation error. The keyword is one of the 
 * defined json schema validation keywords and the path is a json pointer array
 * pointing to the element which created the error 
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class ValidationException extends SchemaException
{
    protected string $keyword;
    protected array $path;

    public function __construct(string $message, string $keyword, array $path, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->keyword = $keyword;
        $this->path    = $path;
    }

    public function getKeyword(): string
    {
        return $this->keyword;
    }

    public function getPath(): array
    {
        return $this->path;
    }
}
