class SecurityOAuth: Security {
    var authorizationUrl: String?
    var scopes: Array<String>?
    var tokenUrl: String?

    enum CodingKeys: String, CodingKey {
        case authorizationUrl = "authorizationUrl"
        case scopes = "scopes"
        case tokenUrl = "tokenUrl"
    }
}

