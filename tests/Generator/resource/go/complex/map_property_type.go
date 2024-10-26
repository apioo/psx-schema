
// Represents a map which contains a dynamic set of key value entries
type MapPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Schema *PropertyType `json:"schema"`
}

