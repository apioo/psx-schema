class Security: Codable {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

