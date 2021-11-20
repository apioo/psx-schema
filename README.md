PSX Schema
===

## About

This library can parse a [TypeSchema](https://typeschema.org/) specification either
from a JSON file, or from PHP classes using reflection and annotations. Based on
this schema it can generate source code and transform raw JSON data into DTO objects.
Through this you can work with fully typed objects in your API for incoming and
outgoing data. It provides basically the following features:

* Transform raw JSON data into DTO objects
* Generate source code based on a schema (i.e. PHP, Typescript)
* Validate data according to the provided schema

## Usage

At first, we need to describe our data format with a [TypeSchema](https://typeschema.org/)
specification. Then we can generate based on this specification the fitting PHP
classes.

```json
{
  "definitions": {
    "Person": {
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
  },
  "$ref": "Person"
}
```

To generate the PHP classes we use the following command:   

```
vendor/bin/schema schema:parse --format=php schema.json
```

This generates the following `Person.php` file:

```php
<?php

declare(strict_types = 1);

/**
 * @Required({"firstName", "lastName"})
 */
class Person implements \JsonSerializable
{
    /**
     * @var string|null
     */
    protected $firstName;
    /**
     * @var string|null
     */
    protected $lastName;
    /**
     * @var int|null
     * @Description("Age in years")
     * @Minimum(0)
     */
    protected $age;
    /**
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName) : void
    {
        $this->firstName = $firstName;
    }
    /**
     * @return string|null
     */
    public function getFirstName() : ?string
    {
        return $this->firstName;
    }
    /**
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName) : void
    {
        $this->lastName = $lastName;
    }
    /**
     * @return string|null
     */
    public function getLastName() : ?string
    {
        return $this->lastName;
    }
    /**
     * @param int|null $age
     */
    public function setAge(?int $age) : void
    {
        $this->age = $age;
    }
    /**
     * @return int|null
     */
    public function getAge() : ?int
    {
        return $this->age;
    }
    public function jsonSerialize()
    {
        return (object) array_filter(array('firstName' => $this->firstName, 'lastName' => $this->lastName, 'age' => $this->age), static function ($value) : bool {
            return $value !== null;
        });
    }
}
```

Now we can parse raw JSON data and fill this in to our object model:

```php
// the data which we want to import
$data = json_decode('{"firstName": "foo", "lastName": "bar"}');

$schemaManager = new \PSX\Schema\SchemaManager();

// we read the schema from the class
$schema = $schemaManager->getSchema(Person::class);

try {
    $person = (new SchemaTraverser())->traverse($data, $schema, new TypeVisitor());
    
    // $example contains now an instance of the Person class containing 
    // the firstName and lastName property
    echo $person->getFirstName();

} catch (\PSX\Schema\Exception\ValidationException $e) {
    // the validation failed
    echo $e->getMessage();
}

```

Every generated PHP class implements also the `JsonSerializable` interface so
you can simply encode an object to json.

```php
$schema = new Person();
$schema->setFirstName('foo');
$schema->setLastName('bar');
$schema->setAge(12);

echo json_encode($schema);

// would result in
// {"firstName": "foo", "lastName": "bar", "age": 12}

```

## Generator

Beside PHP classes this library can generate the following types:

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

## Annotations

Please note that we use the [doctrine/annotations](https://github.com/doctrine/annotations)
library to parse the annotations. Because of this you need to setup a fitting
annotation loader which can load the classes. To use the registered autoloader
you can simply use: `AnnotationRegistry::registerLoader('class_exists')`. More
information how to configure the loader at the
[documentation](https://www.doctrine-project.org/projects/doctrine-annotations/en/1.6/annotations.html#registering-annotations).
For PHP 8 we plan to use native annotations so in the long term we will remove the
`doctrine/annotations` library.

The following annotations are available:

| Annotation            | Target         | Example                                           |
|-----------------------|----------------|---------------------------------------------------|
| @Deprecated           | Property       | @Deprecated(true)                            |
| @Description          | Class/Property | @Description("content")                           |
| @Discriminator        | Property       | @Discriminator("type")                           |
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
