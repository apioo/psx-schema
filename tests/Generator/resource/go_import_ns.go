
package Foo.Bar

// Import
type Import struct {
    Students My.Import.Map `json:"students"`
    Student My.Import.Student `json:"student"`
}


package Foo.Bar

// MyMap
type MyMap struct {
    *My.Import.Student
}
