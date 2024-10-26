// Base collection property type
class CollectionPropertyType: PropertyType {
    var _type: String
    var schema: PropertyType

    enum CodingKeys: String, CodingKey {
        case _type = "type"
        case schema = "schema"
    }
}

