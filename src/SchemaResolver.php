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

use PSX\Schema\Type\ReferenceType;

/**
 * SchemaResolver
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class SchemaResolver
{
    /**
     * Removes all types from the schema definitions which are not used at the root schema
     * 
     * @param SchemaInterface $schema
     * @return void
     */
    public function resolve(SchemaInterface $schema): void
    {
        $types = [];

        $this->lookupTypes($schema->getType(), $types);
        foreach ($schema->getDefinitions()->getAllTypes() as $name => $type) {
            $this->lookupTypes($type, $types);
        }

        foreach ($schema->getDefinitions()->getAllTypes() as $name => $type) {
            if (!in_array($name, $types)) {
                $schema->getDefinitions()->removeType($name);
            }
        }
    }

    private function lookupTypes(TypeInterface $type, array &$types)
    {
        TypeUtil::walk($type, function(TypeInterface $type) use (&$types){
            if (!$type instanceof ReferenceType) {
                return;
            }

            $name = TypeUtil::getFullyQualifiedName($type->getRef());

            if (in_array($name, $types)) {
                // we have the type already
                return;
            }

            $types[] = $name;
        });
    }
}
