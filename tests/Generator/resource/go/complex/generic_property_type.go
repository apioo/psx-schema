
// Represents a generic value which can be replaced with a concrete type
type GenericPropertyType struct {
    Deprecated bool `json:"deprecated"`
    Description string `json:"description"`
    Nullable bool `json:"nullable"`
    Type string `json:"type"`
    Name string `json:"name"`
}

