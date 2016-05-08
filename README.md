PSX Schema
===

## About

The schema library can parse and generate data schema definitions. It was 
designed around the JsonSchema specification. It is possible to traverse
through a schema based on arbitrary data and apply specific actions. The
following parser and generator classes are available:

### Parser

- JsonSchema (Parses a [JsonSchema](http://json-schema.org/) file)
- Popo (Parses the annotations of a class)

### Generator

- HTML (Generates a HTML representation of the schema)
- JsonSchema (Generates a [JsonSchema](http://json-schema.org/) specification)
- PHP (Generates a PHP class representing the schema using annotations)
- XSD (Generates a [XSD](https://www.w3.org/TR/xmlschema-0/) specification)

## Usage

```php
// read a schema from a JsonSchema file
$schema = JsonSchema::fromFile('schema.json');

// the schema traverse can be used traverse through arbitrary data based on the
// schema
$traverser = new SchemaTraverser();

// the visitor can perform a action for each visited value. The incoming visitor
// validates the data according to the schema
$visitor = new IncomingVisitor();

// now we traverse the data
$data = ['foo' => 'bar']

$traverser->traverse($data, $schema, $visitor);

// we can generate another representation from the schema
$generator = new Xsd('http://phpsx.org/tns');

echo $generator->generate($schema);

```

## Annotations

It is possible to turn a normal PHP class into an schema. Therefor you can use
annotations to describe the type of each property.

```php
class News
{
    /**
     * @Type("integer")
     */
    protected $id;

    /**
     * @Type("string")
     */
    protected $title;

    /**
     * @Type("PSX\Schema\Tests\Parser\Popo\Author")
     */
    protected $author;

    /**
     * @Type("array<PSX\Schema\Tests\Parser\Popo\Comment>")
     */
    protected $comments;

    // getter/setter
}

```

The following annotations are available:

| Annotation            | Target         | Example                     |
|-----------------------|----------------|-----------------------------|
| @AdditionalProperties | Class          | @AdditionalProperties(true) |
| @Description          | Class/Property | @Description("content")     |
| @Enum                 | Property       | @Enum({"foo", "bar"})       |
| @Exclude              | Property       | @Exclude                    |
| @Key                  | Property       | @Key("$ref")                |
| @Maximum              | Property       | @Maximum(16)                |
| @MaxLength            | Property       | @MaxLength(16)              |
| @Minimum              | Property       | @Minimum(4)                 |
| @MinLength            | Property       | @MinLength(4)               |
| @Pattern              | Property       | @Pattern("A-z+")            |
| @Required             | Property       | @Required                   |
| @Title                | Class          | @Title("foo")               |
| @Type                 | Property       | @Type("string")             |

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

Type       = "any" / "array" / "boolean" / "choice" / "complex" / "datetime" / 
             "date" / "duration" / "float" / "integer" / "string" / "time"

Impl       = "(" Class ")" 
Class      = CHAR ; Must be an absolute PHP class name

Properties = "<" ( Property "," ) ">"
Property   = Value / Key "=" Value
Key        = ALPHA / DIGIT
Value      = CHAR
```
