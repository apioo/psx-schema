// News An general news entry
type News struct {
    Config map[string]string `json:"config"`
    Tags []string `json:"tags"`
    Receiver []Author `json:"receiver"`
    Resources []interface{} `json:"resources"`
    ProfileImage string `json:"profileImage"`
    Read bool `json:"read"`
    Source interface{} `json:"source"`
    Author Author `json:"author"`
    Meta Meta `json:"meta"`
    SendDate time.Time `json:"sendDate"`
    ReadDate time.Time `json:"readDate"`
    Expires time.Duration `json:"expires"`
    Price float64 `json:"price"`
    Rating int `json:"rating"`
    Content string `json:"content"`
    Question string `json:"question"`
    Version string `json:"version"`
    CoffeeTime time.Time `json:"coffeeTime"`
    ProfileUri string `json:"profileUri"`
    Captcha string `json:"g-recaptcha-response"`
}


// Author An simple author element with some description
type Author struct {
    Title string `json:"title"`
    Email interface{} `json:"email"`
    Categories []string `json:"categories"`
    Locations []map[string]interface{} `json:"locations"`
    Origin map[string]interface{} `json:"origin"`
}

// Location Location of the person
type Location struct {
    Lat float64 `json:"lat"`
    Long float64 `json:"long"`
}

// Web An application
type Web struct {
    Name string `json:"name"`
    Url string `json:"url"`
}

// Meta Some meta data
type Meta struct {
    CreateDate time.Time `json:"createDate"`
}
