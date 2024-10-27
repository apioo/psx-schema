class Response: Codable {
    var code: Int
    var contentType: String
    var schema: PropertyType

    enum CodingKeys: String, CodingKey {
        case code = "code"
        case contentType = "contentType"
        case schema = "schema"
    }
}

