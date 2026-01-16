// Represents a map which contains a dynamic set of key value entries of the same type
class MapDefinitionType: CollectionDefinitionType {
    var _type: String? = "map"

    enum CodingKeys: String, CodingKey {
        case _type = "type"
    }
}

