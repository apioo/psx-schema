# Argument

Describes arguments of the operation

Field | Type | Description
----- | ---- | -----------
contentType | String | In case the data is not a JSON payload which you can describe with a schema you can select a content type
in | String | The location where the value can be found either in the path, query, header or body. If you choose path, then your path must have a fitting variable path fragment
name | String | Optional the actual path, query or header name. If not provided the key of the argument map is used
schema | typeschema:PropertyType | Schema of the JSON payload


# Operation

Field | Type | Description
----- | ---- | -----------
arguments | Map (Argument) | All arguments provided to this operation. Each argument is mapped to a location from the HTTP request i.e. query or body
authorization | Boolean | Indicates whether this operation needs authorization, if set to false the client will not send an authorization header, default it is true
description | String | A short description of this operation. The generated code will include this description at the method so it is recommend to use simple alphanumeric characters and no new lines
method | String | The HTTP method which is associated with this operation, must be a valid HTTP method i.e. GET, POST, PUT etc.
path | String | The HTTP path which is associated with this operation. A path can also include variable path fragments i.e. /my/path/:year then you can map the variable year path fragment to a specific argument
return | Response | The return type of this operation. The return has also an assigned HTTP success status code which is by default 200
security | Array (String) | An array of scopes which are required to access this operation
stability | Integer | Indicates the stability of this operation: 0 - Deprecated, 1 - Experimental, 2 - Stable, 3 - Legacy. If not explicit provided the operation is by default experimental
throws | Array (Response) | All exceptional states which can occur in case the operation fails. Each exception is assigned to an HTTP error status code


# Response

Describes the response of the operation

Field | Type | Description
----- | ---- | -----------
code | Integer | The associated HTTP response code. For error responses it is possible to use the 499, 599 or 999 status code to catch all errors
contentType | String | In case the data is not a JSON payload which you can describe with a schema you can select a content type
schema | typeschema:PropertyType | Schema of the JSON payload


# Security

Field | Type | Description
----- | ---- | -----------
type | String | The global security type of the API must be one of: httpBasic, httpBearer, apiKey or oauth2


# SecurityApiKey

Field | Type | Description
----- | ---- | -----------
in | String | Must be either "header" or "query"
name | String | The name of the header or query parameter i.e. "X-Api-Key"


# SecurityHttpBasic

Field | Type | Description
----- | ---- | -----------


# SecurityHttpBearer

Field | Type | Description
----- | ---- | -----------


# SecurityOAuth

Field | Type | Description
----- | ---- | -----------
authorizationUrl | String | Optional the OAuth2 authorization endpoint
scopes | Array (String) | Optional OAuth2 scopes
tokenUrl | String | The OAuth2 token endpoint


# TypeAPI

The TypeAPI Root

Field | Type | Description
----- | ---- | -----------
baseUrl | String | Optional the base url of the service, if provided the user does not need to provide a base url for your client
operations | Map (Operation) | A map of operations which are provided by the API. The key of the operation should be separated by a dot to group operations into logical units i.e. product.getAll or enterprise.product.execute
security | Security | Describes the authorization mechanism which is used by your API

