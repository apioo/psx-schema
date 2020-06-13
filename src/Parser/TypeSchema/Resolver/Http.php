<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2020 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Parser\TypeSchema\Resolver;

use PSX\Http\Client\ClientInterface;
use PSX\Http\Client\GetRequest;
use PSX\Json\Parser;
use PSX\Schema\Parser\TypeSchema\Document;
use PSX\Schema\Parser\TypeSchema\ResolverInterface;
use PSX\Uri\Uri;
use RuntimeException;

/**
 * Http
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Http implements ResolverInterface
{
    protected $httpClient;

    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function resolve(Uri $uri): array
    {
        $request  = new GetRequest($uri, array('Accept' => 'application/json'));
        $response = $this->httpClient->request($request);

        if ($response->getStatusCode() == 200) {
            $schema = (string) $response->getBody();
            $data   = Parser::decode($schema, true);

            return $data;
        } else {
            throw new RuntimeException('Could not load external schema ' . $uri->toString() . ' received ' . $response->getStatusCode());
        }
    }
}
