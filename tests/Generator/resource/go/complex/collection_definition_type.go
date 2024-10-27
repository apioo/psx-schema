
// Base collection type
type CollectionDefinitionType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Deprecated bool `json:"deprecated"`
    Schema *PropertyType `json:"schema"`
}

