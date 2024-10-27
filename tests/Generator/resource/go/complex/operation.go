type Operation struct {
    Method string `json:"method"`
    Path string `json:"path"`
    Return *Response `json:"return"`
    Arguments map[string]Argument `json:"arguments"`
    Throws []Response `json:"throws"`
    Description string `json:"description"`
    Stability int `json:"stability"`
    Security []string `json:"security"`
    Authorization bool `json:"authorization"`
    Tags []string `json:"tags"`
}

