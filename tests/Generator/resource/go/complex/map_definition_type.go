
// Represents a map which contains a dynamic set of key value entries of the same type
type MapDefinitionType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Deprecated bool `json:"deprecated"`
    Schema *PropertyType `json:"schema"`
}

