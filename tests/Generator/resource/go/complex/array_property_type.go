
// Represents an array which contains a dynamic list of values of the same type
type ArrayPropertyType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Deprecated bool `json:"deprecated"`
    Nullable bool `json:"nullable"`
    Schema *PropertyType `json:"schema"`
}

