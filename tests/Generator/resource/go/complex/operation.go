type Operation struct {
    Arguments map[string]Argument `json:"arguments"`
    Authorization bool `json:"authorization"`
    Description string `json:"description"`
    Method string `json:"method"`
    Path string `json:"path"`
    Return *Response `json:"return"`
    Security []string `json:"security"`
    Stability int `json:"stability"`
    Throws []Response `json:"throws"`
}

