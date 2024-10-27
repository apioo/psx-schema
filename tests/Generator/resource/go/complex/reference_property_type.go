
// Represents a reference to a definition type
type ReferencePropertyType struct {
    Description string `json:"description"`
    Type string `json:"type"`
    Deprecated bool `json:"deprecated"`
    Nullable bool `json:"nullable"`
    Target string `json:"target"`
    Template map[string]string `json:"template"`
}

