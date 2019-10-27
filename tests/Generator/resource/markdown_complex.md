<a name="TypeSchema"></a>
# TypeSchema

TypeSchema meta schema which describes a TypeSchema

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
title | String | **REQUIRED**.  | 
description | String |  | 
type | String | **REQUIRED**.  | 
definitions | [Definitions](#Definitions) | Schema definitions which can be reused | 
properties | [Properties](#Properties) | **REQUIRED**. Properties of a schema | 
required | Array (String) | Array string values | MinItems: `1`

<a name="Definitions"></a>
# Definitions

Schema definitions which can be reused

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | (([CommonProperties](#CommonProperties) &#38; [ContainerProperties](#ContainerProperties) &#38; [StructProperties](#StructProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ContainerProperties](#ContainerProperties) &#38; [MapProperties](#MapProperties))) &#124; ([CommonProperties](#CommonProperties) &#38; [ArrayProperties](#ArrayProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [BooleanProperties](#BooleanProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [NumberProperties](#NumberProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [StringProperties](#StringProperties)) &#124; ([AllOfProperties](#AllOfProperties) &#124; [OneOfProperties](#OneOfProperties)) | Schema definitions which can be reused | 

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
properties | [Properties](#Properties) | **REQUIRED**. Properties of a schema | 
required | Array (String) | Array string values | MinItems: `1`

<a name="MapProperties"></a>
# MapProperties

Map specific properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
additionalProperties | ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [BooleanProperties](#BooleanProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [NumberProperties](#NumberProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [StringProperties](#StringProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ArrayProperties](#ArrayProperties)) &#124; ([AllOfProperties](#AllOfProperties) &#124; [OneOfProperties](#OneOfProperties)) &#124; [ReferenceType](#ReferenceType) | **REQUIRED**. Allowed values of an object property | 
maxProperties | Integer | Positive integer value | 
minProperties | Integer | Positive integer value | 

<a name="ArrayProperties"></a>
# ArrayProperties

Array properties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
type | String | **REQUIRED**.  | 
items | ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [BooleanProperties](#BooleanProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [NumberProperties](#NumberProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [StringProperties](#StringProperties)) &#124; ([AllOfProperties](#AllOfProperties) &#124; [OneOfProperties](#OneOfProperties)) &#124; [ReferenceType](#ReferenceType) | **REQUIRED**. Allowed values of an array item | 
maxItems | Integer | Positive integer value | 
minItems | Integer | Positive integer value | 
uniqueItems | Boolean |  | 

<a name="ScalarProperties"></a>
# ScalarProperties

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
format | String | Describes the specific format of this type i.e. date-time or int64 | 
enum | Array (String) &#124; Array (Number) | A list of possible enumeration values | 
default | String &#124; Number &#124; Boolean | Represents a scalar value | 

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

<a name="AllOfProperties"></a>
# AllOfProperties

Combination keyword to represent an intersection type

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
description | String |  | 
allOf | Array (([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [NumberProperties](#NumberProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [StringProperties](#StringProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [BooleanProperties](#BooleanProperties)) &#124; [ReferenceType](#ReferenceType)) | **REQUIRED**. Combination values | 

<a name="OneOfProperties"></a>
# OneOfProperties

Combination keyword to represent an union type

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
description | String |  | 
discriminator | [Discriminator](#Discriminator) | Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description | 
oneOf | Array (([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [NumberProperties](#NumberProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [StringProperties](#StringProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [BooleanProperties](#BooleanProperties)) &#124; [ReferenceType](#ReferenceType)) | **REQUIRED**. Combination values | 

<a name="Properties"></a>
# Properties

Properties of a schema

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [BooleanProperties](#BooleanProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [NumberProperties](#NumberProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ScalarProperties](#ScalarProperties) &#38; [StringProperties](#StringProperties)) &#124; ([CommonProperties](#CommonProperties) &#38; [ArrayProperties](#ArrayProperties)) &#124; ([AllOfProperties](#AllOfProperties) &#124; [OneOfProperties](#OneOfProperties)) &#124; [ReferenceType](#ReferenceType) | Properties of a schema | 

<a name="ReferenceType"></a>
# ReferenceType

Represents a reference to another schema

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
ref | String | **REQUIRED**. To disallow nesting we can reference only at the definitions layer | Pattern: `^#/definitions/([A-Za-z0-9]+)$`

<a name="Discriminator"></a>
# Discriminator

Adds support for polymorphism. The discriminator is an object name that is used to differentiate between other schemas which may satisfy the payload description

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
propertyName | String | **REQUIRED**. The name of the property in the payload that will hold the discriminator value | 
mapping | [DiscriminatorMapping](#DiscriminatorMapping) | An object to hold mappings between payload values and schema names or references | 

<a name="DiscriminatorMapping"></a>
# DiscriminatorMapping

An object to hold mappings between payload values and schema names or references

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | String | An object to hold mappings between payload values and schema names or references | 
