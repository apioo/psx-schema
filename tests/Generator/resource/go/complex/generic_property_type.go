
// Represents a generic value which can be replaced with a dynamic type
type GenericPropertyType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Deprecated bool `json:"deprecated"`
    Nullable bool `json:"nullable"`
    Name string `json:"name"`
}

