type HumanType struct {
    FirstName string `json:"firstName"`
    Parent *HumanType `json:"parent"`
}

