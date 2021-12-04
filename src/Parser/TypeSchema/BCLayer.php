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

namespace PSX\Schema\Parser\TypeSchema;

/**
 * BCLayer
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class BCLayer
{
    /**
     * This method takes a look at the schema and adds missing properties
     *
     * @param \stdClass $data
     * @return \stdClass
     */
    public static function transform(\stdClass $data): \stdClass
    {
        if (isset($data->patternProperties) && !isset($data->properties) && !isset($data->additionalProperties)) {
            // in this case we have a schema with only pattern properties
            $vars = get_object_vars($data->patternProperties);
            if (count($vars) === 1) {
                $data->additionalProperties = reset($vars);
            } else {
                $data->additionalProperties = true;
            }
        }

        if (isset($data->{'$extends'})) {
            if (!isset($data->type)) {
                $data->type = 'object';
            }
            if (!isset($data->properties)) {
                $data->properties = new \stdClass();
            }
        }

        if (!isset($data->type)) {
            if (isset($data->properties) || isset($data->additionalProperties)) {
                $data->type = 'object';
            } elseif (isset($data->items)) {
                $data->type = 'array';
            } elseif (isset($data->pattern) || isset($data->minLength) || isset($data->maxLength)) {
                $data->type = 'string';
            } elseif (isset($data->minimum) || isset($data->maximum)) {
                $data->type = 'number';
            }
        }

        if (isset($data->type) && $data->type === 'object') {
            if (!isset($data->properties) && !isset($data->additionalProperties)) {
                $data->properties = new \stdClass();
            }
        }

        return $data;
    }
}
