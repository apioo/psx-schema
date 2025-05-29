// The TypeAPI Root
class TypeAPI: TypeSchema {
    var baseUrl: String?
    var operations: Dictionary<String, Operation>?
    var security: Security?

    enum CodingKeys: String, CodingKey {
        case baseUrl = "baseUrl"
        case operations = "operations"
        case security = "security"
    }
}

