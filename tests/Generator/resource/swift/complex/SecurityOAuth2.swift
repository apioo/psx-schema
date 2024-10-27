class SecurityOAuth: Security {
    var tokenUrl: String
    var authorizationUrl: String
    var scopes: Array<String>

    enum CodingKeys: String, CodingKey {
        case tokenUrl = "tokenUrl"
        case authorizationUrl = "authorizationUrl"
        case scopes = "scopes"
    }
}

