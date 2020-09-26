// Import
type Import struct {
    Students My.Import.Map `json:"students"`
    Student My.Import.Student `json:"student"`
}

// MyMap
type MyMap struct {
    *My.Import.Student
}
