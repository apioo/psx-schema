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
    Origin Location `json:"origin"`
}

type Meta = map[string]string

import "time"

// An general news entry
type News struct {
    Config Meta `json:"config"`
    InlineConfig map[string]string `json:"inlineConfig"`
    MapTags map[string]string `json:"mapTags"`
    MapReceiver map[string]Author `json:"mapReceiver"`
    MapResources map[string]any `json:"mapResources"`
    Tags []string `json:"tags"`
    Receiver []Author `json:"receiver"`
    Resources []any `json:"resources"`
    ProfileImage string `json:"profileImage"`
    Read bool `json:"read"`
    Source any `json:"source"`
    Author Author `json:"author"`
    Meta Meta `json:"meta"`
    SendDate time.Time `json:"sendDate"`
    ReadDate time.Time `json:"readDate"`
    Expires string `json:"expires"`
    Range time.Duration `json:"range"`
    Price float64 `json:"price"`
    Rating int `json:"rating"`
    Content string `json:"content"`
    Question string `json:"question"`
    Version string `json:"version"`
    CoffeeTime time.Time `json:"coffeeTime"`
    ProfileUri string `json:"profileUri"`
    Captcha string `json:"g-recaptcha-response"`
    Payload any `json:"payload"`
}
