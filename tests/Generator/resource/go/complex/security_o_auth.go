type SecurityOAuth struct {
    Type string `json:"type"`
    TokenUrl string `json:"tokenUrl"`
    AuthorizationUrl string `json:"authorizationUrl"`
    Scopes []string `json:"scopes"`
}

