
// The TypeAPI Root
type TypeAPI struct {
    Import map[string]string `json:"import"`
    Definitions map[string]DefinitionType `json:"definitions"`
    Root string `json:"root"`
    BaseUrl string `json:"baseUrl"`
    Security *Security `json:"security"`
    Operations map[string]Operation `json:"operations"`
}

