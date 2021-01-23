

// Human
type Human struct {
    FirstName string `json:"firstName"`
}



// Student
type Student struct {
    *Human
    MatricleNumber string `json:"matricleNumber"`
}



// Map
type Map struct {
    TotalResults int `json:"totalResults"`
    Entries []T `json:"entries"`
}



// RootSchema
type RootSchema struct {
    Students Map `json:"students"`
}
