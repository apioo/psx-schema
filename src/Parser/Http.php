<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2023 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Parser;

use PSX\Http\Client\ClientInterface;
use PSX\Http\Client\GetRequest;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManagerInterface;

/**
 * Http
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Http extends TypeSchema
{
    public const USER_AGENT = 'TypeSchema Resolver (https://github.com/apioo/psx-schema)';

    private ClientInterface $httpClient;
    private bool $secure;

    public function __construct(SchemaManagerInterface $schemaManager, ClientInterface $httpClient, bool $secure)
    {
        parent::__construct($schemaManager);

        $this->httpClient = $httpClient;
        $this->secure = $secure;
    }

    public function parse(string $schema, ?ContextInterface $context = null): SchemaInterface
    {
        $request  = new GetRequest(($this->secure ? 'https' : 'http') . '://' . $schema, ['Accept' => 'application/json', 'User-Agent' => self::USER_AGENT]);
        $response = $this->httpClient->request($request);

        if ($response->getStatusCode() !== 200) {
            throw new ParserException('Could not load external schema ' . $schema . ' received ' . $response->getStatusCode());
        }

        return parent::parse((string) $response->getBody(), $context);
    }
}
