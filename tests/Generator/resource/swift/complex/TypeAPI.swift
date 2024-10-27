// The TypeAPI Root
class TypeAPI: TypeSchema {
    var baseUrl: String
    var security: Security
    var operations: Dictionary<String, Operation>

    enum CodingKeys: String, CodingKey {
        case baseUrl = "baseUrl"
        case security = "security"
        case operations = "operations"
    }
}

