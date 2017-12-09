#### news

An general news entry

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
config | Object ([config](#psx_model_Config)) |  | 
tags | Array (String) |  | MinItems: 1, MaxItems: 6
receiver | Array (Object ([author](#psx_model_Author))) |  | MinItems: 1
resources | Array (Mixed) |  | 
profileImage | [Base64](http://tools.ietf.org/html/rfc4648) |  | 
read | Boolean |  | 
source | Mixed |  | 
author | Object ([author](#psx_model_Author)) | An simple author element with some description | 
meta | Object ([meta](#psx_model_Meta)) | Some meta data | 
sendDate | [Date](http://tools.ietf.org/html/rfc3339#section-5.6) |  | 
readDate | [DateTime](http://tools.ietf.org/html/rfc3339#section-5.6) |  | 
expires | [Duration](https://en.wikipedia.org/wiki/ISO_8601#Durations) |  | 
price | Number |  | Minimum: 1, Maximum: 100
rating | Integer |  | Minimum: 1, Maximum: 5
content | String | Contains the main content of the news entry | MinLength: 3, MaxLength: 512
question | String |  | 
version | String |  | Const: http://foo.bar
coffeeTime | [Time](http://tools.ietf.org/html/rfc3339#section-5.6) |  | 
profileUri | [URI](http://tools.ietf.org/html/rfc3986) |  | 

#### config

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Object ([config](#psx_model_Config)) |  | 

#### author

An simple author element with some description

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
title | String |  | Pattern: [A-z]{3,16}
email | String / Null | We will send no spam to this address | 
categories | Array (String) |  | MaxItems: 8
locations | Array (Object ([location](#psx_model_Location))) | Array of locations | 
origin | Object ([location](#psx_model_Location)) | Location of the person | 

#### web

An application

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
name | String |  | 
url | String |  | 
* | String |  | 

#### meta

Some meta data

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
createDate | [DateTime](http://tools.ietf.org/html/rfc3339#section-5.6) |  | 
^tags_\d$ | String |  | 
^location_\d$ | Object ([location](#psx_model_Location)) | Location of the person | 

#### location

Location of the person

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
lat | Number |  | 
long | Number |  | 
* | Mixed |  | 

