// Describes arguments of the operation
class Argument: Codable {
    var contentType: String?
    var _in: String?
    var name: String?
    var schema: PropertyType?

    enum CodingKeys: String, CodingKey {
        case contentType = "contentType"
        case _in = "in"
        case name = "name"
        case schema = "schema"
    }
}

