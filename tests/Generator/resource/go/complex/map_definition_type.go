
// Represents a map which contains a dynamic set of key value entries of the same type
type MapDefinitionType struct {
    Deprecated bool `json:"deprecated"`
    Description string `json:"description"`
    Type string `json:"type"`
    Schema *PropertyType `json:"schema"`
}

