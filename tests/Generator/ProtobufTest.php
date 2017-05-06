<?php
/*
 * PSX is a open source PHP framework to develop RESTful APIs.
 * For the current version and informations visit <http://phpsx.org>
 *
 * Copyright 2010-2016 Christoph Kappestein <k42b3.x@gmail.com>
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

namespace PSX\Schema\Tests\Generator;

use PSX\Schema\Generator\JsonSchema;
use PSX\Schema\Generator\Proto;
use PSX\Schema\Generator\Protobuf;
use PSX\Schema\Parser;

/**
 * ProtobufTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class ProtobufTest extends GeneratorTestCase
{
    /**
     * Note this test generates a proto definition which is invalid since the
     * map type is not allowed in oneof and oneof must not be repeated. It is
     * the liability of the developer to use a valid schema
     */
    public function testGenerate()
    {
        $generator = new Protobuf();
        $actual    = $generator->generate($this->getSchema());
        $expect    = <<<'TEXT'
syntax = "proto3";
message News {
  map<string, string> config = 1;
  repeated string tags = 2;
  repeated Author receiver = 3;
  repeated oneof resource { Location location = 4; map<string, string> web = 5; }
  bytes profileImage = 6;
  bool read = 7;
  oneof source { Author author = 8; map<string, string> web = 9; }
  Author author = 10;
  Meta meta = 11;
  string sendDate = 12;
  string readDate = 13;
  string expires = 14;
  float price = 15;
  int32 rating = 16;
  string content = 17;
  string question = 18;
  string coffeeTime = 19;
  string profileUri = 20;
}
message Author {
  string title = 1;
  string email = 2;
  repeated string categories = 3;
  repeated Location locations = 4;
  Location origin = 5;
}
message Location {
  float lat = 1;
  float long = 2;
}
message Meta {
  string createDate = 1;
}

TEXT;

        $this->assertEquals($expect, $actual, $actual);
    }
}
