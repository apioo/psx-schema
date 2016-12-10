<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Cache\ArrayCache;
use InvalidArgumentException;
use Psr\Cache\CacheItemPoolInterface;
use PSX\Cache\Pool;
use PSX\Http\Client;
use PSX\Http\ClientInterface;
use PSX\Schema\Parser\JsonSchema\RefResolver;

/**
 * SchemaManager
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaManager implements SchemaManagerInterface
{
    /**
     * @var \PSX\Schema\Parser\Popo
     */
    protected $popoParser;

    /**
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    protected $cache;

    /**
     * @var boolean
     */
    protected $debug;

    /**
     * @var \PSX\Http\ClientInterface
     */
    protected $httpClient;

    public function __construct(Reader $annotationReader, CacheItemPoolInterface $cache = null, $debug = false)
    {
        $this->popoParser = new Parser\Popo($annotationReader);
        $this->cache      = $cache === null ? new Pool(new ArrayCache()) : $cache;
        $this->debug      = $debug;
        $this->httpClient = new Client();
    }

    public function getSchema($schemaName)
    {
        if (!is_string($schemaName)) {
            throw new InvalidArgumentException('Schema name must be a string');
        }

        $item = null;
        if (!$this->debug) {
            $item = $this->cache->getItem($schemaName);
            if ($item->isHit()) {
                return $item->get();
            }
        }

        if (strpos($schemaName, '.') !== false) {
            $resolver = RefResolver::createDefault($this->httpClient);
            $schema   = Parser\JsonSchema::fromFile($schemaName, $resolver);
        } elseif (class_exists($schemaName)) {
            if (in_array(SchemaInterface::class, class_implements($schemaName))) {
                $schema = new $schemaName($this);
            } else {
                $schema = $this->popoParser->parse($schemaName);
            }
        } else {
            throw new InvalidSchemaException('Schema ' . $schemaName . ' does not exist');
        }

        if (!$this->debug && $item !== null) {
            $schema = new Schema($schema->getDefinition());
            $item->set($schema);
            $this->cache->save($item);
        }

        return $schema;
    }
}
