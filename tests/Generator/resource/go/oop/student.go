type Student struct {
    FirstName string `json:"firstName"`
    Parent *HumanType `json:"parent"`
    MatricleNumber string `json:"matricleNumber"`
}

