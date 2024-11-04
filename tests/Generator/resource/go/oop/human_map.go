type HumanMap struct {
    TotalResults int `json:"totalResults"`
    Parent *HumanType `json:"parent"`
    Entries []HumanType `json:"entries"`
}

