use serde::{Serialize, Deserialize};

// Location of the person
#[derive(Serialize, Deserialize)]
pub struct Location {
    #[serde(rename = "lat")]
    lat: f64,
    #[serde(rename = "long")]
    long: f64,
}

use serde::{Serialize, Deserialize};

// An application
#[derive(Serialize, Deserialize)]
pub struct Web {
    #[serde(rename = "name")]
    name: String,
    #[serde(rename = "url")]
    url: String,
}

use serde::{Serialize, Deserialize};
use location::Location;

// An simple author element with some description
#[derive(Serialize, Deserialize)]
pub struct Author {
    #[serde(rename = "title")]
    title: String,
    #[serde(rename = "email")]
    email: String,
    #[serde(rename = "categories")]
    categories: Vec<String>,
    #[serde(rename = "locations")]
    locations: Vec<Location>,
    #[serde(rename = "origin")]
    origin: Location,
}

use std::collections::HashMap;
pub type Meta = HashMap<String, String>;

use serde::{Serialize, Deserialize};
use std::collections::HashMap;
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
    config: Meta,
    #[serde(rename = "inlineConfig")]
    inline_config: HashMap<String, String>,
    #[serde(rename = "tags")]
    tags: Vec<String>,
    #[serde(rename = "receiver")]
    receiver: Vec<Author>,
    #[serde(rename = "resources")]
    resources: Vec<serde_json::Value>,
    #[serde(rename = "profileImage")]
    profile_image: String,
    #[serde(rename = "read")]
    read: bool,
    #[serde(rename = "source")]
    source: serde_json::Value,
    #[serde(rename = "author")]
    author: Author,
    #[serde(rename = "meta")]
    meta: Meta,
    #[serde(rename = "sendDate")]
    send_date: NaiveDate,
    #[serde(rename = "readDate")]
    read_date: NaiveDateTime,
    #[serde(rename = "expires")]
    expires: String,
    #[serde(rename = "price")]
    price: f64,
    #[serde(rename = "rating")]
    rating: u64,
    #[serde(rename = "content")]
    content: String,
    #[serde(rename = "question")]
    question: String,
    #[serde(rename = "version")]
    version: String,
    #[serde(rename = "coffeeTime")]
    coffee_time: NaiveTime,
    #[serde(rename = "profileUri")]
    profile_uri: String,
    #[serde(rename = "g-recaptcha-response")]
    captcha: String,
    #[serde(rename = "payload")]
    payload: serde_json::Value,
}
