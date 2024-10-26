
// Represents an array which contains a dynamic list of values
type ArrayPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Schema *PropertyType `json:"schema"`
}

