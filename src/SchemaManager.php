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
        $this->register('php+schema', new Parser\SchemaClass($this));
        $this->register('typehub', new Parser\TypeHub($this, $httpClient));
    }

    public function register(string $scheme, ParserInterface $parser): void
    {
        $this->parsers[$scheme] = $parser;
    }

    public function getSchema(string $schemaName, ?ContextInterface $context = null): SchemaInterface
    {
        $item = null;
        if (!$this->debug) {
            $item = $this->cache->getItem('psx-schema-' . md5($schemaName));
            if ($item->isHit()) {
                return $item->get();
            }
        }

        $pos = strpos($schemaName, '://');
        if ($pos === false) {
            $schemaName = $this->guessSchemeFromSchemaName($schemaName);
            $pos = strpos($schemaName, '://');
        }

        if ($pos === false) {
            throw new InvalidSchemaException('Could not resolve schema uri');
        }

        $scheme = substr($schemaName, 0, $pos);
        $value = substr($schemaName, $pos + 3);
        if (isset($this->parsers[$scheme])) {
            $schema = $this->parsers[$scheme]->parse($value, $context);
        } else {
            throw new InvalidSchemaException('Schema ' . $schemaName . ' does not exist');
        }

        if (!$this->debug && $item !== null) {
            $schema = new Schema($schema->getType(), $schema->getDefinitions());
            $item->set($schema);
            $this->cache->save($item);
        }

        return $schema;
    }

    public function clear(string $schemaName): void
    {
        $this->cache->deleteItem('psx-schema-' . md5($schemaName));
    }

    private function guessSchemeFromSchemaName(string $schemaName): ?string
    {
        if (class_exists($schemaName)) {
            if (in_array(SchemaInterface::class, class_implements($schemaName))) {
                return 'php+schema://' . str_replace('\\', '.', $schemaName);
            } else {
                return 'php://' . str_replace('\\', '.', $schemaName);
            }
        } elseif (is_file($schemaName)) {
            return 'file://' . $schemaName;
        } else {
            return $schemaName;
        }
    }
}
