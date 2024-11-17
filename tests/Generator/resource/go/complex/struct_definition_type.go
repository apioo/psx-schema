
// A struct represents a class/structure with a fix set of defined properties.
type StructDefinitionType struct {
    Deprecated bool `json:"deprecated"`
    Description string `json:"description"`
    Type string `json:"type"`
    Base bool `json:"base"`
    Discriminator string `json:"discriminator"`
    Mapping map[string]string `json:"mapping"`
    Parent *ReferencePropertyType `json:"parent"`
    Properties map[string]PropertyType `json:"properties"`
}

