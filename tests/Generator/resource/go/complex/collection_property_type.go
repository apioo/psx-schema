
// Base collection property type
type CollectionPropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Schema *PropertyType `json:"schema"`
}

