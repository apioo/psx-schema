
// Base collection property type
type CollectionPropertyType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Deprecated bool `json:"deprecated"`
    Nullable bool `json:"nullable"`
    Schema *PropertyType `json:"schema"`
}

