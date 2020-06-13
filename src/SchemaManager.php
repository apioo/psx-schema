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

namespace PSX\Schema;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Annotations\SimpleAnnotationReader;
use Doctrine\Common\Cache\ArrayCache;
use InvalidArgumentException;
use Psr\Cache\CacheItemPoolInterface;
use PSX\Cache\Pool;
use PSX\Http\Client\Client;
use PSX\Schema\Parser\TypeSchema\ImportResolver;

/**
 * SchemaManager
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaManager implements SchemaManagerInterface
{
    const TYPE_TYPESCHEMA = 'typeschema';
    const TYPE_CLASS      = 'class';
    const TYPE_ANNOTATION = 'annotation';

    /**
     * @deprecated
     */
    const TYPE_JSONSCHEMA = 'jsonschema';

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
     * @var \PSX\Http\Client\ClientInterface
     */
    protected $httpClient;

    /**
     * @param \Doctrine\Common\Annotations\Reader|null $reader
     * @param \Psr\Cache\CacheItemPoolInterface|null $cache
     * @param boolean $debug
     */
    public function __construct(Reader $reader = null, CacheItemPoolInterface $cache = null, $debug = false)
    {
        if ($reader === null) {
            $reader = new SimpleAnnotationReader();
            $reader->addNamespace('PSX\\Schema\\Annotation');
        }

        $this->popoParser = new Parser\Popo($reader);
        $this->cache      = $cache === null ? new Pool(new ArrayCache()) : $cache;
        $this->debug      = $debug;
        $this->httpClient = new Client();
    }

    /**
     * @inheritdoc
     */
    public function getSchema($schemaName, $type = null)
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

        if ($type === null) {
            $type = $this->guessTypeFromSchema($schemaName);
        }

        if ($type === self::TYPE_TYPESCHEMA) {
            $resolver = ImportResolver::createDefault($this->httpClient);
            $schema = Parser\TypeSchema::fromFile($schemaName, $resolver);
        } elseif ($type === self::TYPE_CLASS) {
            $schema = new $schemaName($this);
        } elseif ($type === self::TYPE_ANNOTATION) {
            $schema = $this->popoParser->parse($schemaName);
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

    /**
     * @param string $schemaName
     * @return string|null
     */
    private function guessTypeFromSchema($schemaName)
    {
        if (strpos($schemaName, '.') !== false) {
            return self::TYPE_TYPESCHEMA;
        } elseif (class_exists($schemaName)) {
            if (in_array(SchemaInterface::class, class_implements($schemaName))) {
                return self::TYPE_CLASS;
            } else {
                return self::TYPE_ANNOTATION;
            }
        } else {
            return null;
        }
    }
}
