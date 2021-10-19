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

namespace PSX\Schema\Transformer;

use PSX\Schema\Exception\TransformerException;

/**
 * Transform an existing JSON Schema to a valid TypeSchema
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class JsonSchema
{
    public function convert(string $schema): string
    {
        $data = \json_decode($schema);
        if (!$data instanceof \stdClass) {
            throw new TransformerException('Provided schema must be an object');
        }

        $keywords = [];
        $definitions = new \stdClass();
        foreach ($data as $key => $value) {
            if ($key === 'definitions' || $key === '$defs') {
                $definitions = $value;
            } else {
                $keywords[$key] = $value;
            }
        }

        $defs = [];
        if ($definitions instanceof \stdClass) {
            foreach ($definitions as $name => $type) {
                $defs[$name] = $this->convertSchema($type, $defs);
            }
        }

        $root = null;
        if (!empty($keywords)) {
            $result = $this->convertSchema((object) $keywords, $defs);
            if (!isset($result->{'$ref'})) {
                throw new TransformerException('The root schema must be an object');
            }

            $root = $result->{'$ref'};
        }

        $result = new \stdClass();
        $result->definitions = $defs;
        if ($root !== null) {
            $result->{'$ref'} = $root;
        }

        return \json_encode($result);
    }

    private function convertSchema(\stdClass $schema, array &$definitions): \stdClass
    {
        if (!isset($schema->type)) {
            if (isset($schema->properties) || isset($schema->additionalProperties)) {
                $schema->type = 'object';
            } elseif (isset($schema->items)) {
                $schema->type = 'array';
            } elseif (isset($schema->pattern) || isset($schema->minLength) || isset($schema->maxLength)) {
                $schema->type = 'string';
            } elseif (isset($schema->minimum) || isset($schema->maximum)) {
                $schema->type = 'number';
            }
        }

        $type = $schema->type ?? null;
        if ($type === 'object') {
            $title = $schema->title ?? 'Inline' . substr(md5(json_encode($schema)), 0, 8);

            if (isset($schema->properties) && $schema->properties instanceof \stdClass) {
                $properties = [];
                foreach ($schema->properties as $key => $value) {
                    $properties[$key] = $this->convertSchema($value, $definitions);
                }

                $result = (object) [
                    'type' => 'object',
                    'properties' => $properties,
                ];

                if (isset($schema->required) && is_array($schema->required)) {
                    $result->required = $schema->required;
                }
            } elseif (isset($schema->additionalProperties)) {
                $result = (object) [
                    'type' => 'object',
                    'additionalProperties' => $this->convertSchema($schema->additionalProperties, $definitions),
                ];
            } else {
                throw new TransformerException('Could not assign object type to either a struct or map');
            }

            $definitions[$title] = $result;

            return (object) [
                '$ref' => $title,
            ];
        } elseif ($type === 'array') {
            $result = [
                'type' => $type
            ];

            if (isset($schema->items)) {
                $result['items'] = $this->convertSchema($schema->items, $definitions);
            }

            return (object) $result;
        } elseif ($type === 'string') {
            $result = [
                'type' => $type
            ];
            $allowedKeywords = ['maxLength', 'minLength', 'pattern'];
            foreach ($allowedKeywords as $keyword) {
                if (isset($schema->{$keyword})) {
                    $result[$keyword] = $keyword;
                }
            }

            return (object) $result;
        } elseif ($type === 'boolean') {
            $result = [
                'type' => $type
            ];

            return (object) $result;
        } elseif ($type === 'number' || $type === 'integer') {
            $result = [
                'type' => $type
            ];
            $allowedKeywords = ['multipleOf', 'maximum', 'exclusiveMaximum', 'minimum', 'exclusiveMinimum'];
            foreach ($allowedKeywords as $keyword) {
                if (isset($schema->{$keyword})) {
                    $result[$keyword] = $keyword;
                }
            }

            return (object) $result;
        }

        if (isset($schema->oneOf) && is_array($schema->oneOf)) {
            $result = [];
            foreach ($schema->oneOf as $subSchema) {
                $result[] = $this->convertSchema($subSchema, $definitions);
            }

            return (object) [
                'oneOf' => $result
            ];
        } elseif (isset($schema->allOf) && is_array($schema->allOf)) {
            $result = [];
            foreach ($schema->allOf as $subSchema) {
                $result[] = $this->convertSchema($subSchema, $definitions);
            }

            return (object) [
                'allOf' => $result
            ];
        }

        return (object) [
            'type' => 'any'
        ];
    }
}
