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
use PSX\Schema\Exception\InvalidSchemaException;
use PSX\Schema\Parser\TypeSchema\ImportResolver;
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
    public const TYPE_TYPESCHEMA = 'typeschema';
    public const TYPE_CLASS      = 'class';
    public const TYPE_ANNOTATION = 'annotation';

    /**
     * @deprecated
     */
    public const TYPE_JSONSCHEMA = 'typeschema';

    private Parser\Popo $popoParser;
    private ?CacheItemPoolInterface $cache;
    private bool $debug;
    private ImportResolver $resolver;

    public function __construct(?CacheItemPoolInterface $cache = null, bool $debug = false, ?ImportResolver $resolver = null)
    {
        if ($resolver === null) {
            $resolver = ImportResolver::createDefault(new Client());
        }

        $this->popoParser = new Parser\Popo();
        $this->cache      = $cache === null ? new ArrayAdapter() : $cache;
        $this->debug      = $debug;
        $this->resolver   = $resolver;
    }

    public function getSchema(string $schemaName, ?string $type = null): SchemaInterface
    {
        $item = null;
        if (!$this->debug) {
            $item = $this->cache->getItem(md5($schemaName));
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

    private function guessTypeFromSchema(string $schemaName): ?string
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
