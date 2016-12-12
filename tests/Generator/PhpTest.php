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

use PSX\Schema\Generator\Php;
use PSX\Schema\Parser;

/**
 * PhpTest
 *
 * @author  Christoph Kappestein <k42b3.x@gmail.com>
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @link    http://phpsx.org
 */
class PhpTest extends GeneratorTestCase
{
    public function testGenerate()
    {
        $generator = new Php(__NAMESPACE__);
        $result    = $generator->generate($this->getSchema());

        $expect = <<<'PHP'
<?php

namespace PSX\Schema\Tests\Generator;

/**
 * @Title("meta")
 * @Description("Some meta data")
 * @PatternProperties(pattern="^tags_\d$", property=@Schema(type="string"))
 * @PatternProperties(pattern="^location_\d$", property=@Ref("PSX\Schema\Tests\Generator\Location"))
 * @AdditionalProperties(false)
 */
class Meta extends \ArrayObject
{
    /**
     * @Key("createDate")
     * @Type("string")
     * @Format("date-time")
     */
    public $createDate;
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }
    public function getCreateDate()
    {
        return $this->createDate;
    }
}
/**
 * @Title("web")
 * @Description("An application")
 * @AdditionalProperties(@Schema(type="string"))
 * @Required({"name", "url"})
 * @MinProperties(2)
 * @MaxProperties(8)
 */
class Web extends \ArrayObject
{
    /**
     * @Key("name")
     * @Type("string")
     */
    public $name;
    /**
     * @Key("url")
     * @Type("string")
     */
    public $url;
    public function setName($name)
    {
        $this->name = $name;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
}
/**
 * @Title("location")
 * @Description("Location of the person")
 * @AdditionalProperties(true)
 * @Required({"lat", "long"})
 */
class Location extends \ArrayObject
{
    /**
     * @Key("lat")
     * @Type("number")
     */
    public $lat;
    /**
     * @Key("long")
     * @Type("number")
     */
    public $long;
    public function setLat($lat)
    {
        $this->lat = $lat;
    }
    public function getLat()
    {
        return $this->lat;
    }
    public function setLong($long)
    {
        $this->long = $long;
    }
    public function getLong()
    {
        return $this->long;
    }
}
/**
 * @Title("author")
 * @Description("An simple author element with some description")
 * @AdditionalProperties(false)
 * @Required({"title"})
 */
class Author
{
    /**
     * @Key("title")
     * @Type("string")
     * @Pattern("[A-z]{3,16}")
     */
    public $title;
    /**
     * @Key("email")
     * @Description("We will send no spam to this addresss")
     * @Type("string")
     */
    public $email;
    /**
     * @Key("categories")
     * @Type("array")
     * @Items(@Schema(type="string"))
     * @MaxItems(8)
     */
    public $categories;
    /**
     * @Key("locations")
     * @Description("Array of locations")
     * @Type("array")
     * @Items(@Ref("PSX\Schema\Tests\Generator\Location"))
     */
    public $locations;
    /**
     * @Key("origin")
     * @Ref("PSX\Schema\Tests\Generator\Location")
     */
    public $origin;
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }
    public function getCategories()
    {
        return $this->categories;
    }
    public function setLocations($locations)
    {
        $this->locations = $locations;
    }
    public function getLocations()
    {
        return $this->locations;
    }
    public function setOrigin($origin)
    {
        $this->origin = $origin;
    }
    public function getOrigin()
    {
        return $this->origin;
    }
}
/**
 * @Title("config")
 * @AdditionalProperties(@Schema(type="string"))
 */
class Config extends \ArrayObject
{
}
/**
 * @Title("news")
 * @Description("An general news entry")
 * @AdditionalProperties(false)
 * @Required({"receiver", "price", "content"})
 */
class News
{
    /**
     * @Key("config")
     * @Ref("PSX\Schema\Tests\Generator\Config")
     */
    public $config;
    /**
     * @Key("tags")
     * @Type("array")
     * @Items(@Schema(type="string"))
     * @MaxItems(6)
     * @MinItems(1)
     */
    public $tags;
    /**
     * @Key("receiver")
     * @Type("array")
     * @Items(@Ref("PSX\Schema\Tests\Generator\Author"))
     * @MinItems(1)
     */
    public $receiver;
    /**
     * @Key("resources")
     * @Type("array")
     * @Items(@Schema(oneOf={@Ref("PSX\Schema\Tests\Generator\Location"), @Ref("PSX\Schema\Tests\Generator\Web")}))
     */
    public $resources;
    /**
     * @Key("profileImage")
     * @Type("string")
     * @Format("base64")
     */
    public $profileImage;
    /**
     * @Key("read")
     * @Type("boolean")
     */
    public $read;
    /**
     * @Key("source")
     * @OneOf(@Ref("PSX\Schema\Tests\Generator\Author"), @Ref("PSX\Schema\Tests\Generator\Web"))
     */
    public $source;
    /**
     * @Key("author")
     * @Ref("PSX\Schema\Tests\Generator\Author")
     */
    public $author;
    /**
     * @Key("meta")
     * @Ref("PSX\Schema\Tests\Generator\Meta")
     */
    public $meta;
    /**
     * @Key("sendDate")
     * @Type("string")
     * @Format("date")
     */
    public $sendDate;
    /**
     * @Key("readDate")
     * @Type("string")
     * @Format("date-time")
     */
    public $readDate;
    /**
     * @Key("expires")
     * @Type("string")
     * @Format("duration")
     */
    public $expires;
    /**
     * @Key("price")
     * @Type("number")
     * @Maximum(100)
     * @Minimum(1)
     */
    public $price;
    /**
     * @Key("rating")
     * @Type("integer")
     * @Maximum(5)
     * @Minimum(1)
     */
    public $rating;
    /**
     * @Key("content")
     * @Description("Contains the main content of the news entry")
     * @Type("string")
     * @MaxLength(512)
     * @MinLength(3)
     */
    public $content;
    /**
     * @Key("question")
     * @Enum({"foo", "bar"})
     * @Type("string")
     */
    public $question;
    /**
     * @Key("coffeeTime")
     * @Type("string")
     * @Format("time")
     */
    public $coffeeTime;
    /**
     * @Key("profileUri")
     * @Type("string")
     * @Format("uri")
     */
    public $profileUri;
    public function setConfig($config)
    {
        $this->config = $config;
    }
    public function getConfig()
    {
        return $this->config;
    }
    public function setTags($tags)
    {
        $this->tags = $tags;
    }
    public function getTags()
    {
        return $this->tags;
    }
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }
    public function getReceiver()
    {
        return $this->receiver;
    }
    public function setResources($resources)
    {
        $this->resources = $resources;
    }
    public function getResources()
    {
        return $this->resources;
    }
    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;
    }
    public function getProfileImage()
    {
        return $this->profileImage;
    }
    public function setRead($read)
    {
        $this->read = $read;
    }
    public function getRead()
    {
        return $this->read;
    }
    public function setSource($source)
    {
        $this->source = $source;
    }
    public function getSource()
    {
        return $this->source;
    }
    public function setAuthor($author)
    {
        $this->author = $author;
    }
    public function getAuthor()
    {
        return $this->author;
    }
    public function setMeta($meta)
    {
        $this->meta = $meta;
    }
    public function getMeta()
    {
        return $this->meta;
    }
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;
    }
    public function getSendDate()
    {
        return $this->sendDate;
    }
    public function setReadDate($readDate)
    {
        $this->readDate = $readDate;
    }
    public function getReadDate()
    {
        return $this->readDate;
    }
    public function setExpires($expires)
    {
        $this->expires = $expires;
    }
    public function getExpires()
    {
        return $this->expires;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
    public function getRating()
    {
        return $this->rating;
    }
    public function setContent($content)
    {
        $this->content = $content;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function setQuestion($question)
    {
        $this->question = $question;
    }
    public function getQuestion()
    {
        return $this->question;
    }
    public function setCoffeeTime($coffeeTime)
    {
        $this->coffeeTime = $coffeeTime;
    }
    public function getCoffeeTime()
    {
        return $this->coffeeTime;
    }
    public function setProfileUri($profileUri)
    {
        $this->profileUri = $profileUri;
    }
    public function getProfileUri()
    {
        return $this->profileUri;
    }
}
PHP;

        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);

        $this->assertEquals($expect, $result, $result);
    }

    public function testGenerateRecursive()
    {
        $schema    = Parser\JsonSchema::fromFile(__DIR__ . '/../Parser/JsonSchema/schema.json');
        $generator = new Php();
        $actual    = $generator->generate($schema);
        $expect    = <<<'PHP'
<?php

namespace PSX\Generation;

/**
 * @AdditionalProperties(@Schema(anyOf={@Ref("PSX\Generation\Json_schema"), @Schema(type="array", items=@Schema(type="string"), minItems=1, uniqueItems=true)}))
 */
class ObjectId extends \ArrayObject
{
}
/**
 * @AdditionalProperties(@Ref("PSX\Generation\Json_schema"))
 */
class ObjectId extends \ArrayObject
{
}
/**
 * @Title("json schema")
 * @Description("Core schema meta-schema")
 */
class Json_schema
{
    /**
     * @Key("id")
     * @Type("string")
     * @Format("uri")
     */
    public $id;
    /**
     * @Key("$schema")
     * @Type("string")
     * @Format("uri")
     */
    public $_schema;
    /**
     * @Key("title")
     * @Type("string")
     */
    public $title;
    /**
     * @Key("description")
     * @Type("string")
     */
    public $description;
    /**
     * @Key("default")
     */
    public $default;
    /**
     * @Key("multipleOf")
     * @Type("number")
     * @Minimum(0)
     * @ExclusiveMinimum(true)
     */
    public $multipleOf;
    /**
     * @Key("maximum")
     * @Type("number")
     */
    public $maximum;
    /**
     * @Key("exclusiveMaximum")
     * @Type("boolean")
     */
    public $exclusiveMaximum;
    /**
     * @Key("minimum")
     * @Type("number")
     */
    public $minimum;
    /**
     * @Key("exclusiveMinimum")
     * @Type("boolean")
     */
    public $exclusiveMinimum;
    /**
     * @Key("maxLength")
     * @Type("integer")
     * @Minimum(0)
     */
    public $maxLength;
    /**
     * @Key("minLength")
     * @AllOf(@Schema(type="integer", minimum=0), @Schema())
     */
    public $minLength;
    /**
     * @Key("pattern")
     * @Type("string")
     * @Format("regex")
     */
    public $pattern;
    /**
     * @Key("additionalItems")
     * @AnyOf(@Schema(type="boolean"), @Ref("PSX\Generation\Json_schema"))
     */
    public $additionalItems;
    /**
     * @Key("items")
     * @AnyOf(@Ref("PSX\Generation\Json_schema"), @Schema(type="array", items=@Ref("PSX\Generation\Json_schema"), minItems=1))
     */
    public $items;
    /**
     * @Key("maxItems")
     * @Type("integer")
     * @Minimum(0)
     */
    public $maxItems;
    /**
     * @Key("minItems")
     * @AllOf(@Schema(type="integer", minimum=0), @Schema())
     */
    public $minItems;
    /**
     * @Key("uniqueItems")
     * @Type("boolean")
     */
    public $uniqueItems;
    /**
     * @Key("maxProperties")
     * @Type("integer")
     * @Minimum(0)
     */
    public $maxProperties;
    /**
     * @Key("minProperties")
     * @AllOf(@Schema(type="integer", minimum=0), @Schema())
     */
    public $minProperties;
    /**
     * @Key("required")
     * @Type("array")
     * @Items(@Schema(type="string"))
     * @UniqueItems(true)
     * @MinItems(1)
     */
    public $required;
    /**
     * @Key("additionalProperties")
     * @AnyOf(@Schema(type="boolean"), @Ref("PSX\Generation\Json_schema"))
     */
    public $additionalProperties;
    /**
     * @Key("definitions")
     * @Ref("PSX\Generation\ObjectId")
     */
    public $definitions;
    /**
     * @Key("properties")
     * @Ref("PSX\Generation\ObjectId")
     */
    public $properties;
    /**
     * @Key("patternProperties")
     * @Ref("PSX\Generation\ObjectId")
     */
    public $patternProperties;
    /**
     * @Key("dependencies")
     * @Ref("PSX\Generation\ObjectId")
     */
    public $dependencies;
    /**
     * @Key("enum")
     * @Type("array")
     * @UniqueItems(true)
     * @MinItems(1)
     */
    public $enum;
    /**
     * @Key("type")
     * @AnyOf(@Schema(enum={"array", "boolean", "integer", "null", "number", "object", "string"}), @Schema(type="array", items=@Schema(enum={"array", "boolean", "integer", "null", "number", "object", "string"}), minItems=1, uniqueItems=true))
     */
    public $type;
    /**
     * @Key("allOf")
     * @Type("array")
     * @Items(@Ref("PSX\Generation\Json_schema"))
     * @MinItems(1)
     */
    public $allOf;
    /**
     * @Key("anyOf")
     * @Type("array")
     * @Items(@Ref("PSX\Generation\Json_schema"))
     * @MinItems(1)
     */
    public $anyOf;
    /**
     * @Key("oneOf")
     * @Type("array")
     * @Items(@Ref("PSX\Generation\Json_schema"))
     * @MinItems(1)
     */
    public $oneOf;
    /**
     * @Key("not")
     * @Ref("PSX\Generation\Json_schema")
     */
    public $not;
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getId()
    {
        return $this->id;
    }
    public function set_schema($_schema)
    {
        $this->_schema = $_schema;
    }
    public function get_schema()
    {
        return $this->_schema;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function setDefault($default)
    {
        $this->default = $default;
    }
    public function getDefault()
    {
        return $this->default;
    }
    public function setMultipleOf($multipleOf)
    {
        $this->multipleOf = $multipleOf;
    }
    public function getMultipleOf()
    {
        return $this->multipleOf;
    }
    public function setMaximum($maximum)
    {
        $this->maximum = $maximum;
    }
    public function getMaximum()
    {
        return $this->maximum;
    }
    public function setExclusiveMaximum($exclusiveMaximum)
    {
        $this->exclusiveMaximum = $exclusiveMaximum;
    }
    public function getExclusiveMaximum()
    {
        return $this->exclusiveMaximum;
    }
    public function setMinimum($minimum)
    {
        $this->minimum = $minimum;
    }
    public function getMinimum()
    {
        return $this->minimum;
    }
    public function setExclusiveMinimum($exclusiveMinimum)
    {
        $this->exclusiveMinimum = $exclusiveMinimum;
    }
    public function getExclusiveMinimum()
    {
        return $this->exclusiveMinimum;
    }
    public function setMaxLength($maxLength)
    {
        $this->maxLength = $maxLength;
    }
    public function getMaxLength()
    {
        return $this->maxLength;
    }
    public function setMinLength($minLength)
    {
        $this->minLength = $minLength;
    }
    public function getMinLength()
    {
        return $this->minLength;
    }
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }
    public function getPattern()
    {
        return $this->pattern;
    }
    public function setAdditionalItems($additionalItems)
    {
        $this->additionalItems = $additionalItems;
    }
    public function getAdditionalItems()
    {
        return $this->additionalItems;
    }
    public function setItems($items)
    {
        $this->items = $items;
    }
    public function getItems()
    {
        return $this->items;
    }
    public function setMaxItems($maxItems)
    {
        $this->maxItems = $maxItems;
    }
    public function getMaxItems()
    {
        return $this->maxItems;
    }
    public function setMinItems($minItems)
    {
        $this->minItems = $minItems;
    }
    public function getMinItems()
    {
        return $this->minItems;
    }
    public function setUniqueItems($uniqueItems)
    {
        $this->uniqueItems = $uniqueItems;
    }
    public function getUniqueItems()
    {
        return $this->uniqueItems;
    }
    public function setMaxProperties($maxProperties)
    {
        $this->maxProperties = $maxProperties;
    }
    public function getMaxProperties()
    {
        return $this->maxProperties;
    }
    public function setMinProperties($minProperties)
    {
        $this->minProperties = $minProperties;
    }
    public function getMinProperties()
    {
        return $this->minProperties;
    }
    public function setRequired($required)
    {
        $this->required = $required;
    }
    public function getRequired()
    {
        return $this->required;
    }
    public function setAdditionalProperties($additionalProperties)
    {
        $this->additionalProperties = $additionalProperties;
    }
    public function getAdditionalProperties()
    {
        return $this->additionalProperties;
    }
    public function setDefinitions($definitions)
    {
        $this->definitions = $definitions;
    }
    public function getDefinitions()
    {
        return $this->definitions;
    }
    public function setProperties($properties)
    {
        $this->properties = $properties;
    }
    public function getProperties()
    {
        return $this->properties;
    }
    public function setPatternProperties($patternProperties)
    {
        $this->patternProperties = $patternProperties;
    }
    public function getPatternProperties()
    {
        return $this->patternProperties;
    }
    public function setDependencies($dependencies)
    {
        $this->dependencies = $dependencies;
    }
    public function getDependencies()
    {
        return $this->dependencies;
    }
    public function setEnum($enum)
    {
        $this->enum = $enum;
    }
    public function getEnum()
    {
        return $this->enum;
    }
    public function setType($type)
    {
        $this->type = $type;
    }
    public function getType()
    {
        return $this->type;
    }
    public function setAllOf($allOf)
    {
        $this->allOf = $allOf;
    }
    public function getAllOf()
    {
        return $this->allOf;
    }
    public function setAnyOf($anyOf)
    {
        $this->anyOf = $anyOf;
    }
    public function getAnyOf()
    {
        return $this->anyOf;
    }
    public function setOneOf($oneOf)
    {
        $this->oneOf = $oneOf;
    }
    public function getOneOf()
    {
        return $this->oneOf;
    }
    public function setNot($not)
    {
        $this->not = $not;
    }
    public function getNot()
    {
        return $this->not;
    }
}
PHP;

        $expect = str_replace(["\r\n", "\n", "\r"], "\n", $expect);
        $actual = preg_replace('/Object([0-9A-Fa-f]{8})/', 'ObjectId', $actual);

        $this->assertEquals($expect, $actual, $actual);
    }

    public function testExecute()
    {
        $source    = $this->getSchema();
        $generator = new Php(__NAMESPACE__);
        $result    = $generator->generate($source);
        $file      = __DIR__ . '/generated_schema.php';

        file_put_contents($file, $result);

        include_once $file;

        $schema = $this->schemaManager->getSchema(__NAMESPACE__ . '\\News');

        $this->assertSchema($schema, $source);
    }
}
