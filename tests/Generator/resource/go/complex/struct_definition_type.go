
// A struct represents a class/structure with a fix set of defined properties.
type StructDefinitionType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Deprecated bool `json:"deprecated"`
    Parent *ReferencePropertyType `json:"parent"`
    Base bool `json:"base"`
    Properties map[string]PropertyType `json:"properties"`
    Discriminator string `json:"discriminator"`
    Mapping map[string]string `json:"mapping"`
}

