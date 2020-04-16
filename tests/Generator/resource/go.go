// Location Location of the person
type Location struct {
    lat float64 `json:"lat"`
    long float64 `json:"long"`
}

// Web An application
type Web struct {
    name string `json:"name"`
    url string `json:"url"`
}

// Author An simple author element with some description
type Author struct {
    title string `json:"title"`
    email string `json:"email"`
    categories []string `json:"categories"`
    locations []Location `json:"locations"`
    origin Location `json:"origin"`
}


// News An general news entry
type News struct {
    config map[string]string `json:"config"`
    tags []string `json:"tags"`
    receiver []Author `json:"receiver"`
    resources []interface{} `json:"resources"`
    profileImage string `json:"profileImage"`
    read bool `json:"read"`
    source interface{} `json:"source"`
    author Author `json:"author"`
    meta map[string]string `json:"meta"`
    sendDate time.Time `json:"sendDate"`
    readDate time.Time `json:"readDate"`
    expires time.Duration `json:"expires"`
    price float64 `json:"price"`
    rating int `json:"rating"`
    content string `json:"content"`
    question string `json:"question"`
    version string `json:"version"`
    coffeeTime time.Time `json:"coffeeTime"`
    profileUri string `json:"profileUri"`
    captcha string `json:"g-recaptcha-response"`
}
