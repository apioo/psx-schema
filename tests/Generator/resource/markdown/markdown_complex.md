# PropertyType

Base property type

Field | Type | Description
----- | ---- | -----------
deprecated | Boolean | 
description | String | 
nullable | Boolean | 
type | String | 


# AnyPropertyType

Represents an any value which allows any kind of value

Field | Type | Description
----- | ---- | -----------


# DefinitionType

Base definition type

Field | Type | Description
----- | ---- | -----------
deprecated | Boolean | 
description | String | 
type | String | 


# CollectionDefinitionType

Base collection type

Field | Type | Description
----- | ---- | -----------
schema | PropertyType | 
type | String | 


# ArrayDefinitionType

Represents an array which contains a dynamic list of values of the same type

Field | Type | Description
----- | ---- | -----------


# CollectionPropertyType

Base collection property type

Field | Type | Description
----- | ---- | -----------
schema | PropertyType | 
type | String | 


# ArrayPropertyType

Represents an array which contains a dynamic list of values of the same type

Field | Type | Description
----- | ---- | -----------


# ScalarPropertyType

Base scalar property type

Field | Type | Description
----- | ---- | -----------
type | String | 


# BooleanPropertyType

Represents a boolean value

Field | Type | Description
----- | ---- | -----------


# GenericPropertyType

Represents a generic value which can be replaced with a dynamic type

Field | Type | Description
----- | ---- | -----------
name | String | The name of the generic, it is recommended to use common generic names like T or TValue. These generics can then be replaced on usage with a concrete type through the template property at a reference.


# IntegerPropertyType

Represents an integer value

Field | Type | Description
----- | ---- | -----------


# MapDefinitionType

Represents a map which contains a dynamic set of key value entries of the same type

Field | Type | Description
----- | ---- | -----------


# MapPropertyType

Represents a map which contains a dynamic set of key value entries of the same type

Field | Type | Description
----- | ---- | -----------


# NumberPropertyType

Represents a float value

Field | Type | Description
----- | ---- | -----------


# ReferencePropertyType

Represents a reference to a definition type

Field | Type | Description
----- | ---- | -----------
target | String | The target type, this must be a key which is available under the definitions keyword.
template | Map (String) | A map where the key is the name of the generic and the value must point to a key under the definitions keyword. This can be used in case the target points to a type which contains generics, then it is possible to replace those generics with a concrete type.


# StringPropertyType

Represents a string value

Field | Type | Description
----- | ---- | -----------
format | String | Optional describes the format of the string. Supported are the following types: date, date-time and time. A code generator may use a fitting data type to represent such a format, if not supported it should fall back to a string.


# StructDefinitionType

A struct represents a class/structure with a fix set of defined properties.

Field | Type | Description
----- | ---- | -----------
base | Boolean | Indicates whether this is a base structure, default is false. If true the structure is used a base type, this means it is not possible to create an instance from this structure.
discriminator | String | Optional the property name of a discriminator property. This should be only used in case this is also a base structure.
mapping | Map (String) | In case a discriminator is configured it is required to configure a mapping. The mapping is a map where the key is the type name and the value the actual discriminator type value.
parent | ReferencePropertyType | Defines a parent type for this structure. Some programming languages like Go do not support the concept of an extends, in this case the code generator simply copies all properties into this structure.
properties | Map (PropertyType) | Contains a map of available properties for this struct.


# TypeSchema

TypeSchema specification

Field | Type | Description
----- | ---- | -----------
definitions | Map (DefinitionType) | 
import | Map (String) | Through the import keyword it is possible to import other TypeSchema documents. It contains a map where the key is the namespace and the value points to a remote document. The value is a URL and a code generator should support at least the following schemes: file, http, https.
root | String | Specifies the root type of your specification.

