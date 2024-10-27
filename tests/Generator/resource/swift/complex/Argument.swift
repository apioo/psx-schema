class Argument: Codable {
    var _in: String
    var schema: PropertyType
    var contentType: String
    var name: String

    enum CodingKeys: String, CodingKey {
        case _in = "in"
        case schema = "schema"
        case contentType = "contentType"
        case name = "name"
    }
}

