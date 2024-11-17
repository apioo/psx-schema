
// Base collection property type
type CollectionPropertyType struct {
    Deprecated bool `json:"deprecated"`
    Description string `json:"description"`
    Nullable bool `json:"nullable"`
    Type string `json:"type"`
    Schema *PropertyType `json:"schema"`
}

