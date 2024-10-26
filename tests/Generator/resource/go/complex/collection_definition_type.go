
// Base type for the map and array collection type
type CollectionDefinitionType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Schema *PropertyType `json:"schema"`
}

