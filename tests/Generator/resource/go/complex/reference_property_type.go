
// Represents a reference to a definition type
type ReferencePropertyType struct {
    Deprecated bool `json:"deprecated"`
    Description string `json:"description"`
    Nullable bool `json:"nullable"`
    Type string `json:"type"`
    Target string `json:"target"`
    Template map[string]string `json:"template"`
}

