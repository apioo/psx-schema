<a name="CommonProperties"></a>
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

<a name="ScalarProperties"></a>
# ScalarProperties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
format | String | Describes the specific format of this type i.e. date-time or int64 | 
enum | Object ([StringArray](#StringArray)) &#124; Object ([NumberArray](#NumberArray)) | A list of possible enumeration values | 
default | String &#124; Number &#124; Boolean | Represents a scalar value | 

<a name="Properties"></a>
# Properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Object ([PropertyValue](#PropertyValue)) |  | 

<a name="ContainerProperties"></a>
# ContainerProperties

Properties specific for a container

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 

<a name="StructProperties"></a>
# StructProperties

Struct specific properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
properties | Object ([Properties](#Properties)) | **REQUIRED**.  | 
required | Array (String) | Array string values | MinItems: `1`

<a name="MapProperties"></a>
# MapProperties

Map specific properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
additionalProperties | Object ([BooleanType](#BooleanType)) &#124; Object ([NumberType](#NumberType)) &#124; Object ([StringType](#StringType)) &#124; Object ([ArrayType](#ArrayType)) &#124; Object ([CombinationType](#CombinationType)) &#124; Object ([ReferenceType](#ReferenceType)) &#124; Object ([GenericType](#GenericType)) | **REQUIRED**. Allowed values of an object property | 
maxProperties | Integer | Positive integer value | 
minProperties | Integer | Positive integer value | 

<a name="ArrayProperties"></a>
# ArrayProperties

Array properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 
items | Object ([BooleanType](#BooleanType)) &#124; Object ([NumberType](#NumberType)) &#124; Object ([StringType](#StringType)) &#124; Object ([ReferenceType](#ReferenceType)) &#124; Object ([GenericType](#GenericType)) | **REQUIRED**. Allowed values of an array item | 
maxItems | Integer | Positive integer value | 
minItems | Integer | Positive integer value | 
uniqueItems | Boolean |  | 

<a name="BooleanProperties"></a>
# BooleanProperties

Boolean properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 

<a name="NumberProperties"></a>
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

<a name="StringProperties"></a>
# StringProperties

String properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 
maxLength | Integer | Positive integer value | 
minLength | Integer | Positive integer value | 
pattern | String |  | 

<a name="DiscriminatorMapping"></a>
# DiscriminatorMapping

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | String |  | 

<a name="Discriminator"></a>
# Discriminator

Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
propertyName | String | **REQUIRED**. The name of the property in the payload that will hold the discriminator value | 
mapping | Object ([DiscriminatorMapping](#DiscriminatorMapping)) |  | 

<a name="AllOfProperties"></a>
# AllOfProperties

An intersection type combines multiple schemas into one

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
description | String |  | 
allOf | Array (Object ([OfValue](#OfValue))) | **REQUIRED**. Combination values | 

<a name="OneOfProperties"></a>
# OneOfProperties

An union type can contain one of the provided schemas

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
description | String |  | 
discriminator | Object ([Discriminator](#Discriminator)) |  | 
oneOf | Array (Object ([OfValue](#OfValue))) | **REQUIRED**. Combination values | 

<a name="TemplateProperties"></a>
# TemplateProperties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Object ([ReferenceType](#ReferenceType)) |  | 

<a name="ReferenceType"></a>
# ReferenceType

Represents a reference to another schema

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
ref | String | **REQUIRED**. Reference to the schema under the definitions key | 
template | Object ([TemplateProperties](#TemplateProperties)) | Optional concrete schema definitions which replace generic template types | 

<a name="GenericType"></a>
# GenericType

Represents a generic type

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
generic | String | **REQUIRED**.  | 

<a name="Definitions"></a>
# Definitions

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Object ([DefinitionValue](#DefinitionValue)) |  | 

<a name="Import"></a>
# Import

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | String |  | 

<a name="TypeSchema"></a>
# TypeSchema

TypeSchema meta schema which describes a TypeSchema

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
import | Object ([Import](#Import)) |  | 
title | String | **REQUIRED**.  | 
description | String |  | 
type | String | **REQUIRED**.  | 
definitions | Object ([Definitions](#Definitions)) |  | 
properties | Object ([Properties](#Properties)) | **REQUIRED**.  | 
required | Array (String) | Array string values | MinItems: `1`
