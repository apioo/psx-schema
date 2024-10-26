// Base type for the map and array collection type
class CollectionDefinitionType: DefinitionType {
    var _type: String
    var schema: PropertyType

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case schema = "schema"
    }
}

