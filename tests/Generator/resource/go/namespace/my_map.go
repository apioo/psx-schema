package Foo.Bar

type MyMap struct {
    MatricleNumber string `json:"matricleNumber"`
    FirstName string `json:"firstName"`
    Parent *My.Import.Human `json:"parent"`
}
