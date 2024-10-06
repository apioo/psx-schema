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
use chrono::NaiveDate;
use chrono::NaiveDateTime;
use chrono::NaiveTime;

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

    #[serde(rename = "tags")]
    tags: Option<Vec<String>>,

    #[serde(rename = "receiver")]
    receiver: Option<Vec<Author>>,

    #[serde(rename = "read")]
    read: Option<bool>,

    #[serde(rename = "author")]
    author: Option<Author>,

    #[serde(rename = "meta")]
    meta: Option<Meta>,

    #[serde(rename = "sendDate")]
    send_date: Option<chrono::NaiveDate>,

    #[serde(rename = "readDate")]
    read_date: Option<chrono::NaiveDateTime>,

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

    #[serde(rename = "g-recaptcha-response")]
    captcha: Option<String>,

    #[serde(rename = "media.fields")]
    media_fields: Option<String>,

    #[serde(rename = "payload")]
    payload: Option<serde_json::Value>,

}
