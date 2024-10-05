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

namespace PSX\Schema\Parser;

use PSX\Http\Client\ClientInterface;
use PSX\Http\Client\GetRequest;
use PSX\Http\Client\PostRequest;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\SchemaInterface;
use PSX\Schema\SchemaManagerInterface;
use PSX\Uri\Uri;
use PSX\Uri\Url;

/**
 * TypeHub
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class TypeHub extends TypeSchema
{
    private const API_URL = 'https://api.typehub.cloud/document/%s/%s/export';

    private ClientInterface $httpClient;

    public function __construct(SchemaManagerInterface $schemaManager, ClientInterface $httpClient)
    {
        parent::__construct($schemaManager);

        $this->httpClient = $httpClient;
    }

    public function parse(string $schema, ?ContextInterface $context = null): SchemaInterface
    {
        $uri = Uri::parse('typehub://' . $schema);
        $user = $uri->getUser();
        $document = $uri->getPassword();
        $version = $uri->getHost();

        $url = $this->export($user, $document, $version);
        $request = new GetRequest($url, ['Accept' => 'application/json', 'User-Agent' => Http::USER_AGENT]);
        $response = $this->httpClient->request($request);

        if ($response->getStatusCode() !== 200) {
            throw new ParserException('Could not receive TypeHub document: ' . $user . '/' . $document . ' for version ' . $version . ' received ' . $response->getStatusCode());
        }

        return parent::parse((string) $response->getBody(), $context);
    }

    private function export(string $user, string $document, string $version): Url
    {
        $url = Url::parse(sprintf(self::API_URL, $user, $document));
        $request = new PostRequest($url, ['Accept' => 'application/json', 'Content-Type' => 'application/json', 'User-Agent' => Http::USER_AGENT], \json_encode(['format' => 'model-typeschema', 'version' => $version]));
        $response = $this->httpClient->request($request);

        if ($response->getStatusCode() !== 200) {
            throw new ParserException('Could not export TypeHub document: ' . $user . '/' . $document . ' for version ' . $version . ' received ' . $response->getStatusCode() . ' - ' . $response->getBody());
        }

        $data = \json_decode((string) $response->getBody());
        $href = $data->href ?? null;

        if (empty($href) || !is_string($href)) {
            throw new ParserException('Could not export TypeHub document: ' . $user . '/' . $document . ' for version ' . $version . ' returned no export href');
        }

        return Url::parse($href);
    }
}
