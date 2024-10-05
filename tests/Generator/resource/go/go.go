// Location of the person
type Location struct {
    Lat float64 `json:"lat"`
    Long float64 `json:"long"`
}

// An application
type Web struct {
    Name string `json:"name"`
    Url string `json:"url"`
}

// An simple author element with some description
type Author struct {
    Title string `json:"title"`
    Email string `json:"email"`
    Categories []string `json:"categories"`
    Locations []Location `json:"locations"`
    Origin *Location `json:"origin"`
}

type Meta = map[string]string

// An general news entry
type News struct {
    Config *Meta `json:"config"`
    InlineConfig map[string]string `json:"inlineConfig"`
    MapTags map[string]string `json:"mapTags"`
    MapReceiver map[string]Author `json:"mapReceiver"`
    Tags []string `json:"tags"`
    Receiver []Author `json:"receiver"`
    Read bool `json:"read"`
    Author *Author `json:"author"`
    Meta *Meta `json:"meta"`
    SendDate string `json:"sendDate"`
    ReadDate string `json:"readDate"`
    Price float64 `json:"price"`
    Rating int `json:"rating"`
    Content string `json:"content"`
    Question string `json:"question"`
    Version string `json:"version"`
    CoffeeTime string `json:"coffeeTime"`
    Captcha string `json:"g-recaptcha-response"`
    MediaFields string `json:"media.fields"`
    Payload any `json:"payload"`
}
