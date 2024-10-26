type StudentMap struct {
    TotalResults int `json:"totalResults"`
    Parent *Human `json:"parent"`
    Entries []Student `json:"entries"`
}

