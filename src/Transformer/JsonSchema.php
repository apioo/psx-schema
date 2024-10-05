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

namespace PSX\Schema\Transformer;

use PSX\Schema\Exception\TransformerException;
use PSX\Schema\Parser\TypeSchema\BCLayer;
use PSX\Schema\TransformerInterface;

/**
 * Transform an existing JSON Schema to a valid TypeSchema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class JsonSchema implements TransformerInterface
{
    public function transform(\stdClass $schema): \stdClass
    {
        $keywords = [];
        $definitions = new \stdClass();
        foreach ($schema as $key => $value) {
            if ($key === 'definitions' || $key === '$defs') {
                $definitions = $value;
            } else {
                $keywords[$key] = $value;
            }
        }

        $defs = [];
        if ($definitions instanceof \stdClass) {
            foreach ($definitions as $name => $type) {
                if ($type instanceof \stdClass) {
                    $defs[$name] = $this->convertSchema($type, $defs);
                }
            }
        }

        $root = null;
        if (!empty($keywords)) {
            // in case we have an array at the top level we transform it to an object
            if (isset($keywords['type']) && $keywords['type'] === 'array') {
                $keywords = [
                    'type' => 'struct',
                    'properties' => (object) [
                        'entries' => (object) $keywords,
                    ]
                ];
            }

            $result = $this->convertSchema((object) $keywords, $defs);
            if (!isset($result->{'$ref'})) {
                throw new TransformerException('The root schema must be an object');
            }

            $root = $result->{'$ref'};
        }

        $result = new \stdClass();
        $result->definitions = $defs;
        if ($root !== null) {
            $result->root = $root;
        }

        return $result;
    }

    private function convertSchema(\stdClass $schema, array &$definitions): \stdClass
    {
        $schema = BCLayer::transformDefinition($schema);

        $result = [];
        if (isset($schema->description)) {
            $result['description'] = $schema->description;
        }

        $type = $schema->type ?? null;
        if ($type === 'object') {
            $title = $schema->title ?? 'Inline' . substr(md5(json_encode($schema)), 0, 8);

            if (isset($schema->properties) && $schema->properties instanceof \stdClass) {
                $properties = [];
                foreach ($schema->properties as $name => $value) {
                    $properties[$name] = $this->convertSchema($value, $definitions);
                }

                $result['type'] = 'struct';
                $result['properties'] = $properties;
            } elseif (isset($schema->additionalProperties) && $schema->additionalProperties instanceof \stdClass) {
                $result['type'] = 'map';
                $result['schema'] = $this->convertSchema($schema->additionalProperties, $definitions);
            } else {
                // some schemas contain only the object keyword to indicate that any objects are allowed at TypeSchema
                // this is not possible so we use a map with any types
                return (object) [
                    'type' => 'map',
                    'schema' => [
                        'type' => 'any'
                    ]
                ];
            }

            $definitions[$title] = $result;

            return (object) [
                '$ref' => $title,
            ];
        } elseif ($type === 'array') {
            $result['type'] = 'array';

            if (isset($schema->items) && $schema->items instanceof \stdClass) {
                $result['schema'] = $this->convertSchema($schema->items, $definitions);
            } else {
                throw new TransformerException('Array must contain an items property');
            }
        } elseif ($type === 'string') {
            $result['type'] = 'string';
        } elseif ($type === 'boolean') {
            $result['type'] = 'boolean';
        } elseif ($type === 'number' || $type === 'integer') {
            $result['type'] = $type;
        } elseif (isset($schema->{'$ref'})) {
            $ref = $schema->{'$ref'};
            $ref = str_replace('#/definitions/', '', $ref);
            $ref = str_replace('#/$defs/', '', $ref);
            $ref = str_replace('#/components/schemas/', '', $ref);

            $result['type'] = 'reference';
            $result['target'] = $ref;
        } else {
            $result['type'] = 'any';
        }

        return (object) $result;
    }

    private function copyKeywords(\stdClass $schema, array $result, array $allowedKeywords): array
    {
        foreach ($allowedKeywords as $keyword) {
            if (isset($schema->{$keyword})) {
                $result[$keyword] = $schema->{$keyword};
            }
        }

        return $result;
    }
}
