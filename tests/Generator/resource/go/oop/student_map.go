type StudentMap struct {
    TotalResults int `json:"totalResults"`
    Parent *HumanType `json:"parent"`
    Entries []Student `json:"entries"`
}

