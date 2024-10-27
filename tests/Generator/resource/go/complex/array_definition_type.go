
// Represents an array which contains a dynamic list of values of the same type
type ArrayDefinitionType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Deprecated bool `json:"deprecated"`
    Schema *PropertyType `json:"schema"`
}

