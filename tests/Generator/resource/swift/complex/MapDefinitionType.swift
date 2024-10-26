// Represents a map which contains a dynamic set of key value entries
class MapDefinitionType: CollectionDefinitionType {
    var _type: String

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

