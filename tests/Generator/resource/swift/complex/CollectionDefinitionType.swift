// Base collection type
class CollectionDefinitionType: DefinitionType {
    var schema: PropertyType

    enum CodingKeys: String, CodingKey {
        case schema = "schema"
    }
}

