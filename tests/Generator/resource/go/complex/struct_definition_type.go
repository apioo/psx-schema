
// Represents a struct which contains a fixed set of defined properties
type StructDefinitionType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Parent string `json:"parent"`
    Base bool `json:"base"`
    Properties map[string]PropertyType `json:"properties"`
    Discriminator string `json:"discriminator"`
    Mapping map[string]string `json:"mapping"`
    Template map[string]string `json:"template"`
}

