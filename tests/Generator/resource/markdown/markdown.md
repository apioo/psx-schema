# Location

Location of the person

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
lat | Number | **REQUIRED**.  | 
long | Number | **REQUIRED**.  |

# Web

An application

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
name | String | **REQUIRED**.  | 
url | String | **REQUIRED**.  |

# Author

An simple author element with some description

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
title | String | **REQUIRED**.  | Pattern: `[A-z]{3,16}`
email | String | We will send no spam to this address | 
categories | Array (String) |  | MaxItems: `8`
locations | Array (Location) | Array of locations | 
origin | Location |  |

# Meta

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | Map (String) |  |

# News

An general news entry

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
config | Meta |  | 
inlineConfig | Map (String) |  | 
mapTags | Map (String) |  | 
mapReceiver | Map (Author) |  | 
mapResources | Map (Location &#124; Web) |  | 
tags | Array (String) |  | MinItems: `1`, MaxItems: `6`
receiver | Array (Author) | **REQUIRED**.  | MinItems: `1`
resources | Array (Location &#124; Web) |  | 
profileImage | String (base64) |  | 
read | Boolean |  | 
source | Author &#124; Web |  | 
author | Author |  | 
meta | Meta |  | 
sendDate | String (date) |  | 
readDate | String (date-time) |  | 
expires | String (period) |  | 
range | String (duration) |  | 
price | Number | **REQUIRED**.  | Minimum: `1`, Maximum: `100`
rating | Integer |  | Minimum: `1`, Maximum: `5`
content | String | **REQUIRED**. Contains the main content of the news entry | MinLength: `3`, MaxLength: `512`
question | String |  | 
version | String |  | Const: `http://foo.bar`
coffeeTime | String (time) |  | 
profileUri | String (uri) |  | 
captcha | String |  | 
mediaFields | String |  | 
payload | Any |  |
