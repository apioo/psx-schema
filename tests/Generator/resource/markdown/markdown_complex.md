# Security

Field | Type | Description
----- | ---- | -----------
type | String | The global security type of the API must be one of: httpBasic, httpBearer, apiKey or oauth2


# SecurityHttpBasic

Field | Type | Description
----- | ---- | -----------


# SecurityHttpBearer

Field | Type | Description
----- | ---- | -----------


# SecurityApiKey

Field | Type | Description
----- | ---- | -----------
name | String | The name of the header or query parameter i.e. "X-Api-Key"
in | String | Must be either "header" or "query"


# SecurityOAuth

Field | Type | Description
----- | ---- | -----------
tokenUrl | String | The OAuth2 token endpoint
authorizationUrl | String | Optional the OAuth2 authorization endpoint
scopes | Array (String) | Optional OAuth2 scopes


# Operation

Field | Type | Description
----- | ---- | -----------
method | String | The HTTP method which is associated with this operation, must be a valid HTTP method i.e. GET, POST, PUT etc.
path | String | The HTTP path which is associated with this operation. A path can also include variable path fragments i.e. /my/path/:year then you can map the variable year path fragment to a specific argument
return | Response | The return type of this operation. The return has also an assigned HTTP success status code which is by default 200
arguments | Map (Argument) | All arguments provided to this operation. Each argument is mapped to a location from the HTTP request i.e. query or body
throws | Array (Response) | All exceptional states which can occur in case the operation fails. Each exception is assigned to an HTTP error status code
description | String | A short description of this operation. The generated code will include this description at the method so it is recommend to use simple alphanumeric characters and no new lines
stability | Integer | Indicates the stability of this operation: 0 - Deprecated, 1 - Experimental, 2 - Stable, 3 - Legacy. If not explicit provided the operation is by default experimental.
security | Array (String) | An array of scopes which are required to access this operation
authorization | Boolean | Indicates whether this operation needs authorization, if set to false the client will not send an authorization header, default it is true
tags | Array (String) | Optional an array of tags to group operations


# Argument

Field | Type | Description
----- | ---- | -----------
in | String | The location where the value can be found either in the path, query, header or body. If you choose path, then your path must have a fitting variable path fragment
schema | PropertyType | 
contentType | String | In case the data is not a JSON payload which you can describe with a schema you can select a content type
name | String | Optional the actual path, query or header name. If not provided the key of the argument map is used


# Response

Field | Type | Description
----- | ---- | -----------
code | Integer | The associated HTTP response code. For error responses it is possible to use the 499, 599 or 999 status code to catch all errors
contentType | String | In case the data is not a JSON payload which you can describe with a schema you can select a content type
schema | PropertyType | 


# TypeSchema

TypeSchema specification

Field | Type | Description
----- | ---- | -----------
import | Map (String) | Through the import keyword it is possible to import other TypeSchema documents. It contains a map where the key is the namespace and the value points to a remote document. The value is a URL and a code generator should support at least the following schemes: file, http, https.
definitions | Map (DefinitionType) | 
root | String | Specifies the root type of your specification.


# TypeAPI

The TypeAPI Root

Field | Type | Description
----- | ---- | -----------
baseUrl | String | Optional the base url of the service, if provided the user does not need to provide a base url for your client
security | Security | Describes the authorization mechanism which is used by your API
operations | Map (Operation) | A map of operations which are provided by the API. The key of the operation should be separated by a dot to group operations into logical units i.e. product.getAll or enterprise.product.execute


# DefinitionType

Base definition type

Field | Type | Description
----- | ---- | -----------
description | String | 
type | String | 
deprecated | Boolean | 


# StructDefinitionType

A struct represents a class/structure with a fix set of defined properties.

Field | Type | Description
----- | ---- | -----------
parent | ReferencePropertyType | Defines a parent type for this structure. Some programming languages like Go do not support the concept of an extends, in this case the code generator simply copies all properties into this structure.
base | Boolean | Indicates whether this is a base structure, default is false. If true the structure is used a base type, this means it is not possible to create an instance from this structure.
properties | Map (PropertyType) | Contains a map of available properties for this struct.
discriminator | String | Optional the property name of a discriminator property. This should be only used in case this is also a base structure.
mapping | Map (String) | In case a discriminator is configured it is required to configure a mapping. The mapping is a map where the key is the type name and the value the actual discriminator type value.


# CollectionDefinitionType

Base collection type

Field | Type | Description
----- | ---- | -----------
schema | PropertyType | 


# MapDefinitionType

Represents a map which contains a dynamic set of key value entries of the same type

Field | Type | Description
----- | ---- | -----------


# ArrayDefinitionType

Represents an array which contains a dynamic list of values of the same type

Field | Type | Description
----- | ---- | -----------


# PropertyType

Base property type

Field | Type | Description
----- | ---- | -----------
description | String | 
type | String | 
deprecated | Boolean | 
nullable | Boolean | 


# ScalarPropertyType

Base scalar property type

Field | Type | Description
----- | ---- | -----------


# StringPropertyType

Represents a string value

Field | Type | Description
----- | ---- | -----------
format | String | Optional describes the format of the string. Supported are the following types: date, date-time and time. A code generator may use a fitting data type to represent such a format, if not supported it should fall back to a string.


# IntegerPropertyType

Represents an integer value

Field | Type | Description
----- | ---- | -----------


# NumberPropertyType

Represents a float value

Field | Type | Description
----- | ---- | -----------


# BooleanPropertyType

Represents a boolean value

Field | Type | Description
----- | ---- | -----------


# CollectionPropertyType

Base collection property type

Field | Type | Description
----- | ---- | -----------
schema | PropertyType | 


# MapPropertyType

Represents a map which contains a dynamic set of key value entries of the same type

Field | Type | Description
----- | ---- | -----------


# ArrayPropertyType

Represents an array which contains a dynamic list of values of the same type

Field | Type | Description
----- | ---- | -----------


# AnyPropertyType

Represents an any value which allows any kind of value

Field | Type | Description
----- | ---- | -----------


# GenericPropertyType

Represents a generic value which can be replaced with a dynamic type

Field | Type | Description
----- | ---- | -----------
name | String | The name of the generic, it is recommended to use common generic names like T or TValue. These generics can then be replaced on usage with a concrete type through the template property at a reference.


# ReferencePropertyType

Represents a reference to a definition type

Field | Type | Description
----- | ---- | -----------
target | String | The target type, this must be a key which is available under the definitions keyword.
template | Map (String) | A map where the key is the name of the generic and the value must point to a key under the definitions keyword. This can be used in case the target points to a type which contains generics, then it is possible to replace those generics with a concrete type.

