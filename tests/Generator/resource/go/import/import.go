package app

import "github.com/apioo/my/import"

type Import struct {
    Students *StudentMap `json:"students"`
    Student *Student `json:"student"`
}

