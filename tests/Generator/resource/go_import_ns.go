package Foo.Bar
type Import struct {
    Students My.Import.StudentMap `json:"students"`
    Student My.Import.Student `json:"student"`
}

package Foo.Bar
type MyMap struct {
    *My.Import.Student
}
