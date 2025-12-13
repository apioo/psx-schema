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
use stdClass;

/**
 * Transform an existing JSON Schema to a valid TypeSchema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class JsonSchema implements TransformerInterface
{
    public function transform(stdClass $schema): stdClass
    {
        $keywords = [];
        $definitions = new stdClass();
        foreach (get_object_vars($schema) as $key => $value) {
            if ($key === 'definitions' || $key === '$defs') {
                $definitions = $value;
            } else {
                $keywords[$key] = $value;
            }
        }

        $defs = [];
        if ($definitions instanceof stdClass) {
            foreach (get_object_vars($definitions) as $name => $type) {
                if ($type instanceof stdClass) {
                    $defs[$name] = $this->convertSchema($type, $defs, false);
                }
            }
        }

        $root = null;
        if (!empty($keywords)) {
            $typeName = null;
            $this->convertSchema((object) $keywords, $defs, false, $typeName);
            if (empty($typeName)) {
                throw new TransformerException('The root schema must be an object');
            }

            $root = $typeName;
        }

        $result = new stdClass();
        $result->definitions = $defs;
        if ($root !== null) {
            $result->root = $root;
        }

        return $result;
    }

    private function convertSchema(stdClass $schema, array &$definitions, bool $isProperty, ?string &$typeName = null): stdClass
    {
        $isObject = isset($schema->type) && $schema->type === 'object' && isset($schema->properties) && $schema->properties instanceof stdClass;

        if ($isProperty && !$isObject) {
            $schema = BCLayer::transformProperty($schema);
        } else {
            $schema = BCLayer::transformDefinition($schema);
        }

        $result = [];
        if (isset($schema->description)) {
            $result['description'] = $schema->description;
        }

        $type = $schema->type ?? null;
        if ($type === 'struct') {
            $title = $schema->title ?? 'Inline' . substr(md5(json_encode($schema)), 0, 8);

            if (isset($schema->properties) && $schema->properties instanceof stdClass) {
                $properties = [];
                foreach (get_object_vars($schema->properties) as $name => $value) {
                    $properties[$name] = $this->convertSchema($value, $definitions, true);
                }

                $result['type'] = 'struct';
                $result['properties'] = $properties;
            } else {
                // some schemas contain only the object keyword to indicate that any objects are allowed at TypeSchema
                // this is not possible so we use a map with any types
                $result['type'] = 'map';
                $result['schema'] = (object) [
                    'type' => 'any'
                ];
            }

            $definitions[$title] = $result;

            $typeName = $title;

            if ($isProperty) {
                $result = [];
                $result['type'] = 'reference';
                $result['target'] = $title;
            }
        } elseif ($type === 'map') {
            $title = $schema->title ?? 'Inline' . substr(md5(json_encode($schema)), 0, 8);

            $result['type'] = 'map';
            if (isset($schema->additionalProperties) && $schema->additionalProperties instanceof stdClass) {
                $result['schema'] = $this->convertSchema($schema->additionalProperties, $definitions, true);
            } else {
                throw new TransformerException('Map must contain an additionalProperties property');
            }

            if (!$isProperty) {
                $definitions[$title] = $result;
                $typeName = $title;
            }
        } elseif ($type === 'array') {
            $title = $schema->title ?? 'Inline' . substr(md5(json_encode($schema)), 0, 8);

            $result['type'] = 'array';
            if (isset($schema->items) && $schema->items instanceof stdClass) {
                $result['schema'] = $this->convertSchema($schema->items, $definitions, true);
            } else {
                throw new TransformerException('Array must contain an items property');
            }

            if (!$isProperty) {
                $definitions[$title] = $result;
                $typeName = $title;
            }
        } elseif ($type === 'string' || $type === 'boolean' || $type === 'number' || $type === 'integer') {
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
}
