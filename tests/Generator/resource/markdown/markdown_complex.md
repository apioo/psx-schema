# DefinitionType

Base definition type

Field | Type | Description
----- | ---- | -----------
description | String | 
deprecated | Boolean | 
type | String | 


# StructDefinitionType

Represents a struct which contains a fixed set of defined properties

Field | Type | Description
----- | ---- | -----------
type | String | 
parent | String | The parent type of this struct. The struct inherits all properties from the parent type
base | Boolean | Indicates that this struct is a base type, this means it is an abstract type which is used by different types as parent
properties | Map (PropertyType) | 
discriminator | String | In case this is a base type it is possible to specify a discriminator property
mapping | Map (String) | In case a discriminator property was set it is possible to specify a mapping. The key is the type name and the value the concrete value which is mapped to the type
template | Map (String) | In case the parent type contains generics it is possible to set a concrete type for each generic type


# CollectionDefinitionType

Base type for the map and array collection type

Field | Type | Description
----- | ---- | -----------
type | String | 
schema | PropertyType | 


# MapDefinitionType

Represents a map which contains a dynamic set of key value entries

Field | Type | Description
----- | ---- | -----------
type | String | 


# ArrayDefinitionType

Represents an array which contains a dynamic list of values

Field | Type | Description
----- | ---- | -----------
type | String | 


# PropertyType

Base property type

Field | Type | Description
----- | ---- | -----------
description | String | 
deprecated | Boolean | 
type | String | 
nullable | Boolean | 


# ScalarPropertyType

Base scalar property type

Field | Type | Description
----- | ---- | -----------
type | String | 


# IntegerPropertyType

Represents an integer value

Field | Type | Description
----- | ---- | -----------
type | String | 


# NumberPropertyType

Represents a float value

Field | Type | Description
----- | ---- | -----------
type | String | 


# StringPropertyType

Represents a string value

Field | Type | Description
----- | ---- | -----------
type | String | 
format | String | 


# BooleanPropertyType

Represents a boolean value

Field | Type | Description
----- | ---- | -----------
type | String | 


# CollectionPropertyType

Base collection property type

Field | Type | Description
----- | ---- | -----------
type | String | 
schema | PropertyType | 


# MapPropertyType

Represents a map which contains a dynamic set of key value entries

Field | Type | Description
----- | ---- | -----------
type | String | 


# ArrayPropertyType

Represents an array which contains a dynamic list of values

Field | Type | Description
----- | ---- | -----------
type | String | 


# AnyPropertyType

Represents an any value which allows any kind of value

Field | Type | Description
----- | ---- | -----------
type | String | 


# GenericPropertyType

Represents a generic value which can be replaced with a dynamic type

Field | Type | Description
----- | ---- | -----------
type | String | 
name | String | The generic name, it is recommended to use typical generics names like T or TValue


# ReferencePropertyType

Represents a reference to a definition type

Field | Type | Description
----- | ---- | -----------
type | String | 
target | String | Name of the target reference, must a key from the definitions map


# Specification

Field | Type | Description
----- | ---- | -----------
import | Map (String) | 
definitions | Map (DefinitionType) | 
root | String | 

