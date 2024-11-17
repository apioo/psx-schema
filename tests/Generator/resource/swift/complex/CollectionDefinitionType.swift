// Base collection type
class CollectionDefinitionType: DefinitionType {
    var schema: PropertyType
    var _type: String

    enum CodingKeys: String, CodingKey {
        case schema = "schema"
        case _type = "type"
    }
}

