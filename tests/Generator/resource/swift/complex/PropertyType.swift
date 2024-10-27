// Base property type
class PropertyType: Codable {
    var description: String
    var _type: String
    var deprecated: Bool
    var nullable: Bool

    enum CodingKeys: String, CodingKey {
        case description = "description"
        case _type = "type"
        case deprecated = "deprecated"
        case nullable = "nullable"
    }
}

