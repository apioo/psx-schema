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

namespace PSX\Schema\Generator;

use JsonException;
use PSX\Json\Parser;
use PSX\Schema\DefinitionsInterface;
use PSX\Schema\Exception\GeneratorException;
use PSX\Schema\Exception\TypeNotFoundException;
use PSX\Schema\GeneratorInterface;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Type\AnyPropertyType;
use PSX\Schema\Type\ArrayTypeInterface;
use PSX\Schema\Type\Factory\PropertyTypeFactory;
use PSX\Schema\Type\GenericPropertyType;
use PSX\Schema\Type\MapTypeInterface;
use PSX\Schema\Type\PropertyTypeAbstract;
use PSX\Schema\Type\ReferencePropertyType;
use PSX\Schema\Type\ScalarPropertyType;
use PSX\Schema\Type\StructDefinitionType;
use PSX\Schema\TypeInterface;
use PSX\Schema\TypeUtil;

/**
 * JsonSchemaOpenAI
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class JsonSchemaOpenAI extends JsonSchema
{
    public function __construct(?Config $config = null)
    {
        parent::__construct(self::getConfig($config));
    }

    public static function getConfig(?Config $parentConfig = null): Config
    {
        $config = new Config();
        $config->put('inline_definitions', false);
        $config->put('defs_keyword', true);
        $config->put('all_properties_required', true);
        $config->put('additional_properties_false', true);
        $config->put('any_of_discriminated_union', true);
        $config->put('resolve_parent_properties', true);
        $config->put('any_of_nullable', false);
        $config->put('type_nullable', true);
        $config->put('discriminated_value_as_enum', true);
        $config->put('remove_deprecated_property', true);
        $config->put('remove_nullable_property', true);
        $config->put('remove_default_property', true);
        $config->put('remove_format_property', true);
        $config->put('any_value_as_string', true);
        $config->put('normalize_property_names', true);

        if ($parentConfig !== null) {
            $config->putAll($parentConfig);
        }

        return $config;
    }
}
