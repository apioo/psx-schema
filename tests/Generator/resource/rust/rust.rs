use serde::{Serialize, Deserialize};

// Location of the person
#[derive(Serialize, Deserialize)]
struct Location {
    #[serde(rename = "lat")]
    lat: float64,
    #[serde(rename = "long")]
    long: float64,
}

use serde::{Serialize, Deserialize};

// An application
#[derive(Serialize, Deserialize)]
struct Web {
    #[serde(rename = "name")]
    name: String,
    #[serde(rename = "url")]
    url: String,
}

use serde::{Serialize, Deserialize};

// An simple author element with some description
#[derive(Serialize, Deserialize)]
struct Author {
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

type Meta = HashMap<String, String>() {
}

use serde::{Serialize, Deserialize};

// An general news entry
#[derive(Serialize, Deserialize)]
struct News {
    #[serde(rename = "config")]
    config: Meta,
    #[serde(rename = "inlineConfig")]
    inlineConfig: HashMap<String, String>,
    #[serde(rename = "tags")]
    tags: Vec<String>,
    #[serde(rename = "receiver")]
    receiver: Vec<Author>,
    #[serde(rename = "resources")]
    resources: Vec<Object>,
    #[serde(rename = "profileImage")]
    profileImage: String,
    #[serde(rename = "read")]
    read: bool,
    #[serde(rename = "source")]
    source: Object,
    #[serde(rename = "author")]
    author: Author,
    #[serde(rename = "meta")]
    meta: Meta,
    #[serde(rename = "sendDate")]
    sendDate: time.Time,
    #[serde(rename = "readDate")]
    readDate: time.Time,
    #[serde(rename = "expires")]
    expires: String,
    #[serde(rename = "price")]
    price: float64,
    #[serde(rename = "rating")]
    rating: u64,
    #[serde(rename = "content")]
    content: String,
    #[serde(rename = "question")]
    question: String,
    #[serde(rename = "version")]
    version: String,
    #[serde(rename = "coffeeTime")]
    coffeeTime: time.Time,
    #[serde(rename = "profileUri")]
    profileUri: String,
    #[serde(rename = "g-recaptcha-response")]
    captcha: String,
    #[serde(rename = "payload")]
    payload: Object,
}
