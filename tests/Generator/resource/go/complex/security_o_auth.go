type SecurityOAuth struct {
    Type string `json:"type"`
    AuthorizationUrl string `json:"authorizationUrl"`
    Scopes []string `json:"scopes"`
    TokenUrl string `json:"tokenUrl"`
}

