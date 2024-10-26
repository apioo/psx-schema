type Map[P any, T any] struct {
    TotalResults int `json:"totalResults"`
    Parent P `json:"parent"`
    Entries []T `json:"entries"`
}

