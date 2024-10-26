use serde::{Serialize, Deserialize};
use chrono::NaiveDate;
use chrono::NaiveDateTime;
use chrono::NaiveTime;
use meta::Meta;
use author::Author;

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

