
# JsonSchema (strict)

## Preface

JsonSchema is a great specification to validate JSON documents. But 
unfortunately it is not designed for describing JSON data independently of the 
actual data. Thus it is not possible to reliable generate i.e. class definitions 
or other schema formats like protobuf. This is also the reason why the OpenAPI 
specification currently uses only a subset of the JsonSchema spec since code 
generation is an important concern.

Since JsonSchema is very popular and we have already many libraries (based on 
the draft-04 standard) in almost any language I dont have intentions to create
a new schema description language. Instead I like to propose
[JsonSchema (strict)](jsonschema.json). If a JsonSchema is valid against this 
schema it can also be used for code generation.

## Why

To give you an example why it is difficult to use a JSONSchema as data 
description format lets take a look at the following valid JSONSchema:

    {
    }

It simply allows every kind of data. For the generation purpose we cant get any
information from this since we dont have at least a `type` keyword. To be able 
to generate code only based on the JSONSchema we need at least some information 
about the structure of the document. In this document I propose additional rules 
to build JSONSchemas which can also be used for code generation.

## Rules

* Every schema must have a type declaration. The type must be one of: `object`, 
  `array`, `boolean`, `number`, `integer`, `string`
* Every object must have a title keyword. This helps with generating i.e.
  class names, XML element names or other identifiers. The title should be
  a distinct word which represents this object
  * An object is either a struct (`properties` keyword) or a map 
    (`additionalProperties` keyword) but it can not be both:
    * Struct

          {
            "title": "Person",
            "type": "object",
            "properties": {
              "forname": {
                "type": "string"
              },
              "lastname": {
                "type": "string"
              }
            }
          }

    * Map

          {
            "title": "Config",
            "type": "object",
            "additionalProperties": {
              "type": "string"
            }
          }

* An array must have a `items` keyword. The `items` can only contain the 
  following types: `object`, `number`, `integer`, `string`
* The keywords `allOf`, `anyOf` and `oneOf` can only contain object types, since
  they are only useful for `object` types. This protects us also from writing 
  schemas which can not be valid. I.e. we avoid schemas like:
  
        {
          "allOf": [{
            "type": "string"
          }, {
            "type": "integer"
          }]
        }
  
  For generators it would be also possible to merge all properties (in the 
  `allOf` case) to a single schema

## Keywords

The schema contains also some additional keywords which are useful for code
generation. These keywords are already defined by the OAI specification:

* **nullable**  
  A boolean value indicating whether a value can be null instead of the defined 
  type

* **discriminator**  
  Provides a way to select a schema based on the value of a specific property.
  Must be a string containing a property name. This property name is also
  automatically required. The available schemas must be defined under: 
  `#/definitions`

