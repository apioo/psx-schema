type Specification struct {
    Import map[string]string `json:"import"`
    Definitions map[string]DefinitionType `json:"definitions"`
    Root string `json:"root"`
}

