
// Describes the response of the operation
type Response struct {
    Code int `json:"code"`
    ContentType string `json:"contentType"`
    Schema *PropertyType `json:"schema"`
}

