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
    Parent *Human `json:"parent"`
    Entries []Student `json:"entries"`
}

type HumanMap struct {
    TotalResults int `json:"totalResults"`
    Parent *Human `json:"parent"`
    Entries []Human `json:"entries"`
}

type Map[P any, T any] struct {
    TotalResults int `json:"totalResults"`
    Parent P `json:"parent"`
    Entries []T `json:"entries"`
}

type RootSchema struct {
    Students *StudentMap `json:"students"`
}
