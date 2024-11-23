package app

import "github.com/apioo/my/import"

type MyMap struct {
    MatricleNumber string `json:"matricleNumber"`
    FirstName string `json:"firstName"`
    Parent *HumanType `json:"parent"`
}

