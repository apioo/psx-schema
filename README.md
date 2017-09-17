PSX Schema
===

## About

This library helps to generate PHP classes from JsonSchema definitions and vice 
versa. You can then use those POPOs to import and validate json data. It was 
inspired by JAXB where it is possible generate POJOs from XSD files. We have 
also created an [online tool](http://phpsx.org/tools/jsonschema) to test the 
JsonSchema to PHP conversion.

## Usage

This example shows how to transform data into an object based on a jsonschema.
We use the example schema from the json schema website.

```json
{
  "title": "Example Schema",
  "type": "object",
  "properties": {
    "firstName": {
      "type": "string"
    },
    "lastName": {
      "type": "string"
    },
    "age": {
      "description": "Age in years",
      "type": "integer",
      "minimum": 0
    }
  },
  "required": [
    "firstName",
    "lastName"
  ]
}
```

Based on the schema we can generate the PHP classes with the following command:   
`vendor/bin/schema schema schema.json php`

```php
<?php

namespace PSX\Generation;

/**
 * @Title("Example Schema")
 * @Required({"firstName", "lastName"})
 */
class Example_Schema
{
    /**
     * @Key("firstName")
     * @Type("string")
     */
    public $firstName;
    /**
     * @Key("lastName")
     * @Type("string")
     */
    public $lastName;
    /**
     * @Key("age")
     * @Description("Age in years")
     * @Type("integer")
     * @Minimum(0)
     */
    public $age;
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function setAge($age)
    {
        $this->age = $age;
    }
    public function getAge()
    {
        return $this->age;
    }
}
```

Now we can use this class to read json data which fits to the schema

```php
// the data which we want to import
$data = json_decode({"firstName": "foo", "lastName": "bar"});

$schemaManager = new \PSX\Schema\SchemaManager();

// we read the schema annotations from the class
$schema = $schemaManager->getSchema(Example_Schema::class);

try {
    $traverser = new SchemaTraverser();
    $example   = $traverser->traverse($data, $schema, new TypeVisitor());
    
    // $example contains now an instance of the Example_Schema class containing 
    // the firstName and lastName property
    echo $example->getFirstName();

} catch (\PSX\Schema\ValidationException $e) {
    // the validation failed
    echo $e->getMessage();
}

```

You can use the dumper to create a JSON representation based on your POPO 
objects:

```php
$schema = new Example_Schema();
$schema->setFirstName('foo');
$schema->setLastName('bar');
$schema->setAge(12);

$dumper = new \PSX\Schema\Parser\Popo\Dumper();
$data   = $dumper->dump($schema);

echo json_encode($data);

// would result in
// {"firstName": "foo", "lastName": "bar", "age": 12}

```

## Annotations

The following annotations are available:

| Annotation            | Target         | Example                                           |
|-----------------------|----------------|---------------------------------------------------|
| @AdditionalItems      | Property       | @AdditionalItems(true)                            |
| @AdditionalProperties | Class          | @AdditionalProperties(true)                       |
| @AllOf                | Property       | @AllOf(@Ref("FooClass"), @Ref("BarClass"))        |
| @AnyOf                | Property       | @AnyOf(@Schema(type="integer", minimum=0), @Schema(type="string", maxLength=64)) |
| @Dependencies         | Class          | @Dependencies(property="name", value={"age", "gender"}) |
| @Description          | Class/Property | @Description("content")                           |
| @Enum                 | Property       | @Enum({"foo", "bar"})                             |
| @Exclude              | Property       | @Exclude                                          |
| @ExclusiveMaximum     | Property       | @ExclusiveMaximum(true)                           |
| @ExclusiveMinimum     | Property       | @ExclusiveMinimum(true)                           |
| @Format               | Property       | @Format("uri")                                    |
| @Items                | Property       | @Items(@Ref("FooClass"))                          |
| @Key                  | Property       | @Key("$ref")                                      |
| @Maximum              | Property       | @Maximum(16)                                      |
| @MaxItems             | Property       | @MaxItems(16)                                     |
| @MaxLength            | Property       | @MaxLength(16)                                    |
| @MaxProperties        | Class          | @MaxProperties(16)                                |
| @Minimum              | Property       | @Minimum(4)                                       |
| @MinItems             | Property       | @MinItems(4)                                      |
| @MinLength            | Property       | @MinLength(4)                                     |
| @MinProperties        | Property       | @MinProperties(4)                                 |
| @MultipleOf           | Property       | @MultipleOf(2)                                    |
| @Not                  | Property       | @Not(@Schema(type="string"))                      |
| @OneOf                | Property       | @OneOf(@Ref("FooClass"), @Ref("BarClass"))        |
| @Pattern              | Property       | @Pattern("A-z+")                                  |
| @PatternProperties    | Class          | @PatternProperties(pattern="^foo", type="string") |
| @Ref                  | Property       | @Ref("FooClass")                                  |
| @Required             | Class          | @Required({"name", "title"})                      |
| @Title                | Class          | @Title("foo")                                     |
| @Type                 | Property       | @Type("string")                                   |
| @UniqueItems          | Property       | @UniqueItems(true)                                |

## Architecture

### Parser

The following parser classes are available which produce a schema object:

- JsonSchema (Parses a [JsonSchema](http://json-schema.org/) file)
- Popo (Parses the annotations of a class)

### Generator

The following generator classes are available which generate a representation of
a schema object:

- HTML (Generates a HTML representation of the schema)
- JsonSchema (Generates a [JsonSchema](http://json-schema.org/) specification)
- Markdown (Generates a markdown representation of the schema)
- PHP (Generates PHP classes representing the schema using annotations)
- Protobuf (Generates a [proto3](https://developers.google.com/protocol-buffers/) definition)

## Code generation

This library tries to generate useful PHP classes based on a defined JsonSchema.
That being said the main goal of JsonSchema is to validate JSON data and not to 
__model__ a JSON structure. Because of this nature it is difficult to generate a 
proper class hierarchy using inheritance based on the validation keywords 
(`@OneOf`, `@AllOf`, etc). To avoid these complications we use the following 
simple logic to generate a class: 

If a JsonSchema has a `properties` keyword we generate a class which contains
the properties which are defined. Each property contains annotations which
describe the defined validation keywords. If the property reference another 
schema we use the `@Ref` annotation otherwise we use the inline `@Schema` 
annotation.

So developers should see the generated classes only as a starting point. If 
inheritance is needed it must be manually implemented. Despite that this 
approach is pretty robust and allows us to also generate classes for recursive 
schemas like i.e. the JsonSchema spec itself.

# JSON Schema code

While developing this library we have experienced many pitfalls with the 
JsonSchema specification. In order to avoid those and to help to write better 
JsonSchema schemas we have developed a [JsonSchema code specification](https://cdn.rawgit.com/apioo/psx-schema/1192d888/doc/jsonschema-code.html) 
which restricts the JsonSchema keywords. This specification contains also a 
JsonSchema meta schema to validate a schema against those rules.
