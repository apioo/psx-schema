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

namespace PSX\Schema\Parser;

use phpDocumentor\Reflection\TypeResolver;
use PSX\Schema\Definitions;
use PSX\Schema\Exception\ParserException;
use PSX\Schema\Exception\TypeNotFoundException;
use PSX\Schema\Schema;
use PSX\Schema\SchemaInterface;
use PSX\Schema\Type\ArrayPropertyType;
use PSX\Schema\Type\Factory\DefinitionTypeFactory;
use PSX\Schema\Type\Factory\PropertyTypeFactory;
use PSX\Schema\Type\MapPropertyType;
use PSX\Schema\Type\ReferencePropertyType;

/**
 * Documentor
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    https://phpsx.org
 */
class Documentor extends Popo
{
    private TypeResolver $typeResolver;
    private Popo\Resolver\Documentor $documentor;

    public function __construct()
    {
        parent::__construct();

        $this->typeResolver = new TypeResolver();
        $this->documentor = new Popo\Resolver\Documentor();
    }

    /**
     * @inheritDoc
     */
    public function parse(string $schema, ?ContextInterface $context = null): SchemaInterface
    {
        $definitions = new Definitions();

        try {
            $typeName = 'InlineType' . substr(md5($schema), 0, 8);

            $result = $this->documentor->buildPropertyType($this->typeResolver->resolve($schema));

            if ($result instanceof MapPropertyType) {
                $schema = $result->getSchema();
                if ($schema instanceof ReferencePropertyType) {
                    $this->parseClass($schema->getTarget(), $definitions, $context, $schemaName);
                    $schema = PropertyTypeFactory::getReference($schemaName);
                }

                $definitions->addType($typeName, DefinitionTypeFactory::getMap($schema));
            } elseif ($result instanceof ArrayPropertyType) {
                $schema = $result->getSchema();
                if ($schema instanceof ReferencePropertyType) {
                    $this->parseClass($schema->getTarget(), $definitions, $context, $schemaName);
                    $schema = PropertyTypeFactory::getReference($schemaName);
                }

                $definitions->addType($typeName, DefinitionTypeFactory::getArray($schema));
            } elseif ($result instanceof ReferencePropertyType) {
                $this->parseClass($result->getTarget(), $definitions, $context, $typeName);
            } else {
                throw new ParserException('Provided an invalid PHP doc schema');
            }
        } catch (\ReflectionException|TypeNotFoundException $e) {
            throw new ParserException('Could not parse schema: ' . $schema, previous: $e);
        }

        return new Schema($definitions, $typeName);
    }
}
