use serde::{Deserialize, Serialize};

// Location of the person
#[derive(Serialize, Deserialize)]
struct Location {
    lat: float64,
    long: float64,
}

use serde::{Deserialize, Serialize};

// An application
#[derive(Serialize, Deserialize)]
struct Web {
    name: String,
    url: String,
}

use serde::{Deserialize, Serialize};

// An simple author element with some description
#[derive(Serialize, Deserialize)]
struct Author {
    title: String,
    email: String,
    categories: Vec<String>,
    locations: Vec<Location>,
    origin: Location,
}

use serde::{Deserialize, Serialize};
type Meta = HashMap<String, String>() {
}

use serde::{Deserialize, Serialize};

// An general news entry
#[derive(Serialize, Deserialize)]
struct News {
    config: Meta,
    inlineConfig: HashMap<String, String>,
    tags: Vec<String>,
    receiver: Vec<Author>,
    resources: Vec<Object>,
    profileImage: String,
    read: bool,
    source: Object,
    author: Author,
    meta: Meta,
    sendDate: time.Time,
    readDate: time.Time,
    expires: String,
    price: float64,
    rating: u64,
    content: String,
    question: String,
    version: String,
    coffeeTime: time.Time,
    profileUri: String,
    captcha: String,
    payload: Object,
}
