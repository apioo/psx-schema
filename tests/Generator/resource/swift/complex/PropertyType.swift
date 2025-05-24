// Base property type
class PropertyType: Codable {
    var deprecated: Bool?
    var description: String?
    var nullable: Bool?
    var _type: String?

    enum CodingKeys: String, CodingKey {
        case deprecated = "deprecated"
        case description = "description"
        case nullable = "nullable"
        case _type = "type"
    }
}

