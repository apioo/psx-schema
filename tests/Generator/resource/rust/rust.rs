use serde::{Serialize, Deserialize};

// Location of the person
#[derive(Serialize, Deserialize)]
pub struct Location {
    #[serde(rename = "lat")]
    lat: Option<f64>,
    #[serde(rename = "long")]
    long: Option<f64>,
}

use serde::{Serialize, Deserialize};

// An application
#[derive(Serialize, Deserialize)]
pub struct Web {
    #[serde(rename = "name")]
    name: Option<String>,
    #[serde(rename = "url")]
    url: Option<String>,
}

use serde::{Serialize, Deserialize};
use location::Location;

// An simple author element with some description
#[derive(Serialize, Deserialize)]
pub struct Author {
    #[serde(rename = "title")]
    title: Option<String>,
    #[serde(rename = "email")]
    email: Option<String>,
    #[serde(rename = "categories")]
    categories: Option<Vec<String>>,
    #[serde(rename = "locations")]
    locations: Option<Vec<Location>>,
    #[serde(rename = "origin")]
    origin: Option<Location>,
}

use std::collections::HashMap;
pub type Meta = HashMap<String, String>;

use serde::{Serialize, Deserialize};
use std::collections::HashMap;
use std::time::Duration;
use chrono::NaiveDate;
use chrono::NaiveTime;
use chrono::NaiveDateTime;
use meta::Meta;
use author::Author;
use location::Location;
use web::Web;

// An general news entry
#[derive(Serialize, Deserialize)]
pub struct News {
    #[serde(rename = "config")]
    config: Option<Meta>,
    #[serde(rename = "inlineConfig")]
    inline_config: Option<HashMap<String, String>>,
    #[serde(rename = "mapTags")]
    map_tags: Option<HashMap<String, String>>,
    #[serde(rename = "mapReceiver")]
    map_receiver: Option<HashMap<String, Author>>,
    #[serde(rename = "mapResources")]
    map_resources: Option<HashMap<String, serde_json::Value>>,
    #[serde(rename = "tags")]
    tags: Option<Vec<String>>,
    #[serde(rename = "receiver")]
    receiver: Option<Vec<Author>>,
    #[serde(rename = "resources")]
    resources: Option<Vec<serde_json::Value>>,
    #[serde(rename = "profileImage")]
    profile_image: Option<String>,
    #[serde(rename = "read")]
    read: Option<bool>,
    #[serde(rename = "source")]
    source: Option<serde_json::Value>,
    #[serde(rename = "author")]
    author: Option<Author>,
    #[serde(rename = "meta")]
    meta: Option<Meta>,
    #[serde(rename = "sendDate")]
    send_date: Option<chrono::NaiveDate>,
    #[serde(rename = "readDate")]
    read_date: Option<chrono::NaiveDateTime>,
    #[serde(rename = "expires")]
    expires: Option<String>,
    #[serde(rename = "range")]
    range: Option<String>,
    #[serde(rename = "price")]
    price: Option<f64>,
    #[serde(rename = "rating")]
    rating: Option<u64>,
    #[serde(rename = "content")]
    content: Option<String>,
    #[serde(rename = "question")]
    question: Option<String>,
    #[serde(rename = "version")]
    version: Option<String>,
    #[serde(rename = "coffeeTime")]
    coffee_time: Option<chrono::NaiveTime>,
    #[serde(rename = "profileUri")]
    profile_uri: Option<String>,
    #[serde(rename = "g-recaptcha-response")]
    captcha: Option<String>,
    #[serde(rename = "media.fields")]
    media_fields: Option<String>,
    #[serde(rename = "payload")]
    payload: Option<serde_json::Value>,
}
