PSX Schema
===

## About

The schema library can parse and generate data schema definitions. It was 
designed around the JsonSchema specification. The goal is to easily create PHP 
classes which map to JSON objects and to validate and normalize data based on
such classes. The following parser and generator classes are available:

### Parser

- JsonSchema (Parses a [JsonSchema](http://json-schema.org/) file)
- Popo (Parses the annotations of a class)

### Generator

- HTML (Generates a HTML representation of the schema)
- JsonSchema (Generates a [JsonSchema](http://json-schema.org/) specification)
- PHP (Generates PHP classes representing the schema using annotations)
- XSD (Generates a [XSD](https://www.w3.org/TR/xmlschema-0/) specification)

## Usage

```php
$reader = new \Doctrine\Common\Annotations\SimpleAnnotationReader();
$reader->addNamespace('PSX\\Schema\\Parser\\Popo\\Annotation');

// at first we need a schema manager. The schema manager is responsible to read
// different schema specification formats
$schemaManager = new \PSX\Schema\SchemaManager($reader);

// to read a json schema file
$schema = $schemaManager->getSchema('schema.json');

// or to read the schema annotations of a class
$schema = $schemaManager->getSchema(News::class);

// if we have a schema definition we can validate data. I.e. this is the data 
// that we want to analyze
$data = ['foo' => 'bar'];

try {
    // the schema traverse can be used to traverse through the data. The 
    // incoming visitor validates the data according to the schema
    $traverser = new SchemaTraverser();
    $result    = $traverser->traverse($data, $schema, new IncomingVisitor());
    
    // $result contains now the normalized and well formed data
    
} catch (\PSX\Schema\ValidationException $e) {
    // the validation failed
    echo $e->getMessage();
}

// based on the schema we can generate i.e. PHP classes
$generator = new \PSX\Schema\Generator\Php();

echo $generator->generate($schema);

```

## Example

This examples shows how the transformation of a JSON Schema into PHP classes 
works. We use the example schema from the offical json schema website. Note you 
should the see then generate code always as a starting point in almost any case 
you have to adjust it.

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

```php
<?php

namespace PSX\Generation;

/**
 * @Title("Example Schema")
 * @AdditionalProperties(false)
 */
class Complex269bcdc2
{
    /**
     * @Key("firstName")
     * @Type("string")
     * @Required
     */
    public $firstName;
    /**
     * @Key("lastName")
     * @Type("string")
     * @Required
     */
    public $lastName;
    /**
     * @Key("age")
     * @Type("integer")
     * @Description("Age in years")
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

## Annotations

The following annotations are available:

| Annotation            | Target         | Example                                         |
|-----------------------|----------------|-------------------------------------------------|
| @AdditionalProperties | Class          | @AdditionalProperties(true)                     |
| @Description          | Class/Property | @Description("content")                         |
| @Enum                 | Property       | @Enum({"foo", "bar"})                           |
| @Exclude              | Property       | @Exclude                                        |
| @Key                  | Property       | @Key("$ref")                                    |
| @Maximum              | Property       | @Maximum(16)                                    |
| @MaxItems             | Property       | @MaxItems(16)                                   |
| @MaxLength            | Property       | @MaxLength(16)                                  |
| @MaxProperties        | Class          | @MaxProperties(16)                              |
| @Minimum              | Property       | @Minimum(4)                                     |
| @MinItems             | Property       | @MinItems(4)                                    |
| @MinLength            | Property       | @MinLength(4)                                   |
| @MinProperties        | Property       | @MinProperties(4)                               |
| @Pattern              | Property       | @Pattern("A-z+")                                |
| @PatternProperty      | Class          | @PatternProperty(pattern="^foo", type="string") |
| @Required             | Property       | @Required                                       |
| @Title                | Class          | @Title("foo")                                   |
| @Type                 | Property       | @Type("string")                                 |

### Type

Through the `@Type` annotation we can define the type of the property. In the 
following some examples how to define different types:

- `string`  
  Property must be a string
- `integer`  
  Property must be an integer
- `Acme\News`  
  Property must be an object of type `Acme\News`
- `array<Acme\News>`  
  Property must be an array of `Acme\News` objects
- `array(Acme\Collection)<Acme\News>`  
  Property must be an array of `Acme\News` objects. As array implementation we
  use `Acme\Collection`

The ABNF of the type is:

```text
Rule       =  Type [ Impl ] [ Properties ]

Type       = "array" / "binary" / "boolean" / "choice" / "complex" / 
             "datetime" / "date" / "duration" / "float" / "integer" / "string" / 
             "time" / "uri"

Impl       = "(" Class ")" 
Class      = CHAR ; Must be an absolute PHP class name

Properties = "<" *( Property "," ) ">"
Property   = Value / Key "=" Value
Key        = ALPHA / DIGIT
Value      = CHAR
```
