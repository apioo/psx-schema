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

namespace PSX\Schema\Parser\TypeSchema;

use PSX\Http\Client\ClientInterface;
use PSX\Uri\Uri;

/**
 * ImportResolver
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ImportResolver
{
    /**
     * @var array
     */
    protected $resolvers;

    public function __construct()
    {
        $this->resolvers = [];
    }

    public function addResolver(string $scheme, ResolverInterface $resolver)
    {
        $this->resolvers[$scheme] = $resolver;
    }

    public function resolve(Uri $source): array
    {
        $scheme   = $source->getScheme();
        $resolver = $this->resolvers[$scheme] ?? null;
        
        if (!$resolver instanceof ResolverInterface) {
            throw new \RuntimeException('Could not find resolver for scheme ' . $scheme);
        }

        return $resolver->resolve($source);
    }

    public static function createDefault(ClientInterface $httpClient = null)
    {
        $resolver = new self();
        $resolver->addResolver('file', new Resolver\File());

        if ($httpClient !== null) {
            $httpResolver = new Resolver\Http($httpClient);

            $resolver->addResolver('http', $httpResolver);
            $resolver->addResolver('https', $httpResolver);
        }

        return $resolver;
    }
}
