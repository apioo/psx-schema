// Base property type
class PropertyType: Codable {
    var description: String
    var deprecated: Bool
    var _type: String
    var nullable: Bool

    enum CodingKeys: String, CodingKey {
        case description = "description"
        case deprecated = "deprecated"
        case _type = "type"
        case nullable = "nullable"
    }
}

