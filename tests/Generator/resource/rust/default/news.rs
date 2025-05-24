use serde::{Serialize, Deserialize};
use meta::Meta;
use author::Author;

// An general news entry
#[derive(Serialize, Deserialize)]
pub struct News {
    #[serde(rename = "config")]
    config: Option<Meta>,

    #[serde(rename = "inlineConfig")]
    inline_config: Option<std::collections::HashMap<String, String>>,

    #[serde(rename = "mapTags")]
    map_tags: Option<std::collections::HashMap<String, String>>,

    #[serde(rename = "mapReceiver")]
    map_receiver: Option<std::collections::HashMap<String, Author>>,

    #[serde(rename = "tags")]
    tags: Option<Vec<String>>,

    #[serde(rename = "receiver")]
    receiver: Option<Vec<Author>>,

    #[serde(rename = "data")]
    data: Option<Vec<Vec<f64>>>,

    #[serde(rename = "read")]
    read: Option<bool>,

    #[serde(rename = "author")]
    author: Author,

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
    content: String,

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

