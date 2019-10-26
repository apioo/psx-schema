<a name="News"></a>
# News

An general news entry

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
config | [Config](#Config) |  | 
tags | Array (String) |  | MinItems: `1`, MaxItems: `6`
receiver | Array ([Author](#Author)) | **REQUIRED**.  | MinItems: `1`
resources | Array ([Location](#Location) &#124; [Web](#Web)) |  | 
profileImage | [Base64](http://tools.ietf.org/html/rfc4648) |  | 
read | Boolean |  | 
source | [Author](#Author) &#124; [Web](#Web) |  | 
author | [Author](#Author) | An simple author element with some description | 
meta | [Meta](#Meta) | Some meta data | 
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

<a name="Config"></a>
# Config

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | String |  | 

<a name="Author"></a>
# Author

An simple author element with some description

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
title | String | **REQUIRED**.  | Pattern: `[A-z]{3,16}`
email |  | We will send no spam to this address | 
categories | Array (String) |  | MaxItems: `8`
locations | Array ([Location](#Location)) | Array of locations | 
origin | [Location](#Location) | Location of the person | 

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

<a name="Meta"></a>
# Meta

Some meta data

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
createDate | [DateTime](http://tools.ietf.org/html/rfc3339#section-5.6) |  | 
