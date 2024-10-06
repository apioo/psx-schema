type Human struct {
    FirstName string `json:"firstName"`
    Parent *Human `json:"parent"`
}

type Student struct {
    FirstName string `json:"firstName"`
    Parent *Human `json:"parent"`
    MatricleNumber string `json:"matricleNumber"`
}

type StudentMap struct {
    TotalResults int `json:"totalResults"`
    Entries []Student `json:"entries"`
}

type HumanMap struct {
    TotalResults int `json:"totalResults"`
    Entries []Human `json:"entries"`
}

type Map[T any] struct {
    TotalResults int `json:"totalResults"`
    Entries []T `json:"entries"`
}

type RootSchema struct {
    Students *StudentMap `json:"students"`
}
