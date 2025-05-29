class SecurityApiKey: Security {
    var _in: String?
    var name: String?

    enum CodingKeys: String, CodingKey {
        case _in = "in"
        case name = "name"
    }
}

