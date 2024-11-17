
// Represents a map which contains a dynamic set of key value entries of the same type
type MapPropertyType struct {
    Deprecated bool `json:"deprecated"`
    Description string `json:"description"`
    Nullable bool `json:"nullable"`
    Type string `json:"type"`
    Schema *PropertyType `json:"schema"`
}

