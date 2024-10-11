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

namespace PSX\Schema;

use Psr\Cache\CacheItemPoolInterface;
use PSX\Http\Client\Client;
use PSX\Http\Client\ClientInterface;
use PSX\Schema\Exception\InvalidSchemaException;
use PSX\Schema\Parser\ContextInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * SchemaManager
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class SchemaManager implements SchemaManagerInterface
{
    private CacheItemPoolInterface $cache;
    private bool $debug;

    /**
     * @var ParserInterface[]
     */
    private array $parsers = [];

    public function __construct(?CacheItemPoolInterface $cache = null, ?ClientInterface $httpClient = null, bool $debug = false)
    {
        $this->cache = $cache ?? new ArrayAdapter();
        $this->debug = $debug;

        if ($httpClient === null) {
            $httpClient = new Client();
        }

        $this->register('file', new Parser\File($this));
        $this->register('http', new Parser\Http($this, $httpClient, false));
        $this->register('https', new Parser\Http($this, $httpClient, true));
        $this->register('php', new Parser\Popo());
        $this->register('php+class', new Parser\Popo());
        $this->register('php+doc', new Parser\Documentor());
        $this->register('php+schema', new Parser\SchemaClass($this));
        $this->register('typehub', new Parser\TypeHub($this, $httpClient));
    }

    public function register(string $scheme, ParserInterface $parser): void
    {
        $this->parsers[$scheme] = $parser;
    }

    public function getSchema(string|SchemaSource $source, ?ContextInterface $context = null): SchemaInterface
    {
        $item = null;
        if (!$this->debug) {
            $item = $this->cache->getItem('psx-schema-' . md5((string) $source));
            if ($item->isHit()) {
                return $item->get();
            }
        }

        if (is_string($source)) {
            $source = SchemaSource::fromString($source);
        }

        if (isset($this->parsers[$source->getScheme()])) {
            $schema = $this->parsers[$source->getScheme()]->parse($source->getSource(), $context);
        } else {
            throw new InvalidSchemaException('Schema ' . $source . ' does not exist');
        }

        if (!$this->debug && $item !== null) {
            $schema = new Schema($schema->getDefinitions(), $schema->getRoot());
            $item->set($schema);
            $this->cache->save($item);
        }

        return $schema;
    }

    public function clear(string|SchemaSource $source): void
    {
        $this->cache->deleteItem('psx-schema-' . md5((string) $source));
    }
}
