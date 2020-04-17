// Human
type Human struct {
    firstName string `json:"firstName"`
}

// Student
type Student struct {
    *Human
    matricleNumber string `json:"matricleNumber"`
}

// Map
type Map struct {
    totalResults int `json:"totalResults"`
    entries []T `json:"entries"`
}

// RootSchema
type RootSchema struct {
    students Map `json:"students"`
}
