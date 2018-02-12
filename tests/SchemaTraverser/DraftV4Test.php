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

namespace PSX\Schema\Tests\SchemaTraverser;

use PSX\Http\Client\Client;
use PSX\Schema\Parser\JsonSchema;
use PSX\Schema\SchemaTraverser;
use PSX\Schema\ValidationException;

/**
 * DraftV4Test
 *
 * @author  Christoph Kappestein <christoph.kappestein@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class DraftV4Test extends \PHPUnit_Framework_TestCase
{
    public function testDarftV4()
    {
        $tests      = json_decode(file_get_contents(__DIR__ . '/draftv4.json'));
        $traverser  = new SchemaTraverser();
        $httpClient = new Client();

        foreach ($tests as $index => $test) {
            // parse schema
            $resolver = JsonSchema\RefResolver::createDefault($httpClient);
            $parser   = new JsonSchema(null, $resolver);
            $schema   = $parser->parse(json_encode($test->schema));

            try {
                $traverser->traverse($test->data, $schema);

                if ($test->valid === false) {
                    $this->fail('Test ' . $index . ' "' . $test->description . '" should fail');
                }
            } catch (ValidationException $e) {
                if ($test->valid === true) {
                    $this->fail('Test ' . $index . ' "' . $test->description . '" should be valid got: ' . $e->getMessage());
                }
            }
        }
    }
}
