type Human struct {
    FirstName string `json:"firstName"`
    Parent *Human `json:"parent"`
}

