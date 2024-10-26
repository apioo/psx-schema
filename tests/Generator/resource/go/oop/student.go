type Student struct {
    FirstName string `json:"firstName"`
    Parent *Human `json:"parent"`
    MatricleNumber string `json:"matricleNumber"`
}

