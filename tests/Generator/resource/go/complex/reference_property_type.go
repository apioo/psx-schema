
// Represents a reference to a definition type
type ReferencePropertyType struct {
    Description string `json:"description"`
    Deprecated bool `json:"deprecated"`
    Type string `json:"type"`
    Nullable bool `json:"nullable"`
    Target string `json:"target"`
}

