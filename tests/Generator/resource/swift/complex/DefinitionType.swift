// Base definition type
class DefinitionType: Codable {
    var deprecated: Bool?
    var description: String?
    var _type: String?

    enum CodingKeys: String, CodingKey {
        case deprecated = "deprecated"
        case description = "description"
        case _type = "type"
    }
}

