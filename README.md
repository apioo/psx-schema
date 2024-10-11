
# Schema

This library helps you to work with fully typed objects, it provides the following features:

* Transform raw JSON data into fully typed objects
* Parse PHP classes into a [TypeSchema](https://typeschema.org/) specification
* Generate DTOs in different languages like TypeScript, Java, C# etc.

We provide also a hosted version of this [code generator](https://typeschema.org/generator/schema).
For more integration options you can also take a look at the [SDKgen](https://sdkgen.app/) project
which provides a CLI binary or GitHub action to integrate the code generator.

## Object mapper

This example reads raw JSON data and transform it into the provided `Person` class.

```php
$json = <<<'JSON'
{
    "firstName": "Ludwig",
    "lastName": "Beethoven",
    "age": 254
}
JSON;

$objectMapper = new ObjectMapper(new SchemaManager());

$person = $objectMapper->readJson($json, SchemaSource::fromClass(Person::class));

assert('Ludwig' === $person->getFirstName());
assert('Beethoven' === $person->getLastName());
assert(254 === $person->getAge());

$json = $objectMapper->writeJson($person);
```

Besides a simple class there are multiple ways to specify a source, for example to parse
an array of persons s.

```php
$json = <<<'JSON'
[
    {
        "firstName": "Ludwig",
        "lastName": "Beethoven",
        "age": 254
    }
]
JSON;

$objectMapper = new ObjectMapper(new SchemaManager());

$personList = $objectMapper->readJson($json, SchemaSource::fromType('array<Person>'));

assert(1 === count($personList));
assert('Ludwig' === $personList[0]->getFirstName());

$json = $objectMapper->writeJson($person);
```

## Code generation

It is possible to transform any DTO class into a [TypeSchema](https://typeschema.org/) specification.
This schema can then be used to generate DTOs in different languages which helps to work with
type-safe objects across different environments.

```php
$schemaManager = new SchemaManager();
$factory = new GeneratorFactory();

$schema = $schemaManager->getSchema(Person::class);

$generator = $factory->getGenerator(GeneratorFactory::TYPE_JAVA, Config::of('org.typeschema.model'));

$result = $generator->generate();

$result->writeTo('/my_model.zip');
```

## TypeSchema specification

It is possible to transform an existing [TypeSchema](https://typeschema.org/) specification into a PHP DTO class.
For example lets take a look at the following specification, which describes a person:

```json
{
  "definitions": {
    "Person": {
      "type": "struct",
      "properties": {
        "firstName": {
          "type": "string"
        },
        "lastName": {
          "type": "string"
        },
        "age": {
          "description": "Age in years",
          "type": "integer"
        }
      }
    }
  },
  "root": "Person"
}
```

It is then possible to turn this specification into a ready-to-use PHP class s.

```php

$schemaManager = new SchemaManager();
$factory = new GeneratorFactory();

$schema = $schemaManager->getSchema(__DIR__ . '/my_schema.json');

$generator = $factory->getGenerator(GeneratorFactory::TYPE_PHP, Config::of('App\\Model'));

$result = $generator->generate();

foreach ($result as $file => $code) {
    file_put_contents(__DIR__ . '/' . $file, '<?php' . "\n" . $code);
}
```

This would result in the following PHP class:

```php
<?php

declare(strict_types = 1);

class Person implements \JsonSerializable, \PSX\Record\RecordableInterface
{
    protected ?string $firstName = null;
    protected ?string $lastName = null;
    #[Description("Age in years")]
    protected ?int $age = null;
    public function setFirstName(?string $firstName) : void
    {
        $this->firstName = $firstName;
    }
    public function getFirstName() : ?string
    {
        return $this->firstName;
    }
    public function setLastName(?string $lastName) : void
    {
        $this->lastName = $lastName;
    }
    public function getLastName() : ?string
    {
        return $this->lastName;
    }
    public function setAge(?int $age) : void
    {
        $this->age = $age;
    }
    public function getAge() : ?int
    {
        return $this->age;
    }
    public function toRecord() : \PSX\Record\RecordInterface
    {
        /** @var \PSX\Record\Record<mixed> $record */
        $record = new \PSX\Record\Record();
        $record->put('firstName', $this->firstName);
        $record->put('lastName', $this->lastName);
        $record->put('age', $this->age);
        return $record;
    }
    public function jsonSerialize() : object
    {
        return (object) $this->toRecord()->getAll();
    }
}
```

Every generated PHP class implements also the `JsonSerializable` interface so you can simply encode an object to json.

```php
$person = new Person();
$person->setFirstName('foo');
$person->setLastName('bar');
$person->setAge(32);

echo json_encode($person);

// would result in
// {"firstName": "foo", "lastName": "bar", "age": 32}

```

## Attributes

The following attributes are available:

| Attribute     | Target         | Example                                 |
|---------------|----------------|-----------------------------------------|
| Deprecated    | Property       | #[Deprecated(true)]                     |
| DerivedType   | Class          | #[DerivedType(Person::class, 'person')] |
| Description   | Class/Property | #[Description("content")]               |
| Discriminator | Class          | #[Discriminator('type')]                |
| Exclude       | Property       | #[Exclude]                              |
| Format        | Property       | #[Format('date-time')]                  |
| Key           | Property       | #[Key('my-complex-name')]               |
| Nullable      | Property       | #[Nullable(true)]                       |
