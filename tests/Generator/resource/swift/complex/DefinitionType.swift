// Base definition type
class DefinitionType: Codable {
    var description: String
    var deprecated: Bool
    var _type: String

    enum CodingKeys: String, CodingKey {
        case description = "description"
        case deprecated = "deprecated"
        case _type = "type"
    }
}

