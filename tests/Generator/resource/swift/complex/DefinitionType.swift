// Base definition type
class DefinitionType: Codable {
    var description: String
    var _type: String
    var deprecated: Bool

    enum CodingKeys: String, CodingKey {
        case description = "description"
        case _type = "type"
        case deprecated = "deprecated"
    }
}

