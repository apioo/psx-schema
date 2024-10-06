type Human struct {
    FirstName string `json:"firstName"`
    Parent *Human `json:"parent"`
}

type Student struct {
    FirstName string `json:"firstName"`
    Parent *Human `json:"parent"`
    MatricleNumber string `json:"matricleNumber"`
}

type StudentMap[T any] struct {
    TotalResults int `json:"totalResults"`
    Entries []T `json:"entries"`
}

type Map[T any] struct {
    TotalResults int `json:"totalResults"`
    Entries []T `json:"entries"`
}

type RootSchema struct {
    Students *StudentMap `json:"students"`
}
