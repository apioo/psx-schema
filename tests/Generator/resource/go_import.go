type Import struct {
    Students StudentMap `json:"students"`
    Student Student `json:"student"`
}

type MyMap struct {
    MatricleNumber string `json:"matricleNumber"`
    FirstName string `json:"firstName"`
}
