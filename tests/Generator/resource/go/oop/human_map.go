type HumanMap struct {
    TotalResults int `json:"totalResults"`
    Parent *Human `json:"parent"`
    Entries []Human `json:"entries"`
}

