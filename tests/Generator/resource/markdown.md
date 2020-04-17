<a name="Location"></a>
# Location

Location of the person

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
lat | Number | **REQUIRED**.  | 
long | Number | **REQUIRED**.  | 

<a name="Web"></a>
# Web

An application

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
name | String | **REQUIRED**.  | 
url | String | **REQUIRED**.  | 

<a name="Author"></a>
# Author

An simple author element with some description

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
title | String | **REQUIRED**.  | Pattern: `[A-z]{3,16}`
email | String | We will send no spam to this address | 
categories | Array (String) |  | MaxItems: `8`
locations | Array (Object ([Location](#Location))) | Array of locations | 
origin | Object ([Location](#Location)) |  | 

<a name="Meta"></a>
# Meta

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | String |  | 

<a name="News"></a>
# News

An general news entry

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
config | Object ([Meta](#Meta)) |  | 
tags | Array (String) |  | MinItems: `1`, MaxItems: `6`
receiver | Array (Object ([Author](#Author))) | **REQUIRED**.  | MinItems: `1`
resources | Array (Object ([Location](#Location)) &#124; Object ([Web](#Web))) |  | 
profileImage | [Base64](http://tools.ietf.org/html/rfc4648) |  | 
read | Boolean |  | 
source | Object ([Author](#Author)) &#124; Object ([Web](#Web)) |  | 
author | Object ([Author](#Author)) |  | 
meta | Object ([Meta](#Meta)) |  | 
sendDate | [Date](http://tools.ietf.org/html/rfc3339#section-5.6) |  | 
readDate | [DateTime](http://tools.ietf.org/html/rfc3339#section-5.6) |  | 
expires | [Duration](https://en.wikipedia.org/wiki/ISO_8601#Durations) |  | 
price | Number | **REQUIRED**.  | Minimum: `1`, Maximum: `100`
rating | Integer |  | Minimum: `1`, Maximum: `5`
content | String | **REQUIRED**. Contains the main content of the news entry | MinLength: `3`, MaxLength: `512`
question | String |  | 
version | String |  | Const: `http://foo.bar`
coffeeTime | [Time](http://tools.ietf.org/html/rfc3339#section-5.6) |  | 
profileUri | [URI](http://tools.ietf.org/html/rfc3986) |  | 
captcha | String |  | 
