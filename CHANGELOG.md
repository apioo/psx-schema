
### 2.0.10 (2016-01-15)

* Fixed rec count in case of many oneOf misses
* Fix handling type array
* Html generator add combination type to constraints

### 2.0.9 (2016-01-08)

* Improved html generator

### 2.0.8 (2016-12-24)

* Dumper handle datetime and resource values

### 2.0.7 (2016-12-24)

* Dumper parses also traversable objects

### 2.0.6 (2016-12-22)

* Use nikic parser 3.0
* Add validation test

### 2.0.5 (2016-12-18)

* Added validator class to type visitor

### 2.0.4 (2016-12-17)

* Use constraint id in html generator

### 2.0.3 (2016-12-16)

* Use array instead of doctrine ArrayCollection
* Increased doctrine annotation dependency to 1.3

### 2.0.2 (2016-12-15)

* Make properties protected
* Ignore null values
* Handle date types

### 2.0.1 (2016-12-12)

* Add dumper class
* Add schema bin script

### 2.0.0 (2016-12-10)

* Improved parse and generator
* Proper handling of oneOf, anyOf, allOf and not
* Removed XSD generator
* Added JSON Schema Test Suite

### 1.0.5 (2016-10-30)

* Allow symfony 3.0 components

### 1.0.4 (2016-10-05)

* Use schema manager in schema command

### 1.0.3 (2016-07-22)

* Fix php generation of pattern and additional complex types

### 1.0.2 (2016-05-29)

* Correct generation and parsing of pattern and additional properties
* Added PatternProperty, MinProperties and MaxProperties
* AdditionalProperties allows now also to specify a specific property
* Deprecated the AnyType since the same behaviour can be achieved through the
  additionalProperties on the ComplexType
* Added MinItems and MaxItems annotations according to the JsonSchema spec and
  deprecated the usage of MinLength and MaxLength for an array property

### 1.0.1 (2016-05-21)

* Added binary and uri property type
* JsonSchema generator add the "format" property
* Added schema command test case

### 1.0.0 (2016-05-08)

* Initial release
