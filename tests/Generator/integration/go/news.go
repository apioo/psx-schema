package main

import "time"

// An general news entry
type News struct {
    Config Meta `json:"config"`
    InlineConfig map[string]string `json:"inlineConfig"`
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
    Expires string `json:"expires"`
    Price float64 `json:"price"`
    Rating int `json:"rating"`
    Content string `json:"content"`
    Question string `json:"question"`
    Version string `json:"version"`
    CoffeeTime time.Time `json:"coffeeTime"`
    ProfileUri string `json:"profileUri"`
    Captcha string `json:"g-recaptcha-response"`
    Payload interface{} `json:"payload"`
}
