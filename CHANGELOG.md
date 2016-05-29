
### 1.0.3

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
