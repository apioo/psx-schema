
// Represents a map which contains a dynamic set of key value entries
type MapDefinitionType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Schema *PropertyType `json:"schema"`
}

