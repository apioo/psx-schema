# CommonProperties

Common properties which can be used at any schema

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
title | String | Distinct word which represents this schema | 
description | String | General description of this schema, should not contain any new lines. | 
type | String | JSON type of the property | 
nullable | Boolean | Indicates whether it is possible to use a null value | 
deprecated | Boolean | Indicates whether this schema is deprecated | 
readonly | Boolean | Indicates whether this schema is readonly | 

# ScalarProperties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
format | String | Describes the specific format of this type i.e. date-time or int64 | 
enum | StringArray &#124; NumberArray | A list of possible enumeration values | 
default | String &#124; Number &#124; Boolean | Represents a scalar value | 

# Properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Map (PropertyValue) |  | 

# ContainerProperties

Properties specific for a container

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 

# StructProperties

Struct specific properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
properties | Properties | **REQUIRED**.  | 
required | Array (String) | Array string values | MinItems: `1`

# MapProperties

Map specific properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
additionalProperties | BooleanType &#124; NumberType &#124; StringType &#124; ArrayType &#124; CombinationType &#124; ReferenceType &#124; GenericType | **REQUIRED**. Allowed values of an object property | 
maxProperties | Integer | Positive integer value | 
minProperties | Integer | Positive integer value | 

# ArrayProperties

Array properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 
items | BooleanType &#124; NumberType &#124; StringType &#124; ReferenceType &#124; GenericType | **REQUIRED**. Allowed values of an array item | 
maxItems | Integer | Positive integer value | 
minItems | Integer | Positive integer value | 
uniqueItems | Boolean |  | 

# BooleanProperties

Boolean properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 

# NumberProperties

Number properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 
multipleOf | Number |  | 
maximum | Number |  | 
exclusiveMaximum | Boolean |  | 
minimum | Number |  | 
exclusiveMinimum | Boolean |  | 

# StringProperties

String properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 
maxLength | Integer | Positive integer value | 
minLength | Integer | Positive integer value | 
pattern | String |  | 

# DiscriminatorMapping

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Map (String) |  | 

# Discriminator

Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
propertyName | String | **REQUIRED**. The name of the property in the payload that will hold the discriminator value | 
mapping | DiscriminatorMapping |  | 

# AllOfProperties

An intersection type combines multiple schemas into one

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
description | String |  | 
allOf | Array (OfValue) | **REQUIRED**. Combination values | 

# OneOfProperties

An union type can contain one of the provided schemas

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
description | String |  | 
discriminator | Discriminator |  | 
oneOf | Array (OfValue) | **REQUIRED**. Combination values | 

# TemplateProperties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Map (ReferenceType) |  | 

# ReferenceType

Represents a reference to another schema

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
ref | String | **REQUIRED**. Reference to the schema under the definitions key | 
template | TemplateProperties | Optional concrete schema definitions which replace generic template types | 

# GenericType

Represents a generic type

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
generic | String | **REQUIRED**.  | 

# Definitions

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Map (DefinitionValue) |  | 

# Import

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Map (String) |  | 

# TypeSchema

TypeSchema meta schema which describes a TypeSchema

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
import | Import |  | 
title | String | **REQUIRED**.  | 
description | String |  | 
type | String | **REQUIRED**.  | 
definitions | Definitions |  | 
properties | Properties | **REQUIRED**.  | 
required | Array (String) | Array string values | MinItems: `1`
