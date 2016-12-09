PSX Schema
===

## About

This library helps to generate PHP classes from JsonSchema definitions and vice 
versa. The generated POPOs can be filled with json data. It was inspired by 
the Apache CXF project where it is possible simply generate POJOs to XSD. The 
following parser and generator classes are available:

### Parser

- JsonSchema (Parses a [JsonSchema](http://json-schema.org/) file)
- Popo (Parses the annotations of a class)

### Generator

- HTML (Generates a HTML representation of the schema)
- JsonSchema (Generates a [JsonSchema](http://json-schema.org/) specification)
- PHP (Generates PHP classes representing the schema using annotations)

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

Based on the schema we can generate the following PHP class

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

$reader = new \Doctrine\Common\Annotations\SimpleAnnotationReader();
$reader->addNamespace('PSX\\Schema\\Parser\\Popo\\Annotation');

$schemaManager = new \PSX\Schema\SchemaManager($reader);

// we read the schema annotations from the class
$schema = $schemaManager->getSchema(Example_Schema::class);

try {
    $traverser = new SchemaTraverser();
    $example   = $traverser->traverse($data, $schema, new TypeVisitor());
    
    // $result contains now an instance of the Example_Schema class containing 
    // the firstName and lastName property
    echo $example->getFirstName();

} catch (\PSX\Schema\ValidationException $e) {
    // the validation failed
    echo $e->getMessage();
}

```


## Annotations

The following annotations are available:

| Annotation            | Target         | Example                                           |
|-----------------------|----------------|---------------------------------------------------|
| @AdditionalItems      | Property       | @AdditionalItems(true)                            |
| @AdditionalProperties | Class          | @AdditionalProperties(true)                       |
| @AllOf                | Property       | @AllOf(@Schema(type="integer", minimum=0), @Schema(type="integer", maximum=64)) |
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
