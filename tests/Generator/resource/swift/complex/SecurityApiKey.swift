class SecurityApiKey: Security {
    var name: String
    var _in: String

    enum CodingKeys: String, CodingKey {
        case name = "name"
        case _in = "in"
    }
}

