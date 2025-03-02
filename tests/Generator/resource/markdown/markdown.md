# Location

Location of the person

Field | Type | Description
----- | ---- | -----------
lat | Number | 
long | Number | 


# Author

An simple author element with some description

Field | Type | Description
----- | ---- | -----------
title | String | 
email | String | We will send no spam to this address
categories | Array (String) | 
locations | Array (Location) | Array of locations
origin | Location | 


# Meta

Field | Type | Description | Constraints
----- | ---- | ----------- | -----------
* | String |  | 


# News

An general news entry

Field | Type | Description
----- | ---- | -----------
config | Meta | 
inlineConfig | Map (String) | 
mapTags | Map (String) | 
mapReceiver | Map (Author) | 
tags | Array (String) | 
receiver | Array (Author) | 
data | Array (Array (Number)) | 
read | Boolean | 
author | Author | 
meta | Meta | 
sendDate | String (date) | 
readDate | String (date-time) | 
price | Number | 
rating | Integer | 
content | String | Contains the "main" content of the news entry
question | String | 
version | String | 
coffeeTime | String (time) | 
captcha | String | 
mediaFields | String | 
payload | Any | 

