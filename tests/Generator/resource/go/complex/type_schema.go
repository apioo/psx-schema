
// TypeSchema specification
type TypeSchema struct {
    Import map[string]string `json:"import"`
    Definitions map[string]DefinitionType `json:"definitions"`
    Root string `json:"root"`
}

