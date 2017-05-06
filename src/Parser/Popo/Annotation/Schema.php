<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2017 Christoph Kappestein <christoph.kappestein@gmail.com>
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

namespace PSX\Schema\Parser\Popo\Annotation;

/**
 * Schema
 *
 * @Annotation
 * @Target("ALL")
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class Schema
{
    /**
     * @var mixed
     */
    protected $values;

    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function getAnnotations()
    {
        $annotations = [];

        foreach ($this->values as $key => $value) {
            $value = [$value];
            switch ($key) {
                case 'title': $annotations[] = new Title($value); break;
                case 'description': $annotations[] = new Description($value); break;
                case 'enum': $annotations[] = new Enum($value); break;
                case 'type': $annotations[] = new Type($value); break;
                case 'allOf': $annotations[] = new AllOf($value); break;
                case 'anyOf': $annotations[] = new AnyOf($value); break;
                case 'oneOf': $annotations[] = new OneOf($value); break;
                case 'not': $annotations[] = new Not($value); break;

                // number
                case 'maximum': $annotations[] = new Maximum($value); break;
                case 'minimum': $annotations[] = new Minimum($value); break;
                case 'exclusiveMaximum': $annotations[] = new ExclusiveMaximum($value); break;
                case 'exclusiveMinimum': $annotations[] = new ExclusiveMinimum($value); break;
                case 'multipleOf': $annotations[] = new MultipleOf($value); break;

                // string
                case 'maxLength': $annotations[] = new MaxLength($value); break;
                case 'minLength': $annotations[] = new MinLength($value); break;
                case 'pattern': $annotations[] = new Pattern($value); break;
                case 'format': $annotations[] = new Format($value); break;

                // array
                case 'items': $annotations[] = new Items($value); break;
                case 'additionalItems': $annotations[] = new AdditionalItems($value); break;
                case 'uniqueItems': $annotations[] = new UniqueItems($value); break;
                case 'maxItems': $annotations[] = new MaxItems($value); break;
                case 'minItems': $annotations[] = new MinItems($value); break;
            }
        }

        return $annotations;
    }
}
