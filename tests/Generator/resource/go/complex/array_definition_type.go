
// Represents an array which contains a dynamic list of values
type ArrayDefinitionType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Schema *PropertyType `json:"schema"`
}

