PSX Schema
===

## About

This library helps to generate source code for different languages from a
[TypeSchema](https://typeschema.org/) specification. TypeSchema is a JSON
specification which helps to design data models. The following languages are
currently supported:

* CSharp
* Go
* HTML
* Java
* JsonSchema
* Markdown
* PHP
* Protobuf
* Python
* Swift
* TypeSchema
* TypeScript

Please take a look at the [TypeSchema](https://typeschema.org/) website which
provides an online generator based on this library.

## Usage

This example shows how to transform data into an object based on a TypeSchema.

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
`vendor/bin/schema schema:parse --format=php schema.json`

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

Please note that we use the [doctrine/annotations](https://github.com/doctrine/annotations)
library to parse the annotations. Because of this you need to setup a fitting
annotation loader which can load the classes. To use the registered autoloader
you can simply use: `AnnotationRegistry::registerLoader('class_exists')`. More
information how to configure the loader at the
[documentation](https://www.doctrine-project.org/projects/doctrine-annotations/en/1.6/annotations.html#registering-annotations).

## Annotations

The following annotations are available:

| Annotation            | Target         | Example                                           |
|-----------------------|----------------|---------------------------------------------------|
| @Deprecated           | Property       | @Deprecated(true)                            |
| @Description          | Class/Property | @Description("content")                           |
| @Enum                 | Property       | @Enum({"foo", "bar"})                             |
| @Exclude              | Property       | @Exclude                                          |
| @ExclusiveMaximum     | Property       | @ExclusiveMaximum(true)                           |
| @ExclusiveMinimum     | Property       | @ExclusiveMinimum(true)                           |
| @Format               | Property       | @Format("uri")                                    |
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
| @Nullable             | Property       | @Nullable(true)                                    |
| @Pattern              | Property       | @Pattern("A-z+")                                  |
| @Required             | Class          | @Required({"name", "title"})                      |
| @Title                | Class          | @Title("foo")                                     |
| @UniqueItems          | Property       | @UniqueItems(true)                                |
