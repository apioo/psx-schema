<?php
/*
 * PSX is an open source PHP framework to develop RESTful APIs.
 * For the current version and information visit <https://phpsx.org>
 *
 * Copyright 2010-2022 Christoph Kappestein <christoph.kappestein@gmail.com>
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
use PSX\Schema\Exception\InvalidSchemaException;
use PSX\Schema\Parser\TypeSchema\ImportResolver;

/**
 * SchemaManager
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class SchemaManager implements SchemaManagerInterface
{
    public const TYPE_TYPESCHEMA = 'typeschema';
    public const TYPE_CLASS      = 'class';
    public const TYPE_ANNOTATION = 'annotation';

    /**
     * @deprecated
     */
    public const TYPE_JSONSCHEMA = 'typeschema';

    /**
     * @var \PSX\Schema\Parser\Popo
     */
    private $popoParser;

    /**
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var boolean
     */
    private $debug;

    /**
     * @var ImportResolver
     */
    private $resolver;

    /**
     * @param \Doctrine\Common\Annotations\Reader|null $reader
     * @param \Psr\Cache\CacheItemPoolInterface|null $cache
     * @param boolean $debug
     * @param ImportResolver|null $resolver
     */
    public function __construct(Reader $reader = null, CacheItemPoolInterface $cache = null, bool $debug = false, ?ImportResolver $resolver = null)
    {
        if ($reader === null) {
            $reader = new SimpleAnnotationReader();
            $reader->addNamespace('PSX\\Schema\\Annotation');
        }

        if ($resolver === null) {
            $resolver = ImportResolver::createDefault(new Client());
        }

        $this->popoParser = new Parser\Popo($reader);
        $this->cache      = $cache === null ? new Pool(new ArrayCache()) : $cache;
        $this->debug      = $debug;
        $this->resolver   = $resolver;
    }

    /**
     * @inheritdoc
     */
    public function getSchema(string $schemaName, ?string $type = null): SchemaInterface
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
            $schema = Parser\TypeSchema::fromFile($schemaName, $this->resolver);
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
