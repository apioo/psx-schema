package main

// An simple author element with some description
type Author struct {
    Title string `json:"title"`
    Email string `json:"email"`
    Categories []string `json:"categories"`
    Locations []Location `json:"locations"`
    Origin Location `json:"origin"`
}
