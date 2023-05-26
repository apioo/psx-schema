// Location of the person
struct Location {
    lat: float64,
    long: float64,
}

// An application
struct Web {
    name: String,
    url: String,
}

// An simple author element with some description
struct Author {
    title: String,
    email: String,
    categories: Vec<String>,
    locations: Vec<Location>,
    origin: Location,
}

type Meta = HashMap<String, String>() {
}

// An general news entry
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
