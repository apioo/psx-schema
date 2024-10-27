
// Represents a map which contains a dynamic set of key value entries of the same type
type MapPropertyType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Deprecated bool `json:"deprecated"`
    Nullable bool `json:"nullable"`
    Schema *PropertyType `json:"schema"`
}

