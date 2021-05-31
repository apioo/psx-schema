type Human struct {
    FirstName string `json:"firstName"`
}

type Student struct {
    *Human
    MatricleNumber string `json:"matricleNumber"`
}

type StudentMap = Map

type Map struct {
    TotalResults int `json:"totalResults"`
    Entries []T `json:"entries"`
}

type RootSchema struct {
    Students StudentMap `json:"students"`
}
